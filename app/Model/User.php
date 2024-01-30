<?php
App::uses('AuthComponent', 'Controller/Component');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {
    public $hasOne = 'Profile';
    public $useTable = 'users';
    
    public $validate = array(
        'name' => array(
            'name' => array(
                'rule' => array('notBlank'),
                'message' => 'Name is required',
            ), 
            'length' => array(
                'rule' => array('lengthBetween', 5, 20),
                'message' => 'Name must be between 5 and 20 characters',
            )
        ),
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
            $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
        }
        return true;
    }
}
?>
