<?php
class ProfileController extends AppController {
    public $belongsTo = 'User';
    public $uses = array('User', 'Profile');

    public function index() {
        
    }

    public function update() {
        $loggedInUser = $this->Auth->user();
        $userId = $loggedInUser['id'];
    
        if ($this->request->is(['post', 'put'])) {

            if (!empty($this->request->data['Profile']['profile_pic_img']['name'])) {
                $file = $this->request->data['Profile']['profile_pic_img'];
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = 'profile_pic_' . time() . '.' . $ext;
                $uploadPath = WWW_ROOT . 'img' . DS;

                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
    
                $uploadFile = $uploadPath . $filename;
    
                if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
                    $this->request->data['Profile']['profile_pic'] = $filename;
                } else {
                    $this->Flash->error('Failed to upload profile picture.');
                    return;
                }
            }
            $newEmail = $this->request->data['Profile']['email'];
    
            $conditions = [
                'User.email' => $newEmail,
                'User.id !=' => $userId
            ];
    
    
            $existingUser = $this->User->find('first', [
                'conditions' => $conditions
            ]);
    
            $this->Profile->id = $userId;
    
            $this->Profile->set($this->request->data);
            $this->User->set([
                'id' => $userId,
                'name' => $this->request->data['Profile']['name'],
                'email' => $newEmail
            ]);
    
            if ($this->Profile->validates() && $this->User->validates()) {
                if ($existingUser) {
                    $this->Flash->error('Email is already in use by another user.');
                } else {
                    try {
                        $this->Profile->begin();
                        $this->User->begin();
        
                        if ($this->Profile->save($this->request->data)) {
        
                            $this->User->save([
                                'id' => $userId,
                                'name' => $this->request->data['Profile']['name'],
                                'email' => $newEmail
                            ]);
        
                            $this->Profile->commit();
                            $this->User->commit();
        
                            $this->Flash->success('Profile information updated successfully.');
                            $this->redirect(['action' => 'index']);
                        } else {
                            $this->Flash->error('There was an error saving the profile data.');
                        }
                    } catch (Exception $e) {
                        $this->Profile->rollback();
                        $this->User->rollback();
        
                        $this->Flash->error('There was an error updating your profile information.');
                    }
                }
                
            } else {
                $this->Flash->error('Please check the required filled.');
            }
        }
    }
    
}