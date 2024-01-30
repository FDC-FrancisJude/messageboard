<?php
App::uses('Security', 'Utility');

class Login extends AppModel {
    public $useTable = 'users';
    public $validate = array(
        'email' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Email is required',
            ),
            'validEmail' => array(
                'rule' => array('email'),
                'message' => 'Please enter a valid email address',
            )
        ),
        'password' => array(
            'password' => array(
                'rule' => array('notBlank'),
                'message' => 'Password is required',
            ),
        ),
    );
}
?>
