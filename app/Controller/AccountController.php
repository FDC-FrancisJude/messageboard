<?php
    class AccountController extends AppController {
        public $uses = array('Account'); // Load the Account model

        public function index() {
            if ($this->request->is(['post', 'put'])) {
                $userId = $this->Auth->user('id');
                $this->Account->User->id = $userId;
        
                $existingEmail = $this->Account->User->field('email', array('id' => $userId));
        
                $this->Account->set($this->request->data);
        
                if ($this->Account->validates()) {
                    $newEmail = $this->request->data['Account']['email'];
        
                    if ($newEmail !== $existingEmail) {
                        if ($this->Account->User->hasAny(array('email' => $newEmail))) {
                            $this->Flash->error('Email is already in use. Please choose a different email.');
                        } else {
                            $this->Account->User->saveField('email', $newEmail);
                            $this->Account->User->saveField('password', $this->request->data['Account']['password']);
                            $this->Flash->success('Account updated successfully.');
                            $this->redirect(['action' => 'index']);
                        }
                    } else {
                        $this->Account->User->saveField('password', $this->request->data['Account']['password']);
                        $this->Flash->success('Account updated successfully.');
                        $this->redirect(['action' => 'index']);
                    }
                } else {
                    $this->Flash->error('Unable to update account. Please correct the errors.');
                }
            } else {
                $userId = $this->Auth->user('id');
                $this->request->data = $this->Account->User->findById($userId);
            }
        }
        
    }
?>
