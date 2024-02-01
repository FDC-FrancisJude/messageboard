<?php
App::uses('AuthComponent', 'Controller/Component');

class Message extends AppModel {
    public $useTable = 'message_list';

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
            'limit' => 1,
            'dependent' => true 
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

    public $validate = array(
        'to_user_id' => array(
            'rule' => 'notBlank',
            'message' => 'At least one recipient is required',
        ),
        'message_content' => array(
            'rule' => 'notBlank',
            'message' => 'Message content is required',
        ),
    );
}
