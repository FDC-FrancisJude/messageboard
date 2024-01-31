<?php
App::uses('AuthComponent', 'Controller/Component');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class Message extends AppModel {
    public $belongsTo = array(
        'Sender' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'fields' => array('Sender.id', 'Sender.name', 'Sender.email'),
        ),
        'Recipient' => array(
            'className' => 'User',
            'foreignKey' => 'to_user_id',
            'fields' => array('Recipient.id', 'Recipient.name', 'Recipient.email'),
        ),
    );

    public $hasMany = array(
        'MessageDetail' => array(
            'className' => 'MessageDetail',
            'foreignKey' => 'message_list_id',
            'order' => 'MessageDetail.created_at DESC',
            'limit' => 1
        )
    );

    public $hasOne = array(
        'SenderProfile' => array(
            'className' => 'Profile',
            'foreignKey' => false,
            'conditions' => array('SenderProfile.user_id = Sender.id')
        ),
        'RecipientProfile' => array(
            'className' => 'Profile',
            'foreignKey' => false,
            'conditions' => array('RecipientProfile.user_id = Recipient.id')
        ),
    );

    public $useTable = 'message_list';

    public $validate = array(
        'to_user_id' => array(
            'to_user_id' => array(
                'rule' => array('notBlank'),
                'message' => 'At least one recipient is required',
            ),
        ),
        'message_content' => array(
            'message_content' => array(
                'rule' => array('notBlank'),
                'message' => 'Message content is required',
            ),
        ),
    );
}

?>
