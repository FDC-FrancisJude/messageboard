<?php
App::uses('AppController', 'Controller');
class MessageController extends AppController {
    public $uses = array('User', 'Profile', 'Message');
    public $helpers = array('Js', 'TimeAgo');

    public $limit = 2;
    
    public function index() {
        $limit = $this->limit;
        $loggedInUserId = $this->Auth->user('id');

        $data = $this->Message->find('all', array(
            'conditions' => array(
                'OR' => array(
                    'Message.user_id' => $loggedInUserId,
                    'Message.to_user_id' => $loggedInUserId,
                )
            ),
            'contain' => array(
                'Sender' => array(
                    'fields' => array('Sender.id', 'Sender.name', 'Sender.email', 'SenderProfile.*'),
                ),
                'Recipient' => array(
                    'fields' => array('Recipient.id', 'Recipient.name', 'Recipient.email', 'RecipientProfile.*'),
                ),
                'MessageDetail' => array(
                    'fields' => array('MessageDetail.id', 'MessageDetail.content', 'MessageDetail.created_at'),
                    'limit' => 1,
                    'order' => 'MessageDetail.created_at DESC',
                ),
            ),
            'order' => 'Message.created_at ASC',
            'group' => 'Message.id',
            'limit' => $limit,
        ));
        
        $this->set('messagelists', $data);
        $this->set('limit', $limit);
    }

    public function display($filename) {
        $this->response->type('image/png');
        $file = WWW_ROOT . 'img' . DS . $filename;

        if (file_exists($file)) {
            $this->response->body(file_get_contents($file));
            return $this->response;
        } else {
            throw new NotFoundException(__('Image not found'));
        }
    }

    public function loadMore($limit) {
        $this->autoRender = false; 
        $loggedInUserId = $this->Auth->user('id');
    
        $data = $this->Message->find('all', array(
            'conditions' => array(
                'OR' => array(
                    'Message.user_id' => $loggedInUserId,
                )
            ),
            'contain' => array(
                'Sender' => array(
                    'fields' => array('Sender.id', 'Sender.name')
                ),
                'Recipient' => array(
                    'fields' => array('Recipient.id', 'Recipient.name')
                ),
                'MessageDetail' => array(
                    'fields' => array('MessageDetail.id', 'MessageDetail.content', 'MessageDetail.created_at')
                )
            ),
            'order' => 'Message.created_at ASC',
            'group' => 'Message.id',
            'limit' => $limit,
        ));
    

    
        $this->response->type('json');
        $this->response->body(json_encode($data));
        return $this->response;
    }
    

    
    public function new() {
        $loggedInUserId = $this->Auth->user('id');
    
        // $users = $this->User->find('list', array(
        //     'fields' => array('User.id', 'User.name'),
        //     'conditions' => array('User.id !=' => $loggedInUserId),
        // ));
        // print_r($users );
        // $this->set('recipient', $users);

        $usersData = $this->User->find('all', array(
            'fields' => array('User.id', 'User.name', 'Profile.profile_pic'),
            'conditions' => array('User.id !=' => $loggedInUserId),
            'order' => 'User.name ASC',
            'joins' => array(
                array(
                    'table' => 'profile',
                    'alias' => 'ProfileJoin', // Use a different alias for the join condition
                    'type' => 'INNER',
                    'conditions' => array(
                        'ProfileJoin.user_id = User.id'
                    )
                )
            )
        ));

        $users = [];
        foreach ($usersData as $userData) {
            $users[$userData['User']['id']] = array(
                'name' => $userData['User']['name'],
                'profile_pic' => $userData['Profile']['profile_pic']
            );
        }
        

        $this->set('recipient', $users);
    
        if ($this->request->is('post')) {
            $this->request->data['Message']['user_id'] = $loggedInUserId;
            $this->request->data['Message']['created_at_ip'] = $this->request->clientIp();
            $selectedToUserId = reset($this->request->data['Message']['to_user_id']);
            $this->request->data['Message']['to_user_id'] = $selectedToUserId;
        
            // Check if a message to the same user already exists
            $existingMessage = $this->Message->find('first', array(
                'conditions' => array(
                    'Message.user_id' => $loggedInUserId,
                    'Message.to_user_id' => $selectedToUserId
                )
            ));
        
            if ($existingMessage) {
                // If message already exists, update the details only
                $messageContent = $this->request->data['Message']['message_content'];
        
                $this->Message->MessageDetail->create();
                $detailData = array(
                    'message_list_id' => $existingMessage['Message']['id'],
                    'message_content' => $messageContent,
                    'created_at_ip' => $this->request->clientIp(),
                );
        
                if ($this->Message->MessageDetail->save($detailData)) {
                    $this->Flash->success(__('Message details added successfully.'));
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Flash->error(__('Error saving message details.'));
                }
            } else {
                // If message doesn't exist, create a new message and details
                $this->Message->set($this->request->data);
        
                if ($this->Message->validates()) {
                    $messageContent = $this->request->data['Message']['message_content'];
        
                    if ($this->Message->save($this->request->data)) {
                        $messageId = $this->Message->getLastInsertID();
                        $this->Message->MessageDetail->create();
                        $detailData = array(
                            'message_list_id' => $messageId,
                            'message_content' => $messageContent,
                            'created_at_ip' => $this->request->clientIp(),
                        );
        
                        if ($this->Message->MessageDetail->save($detailData)) {
                            $this->Flash->success(__('Message sent successfully.'));
                            return $this->redirect(array('action' => 'index'));
                        } else {
                            $this->Flash->error(__('Error saving message details.'));
                        }
                    } else {
                        $this->Flash->error(__('Error saving message.'));
                    }
                } else {
                    $this->Flash->error(__('Please check the error fields.'));
                }
            }
        }



        
        
    }
    

    
}