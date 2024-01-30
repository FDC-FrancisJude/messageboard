<?php
class UsersController extends AppController {
    public function register() {
        $this->loadModel('Profile');
        
        if ($this->Auth->loggedIn()) {
            return $this->redirect($this->Auth->redirectUrl());
        }
        if ($this->request->is('post')) {
            $this->User->set($this->request->data);
    
            $email = $this->request->data['User']['email'];
            $existingUser = $this->User->findByEmail($email);
    
            if ($existingUser) {
                $this->Flash->error(__('Email is already registered. Please use a different email address.'));
            } else {
                if ($this->User->validates()) {
                    $createdIp = $this->request->clientIp();
                    $this->request->data['User']['created_at_ip'] = $createdIp;
                    if ($this->User->save($this->request->data)) {
                        //$this->Auth->login($this->User->id);
                        //$this->Flash->success(__('Registration successful. You are now logged in.'));
                        $userId = $this->User->id;
                        $userData = $this->User->findById($userId);
                        $userDataArray = $userData['User'];
                        $this->Session->write('login_success', $userDataArray);
                        $this->Profile->create();
                        $profileData = [
                            'user_id' => $userId,
                            'name' => $this->request->data['User']['name'],
                            'created_at_ip' => $createdIp,
                        ];
                        $this->Profile->save($profileData);
                        $this->redirect(['controller' => 'users', 'action' => 'welcome']);
                    } else {
                        $this->Flash->error(__('Error saving user data. Please try again.'));
                    }
                } else {
                    $this->Flash->error(__('Please check the error field.'));
                }
            }
        }
    }

    public function proceed() {
        return $this->redirect($this->Auth->redirectUrl());
        $this->Session->delete('login_success');
    }

    public function welcome() {
        if ($this->Auth->loggedIn()) {
            $this->Flash->error(__('Unauthorized access. Redirect to message list.'));
            return $this->redirect($this->Auth->redirectUrl());
        } else {
            $userData = $this->Session->read('login_success');
            $this->Auth->login($userData);
        }
        
    }
    
    public function login() {
        if ($this->Auth->loggedIn()) {
            return $this->redirect($this->Auth->redirectUrl());
        }
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $user = $this->Auth->user();
                $timezone = new DateTimeZone('Asia/Manila');
                $now = new DateTime('now', $timezone);
                $this->User->id = $user['id']; 
                $this->User->saveField('last_login_time', $now->format('Y-m-d H:i:s'));
                $this->Session->write('login_success', $user);
                return $this->redirect($this->Auth->redirectUrl());
                //$this->redirect(['controller' => 'message', 'action' => 'index']);
            } else {
                $this->Flash->error('Email and password are incorrect.');
            }
        }
    }
    public function logout() {
        $this->Session->destroy();
        $this->Flash->success(__('You have been logged out.'));
        return $this->redirect($this->Auth->logout());
        //$this->redirect(['controller' => 'users', 'action' => 'login']);
    }
}
