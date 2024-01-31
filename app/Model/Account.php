<?php
   // app/Model/Account.php

class Account extends AppModel {
    public $useTable = 'profile'; // Corrected table name

    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
        )
    );

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
            'comparePasswords' => array(
                'rule' => array('comparePasswords'),
                'message' => 'Passwords do not match',
            )
        ),
        'verify_password' => array(
            'verify' => array(
                'rule' => array('notBlank'),
                'message' => 'Please verify your password',
            ),
            'comparePasswords' => array(
                'rule' => array('comparePasswords'),
                'message' => 'Passwords do not match',
            )
        ),
    );

    public function comparePasswords() {
        return $this->data[$this->alias]['password'] === $this->data[$this->alias]['verify_password'];
    }

    public function beforeSave($options = array()) {
        if (isset($this->data['User']['password'])) {
            App::uses('AuthComponent', 'Controller/Component'); // Import AuthComponent
            $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
        }
        return true;
    }
}

?>