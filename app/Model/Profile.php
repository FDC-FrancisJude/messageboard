<?php
class Profile extends AppModel {
    public $useTable = 'profile';

    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
        )
    );

    public $validate = array(
        'name' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Name is required',
            ), 
            'length' => array(
                'rule' => array('lengthBetween', 5, 20),
                'message' => 'Name must be between 5 and 20 characters',
            )
        ),
        'profile_pic' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Profile is required',
            ), 
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
        'birthday' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Birthday is required',
            ),
            'date' => array(
                'rule' => array('date'),
                'message' => 'Invalid date format for birthday',
                'allowEmpty' => true,
            ),
        ),
        
        'gender' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Gender is required',
            ),
            'inList' => array(
                'rule' => array('inList', array('Male', 'Female')),
                'message' => 'Invalid gender value',
            )
        ),
        'hubby' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Gender is required',
            ),
        ),
    );
}
?>
