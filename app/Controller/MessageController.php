<?php
App::uses('AppController', 'Controller');
class MessageController extends AppController {
    public $uses = array('User', 'Profile');

    public function index() {
        $loggedInUserId = $this->Auth->user('id');
        // $data = $this->User->find('all');
        // $this->set('users', $data);

        $data = $this->Profile->find('all', array(
            'conditions' => array('Profile.user_id' => $loggedInUserId)
        ));
        $this->set('profile', $data);
    }
}