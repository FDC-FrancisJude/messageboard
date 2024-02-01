<?php
    class MessageDetail extends AppModel {
        public $useTable = 'message_details';

        public $belongsTo = array(
            'Message' => array(
                'className' => 'Message',
                'foreignKey' => 'message_list_id',
            )
        );
    }
?>