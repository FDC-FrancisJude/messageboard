<?php
class ProfileController extends AppController {
    public $belongsTo = 'User';
    public $uses = array('User', 'Profile');

    public function index() {
        
    }

    public function update() {
        $loggedInUser = $this->Auth->user();
        $userId = $loggedInUser['id'];
        $userEmail = $loggedInUser['email'];
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Profile->set($this->request->data);

            if ($this->Profile->validates()) {
                // Save the updated profile data
                $this->Profile->save($this->request->data);

                $this->Flash->success('Profile updated successfully.');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error('There was an error updating your profile.');
            }
        }
	}
}