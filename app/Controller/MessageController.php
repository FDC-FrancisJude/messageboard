<?php
App::uses('AppController', 'Controller');
class MessageController extends AppController
{
    public $uses = array('User', 'Profile', 'Message', 'MessageDetail');
    public $helpers = array('Js', 'TimeAgo');

    public $limit = 2;

    public function add() {
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            $response = array();

            try {
                $message_content = $this->request->data['MessageDetail']['message_content'];
                $sender_user_id = $this->request->data['MessageDetail']['sender_user_id'];
                $message_list_id = $this->request->data['MessageDetail']['message_list_id'];

                $this->loadModel('MessageDetail');

                $dataToSave = array(
                    'message_content' => $message_content,
                    'sender_user_id' => $sender_user_id,
                    'message_list_id' => $message_list_id,
                    'created_at_ip' => $this->request->clientIp()
                );

                if ($this->MessageDetail->save($dataToSave)) {
                    $response['status'] = 'success';
                    $response['message'] = 'Data saved successfully';
                } else {
                    throw new Exception('Failed to save data.');
                }
            } catch (Exception $e) {
                $response['status'] = 'error';
                $response['message'] = $e->getMessage();
            }

            $this->response->type('json');
            echo json_encode($response);
            exit;
        }
    }

    public function index() {
    }

    public function view($id = null) {
        $loggedInUserId = $this->Auth->user('id');
        if (!$id) {
            $this->redirect(array('controller' => 'message', 'action' => 'index'));
        }

        $result = $this->Message->find('first', array(
            'conditions' => array(
                'Message.id' => $id
            )
        ));
    
        if (!$result) {
            $this->Flash->error(__('Message not found.'));
            $this->redirect(array('controller' => 'message', 'action' => 'index'));
        }
        $this->Session->write('messagID', $id);
        $this->set('messagID', $id);
        
        if ($loggedInUserId == $result["Sender"]["id"]) {
            $toName = $result["Recipient"]["name"];
            $toDetails = $result["RecipientProfile"];
        } else{
            $toName = $result["Sender"]["name"];
            $toDetails = $result["SenderProfile"];
        }
        $this->set('messageToUserName', $toName );
        $this->set('messageToUserDetails', $toDetails);
    }
    public function messageDetailsData() {
        $offset = isset($_GET['offset']) ? $_GET['offset'] : false;
        $limit = 10;
        $loggedInUserId = $this->Auth->user('id');
        $this->loadModel('MessageDetail');
        $messageId = $this->Session->read('messagID');
        $this->autoRender = false;
        $query =  array(
            'conditions' => array(
                'MessageDetail.message_list_id' => $messageId,
                'MessageDetail.deleted' => 0,
            ),
            'limit' => $limit,
            'offset' => $offset,
            'fields' => array(
                'MessageDetail.id',
                'MessageDetail.message_content',
                'MessageDetail.sender_user_id',
                'MessageDetail.created_at',
                'MessageDetail.deleted',
                'Message.*',
                'SenderProfile.*',
                'RecipientProfile.*',
                'SenderUserProfile.*'
            ),
            'order' => 'MessageDetail.created_at DESC',
            'joins' => array(
                array(
                    'table' => 'message_list',
                    'alias' => 'Message',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Message.id = MessageDetail.message_list_id'
                    )
                ),
                array(
                    'table' => 'profile',
                    'alias' => 'SenderProfile',
                    'type' => 'INNER',
                    'conditions' => array(
                        'SenderProfile.user_id = Message.user_id'
                    )
                ),
                array(
                    'table' => 'profile',
                    'alias' => 'RecipientProfile',
                    'type' => 'INNER',
                    'conditions' => array(
                        'RecipientProfile.user_id = Message.to_user_id'
                    )
                ),
                array(
                    'table' => 'profile',
                    'alias' => 'SenderUserProfile', 
                    'type' => 'INNER',
                    'conditions' => array(
                        'SenderUserProfile.user_id = MessageDetail.sender_user_id'
                    )
                )
            )
        );

        if ($offset === false) {
            
            unset($query['offset']);
        }

        $data = $this->MessageDetail->find('all', $query);
        
        unset($query['limit']);
        unset($query['offset']);
        $dataAllCount = $this->MessageDetail->find('count', $query);
        if ($data > 0 && $dataAllCount > 0) {
            $loginUserData = array(
                'loggedInUserId' => $loggedInUserId,
                'messageName' => $loggedInUserId == $data[0]['Message']['user_id'] ? $data[0]['RecipientProfile']['name'] : $data[0]['SenderProfile']['name'],
                'messages' => $data,
                'dataAllCount' => $dataAllCount,
                'offset' => $offset,
                'limit' => $limit
            );
        } else {
            $loginUserData = array();
        }
        

        $this->response->type('json');
        $this->response->body(json_encode($loginUserData));
        return $this->response;
    }

    public function getLatestReply() {
        $offset = $_GET['offset'];
        $limit = 10;
        $loggedInUserId = $this->Auth->user('id');
        $this->loadModel('MessageDetail');
        $messageId = $this->Session->read('messagID');
        $this->autoRender = false;
        $query =  array(
            'conditions' => array(
                'MessageDetail.message_list_id' => $messageId,
                'MessageDetail.deleted' => 0,
            ),
            'limit' => $limit,
            'offset' => $offset,
            'fields' => array(
                'MessageDetail.id',
                'MessageDetail.message_content',
                'MessageDetail.sender_user_id',
                'MessageDetail.created_at',
                'MessageDetail.deleted',
                'Message.*',
                'SenderProfile.*',
                'RecipientProfile.*',
                'SenderUserProfile.*'
            ),
            'order' => 'MessageDetail.created_at DESC',
            'joins' => array(
                array(
                    'table' => 'message_list',
                    'alias' => 'Message',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Message.id = MessageDetail.message_list_id'
                    )
                ),
                array(
                    'table' => 'profile',
                    'alias' => 'SenderProfile',
                    'type' => 'INNER',
                    'conditions' => array(
                        'SenderProfile.user_id = Message.user_id'
                    )
                ),
                array(
                    'table' => 'profile',
                    'alias' => 'RecipientProfile',
                    'type' => 'INNER',
                    'conditions' => array(
                        'RecipientProfile.user_id = Message.to_user_id'
                    )
                ),
                array(
                    'table' => 'profile',
                    'alias' => 'SenderUserProfile', 
                    'type' => 'INNER',
                    'conditions' => array(
                        'SenderUserProfile.user_id = MessageDetail.sender_user_id'
                    )
                )
            )
        );
        $data = $this->MessageDetail->find('first', $query);
        

        $dataAllCount = $this->MessageDetail->find('count', $query);
        if ($data > 0 && $dataAllCount > 0) {
            $loginUserData = array(
                'loggedInUserId' => $loggedInUserId,
                'messageName' => $loggedInUserId == $data[0]['Message']['user_id'] ? $data[0]['RecipientProfile']['name'] : $data[0]['SenderProfile']['name'],
                'messages' => $data,
                'dataAllCount' => $dataAllCount,
                'offset' => $offset,
                'limit' => $limit
            );
        } else {
            $loginUserData = array();
        }
        

        $this->response->type('json');
        $this->response->body(json_encode($loginUserData));
        return $this->response;
    }

    public function deleteMessage($id) {
        $this->Message->delete($id);

        $data = ['success' => true, 'message' => 'Record and related details deleted successfully'];
        $this->response->type('json');
        $this->response->body(json_encode($data));
        return $this->response;
    }
    public function deleteDetails($id) {
        $this->loadModel('MessageDetail');
        $this->MessageDetail->findById(12);
        $this->MessageDetail->id = $id;
        $this->MessageDetail->set('deleted', '1');
        $this->MessageDetail->save();
        $data = ['success' => true, 'message' => 'Record and related details deleted successfully'];
        $this->response->type('json');
        $this->response->body(json_encode($data));
        return $this->response;
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

    public function messageListData() {
        $search = isset($_GET['search']) ? $_GET['search'] : null;
        $search = strtolower(str_replace(' ', '', $search));
        $this->autoRender = false;
        $loggedInUserId = $this->Auth->user('id');

        $conditions = array(
            'OR' => array(
                'Message.user_id' => $loggedInUserId,
                'Message.to_user_id' => $loggedInUserId,
            ),
        );

        

        $data = $this->Message->find('all', array(
            'conditions' => $conditions,
            'joins' => array(
                array(
                    'table' => 'message_details',
                    'alias' => 'MessageDetail',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Message.id = MessageDetail.message_list_id'
                    )
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
        ));
        $datas = [];

        foreach ($data as $key => $value) {
            if ($search == 'all' || $search == '' ) {
                $datas[] = $value;
            } else {
                if ($value["Sender"]["id"] == $loggedInUserId) {
                  
                    $name =   strtolower(str_replace(' ', '', $value["Recipient"]["name"]));
                    if (strpos($name, $search) !== false) {
                        $datas[] = $value;
                    }
                } else {
                    $name = strtolower(str_replace(' ', '', $value["Sender"]["name"]));
                    if (strpos($name, $search) !== false) {
                        $datas[] = $value;
                    }
                }
            }
            
        }
        

        $MessageData = array(
            'loggedInUserId' => $loggedInUserId,
            'messages' => $datas
        );


        $this->response->type('json');
        $this->response->body(json_encode($MessageData));
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

            $existingMessage = $this->Message->find('first', array(
                'conditions' => array(
                    'OR' => array(
                        array(
                            'Message.user_id' => $loggedInUserId,
                            'Message.to_user_id' => $selectedToUserId
                        ),
                        array(
                            'Message.user_id' => $selectedToUserId,
                            'Message.to_user_id' => $loggedInUserId
                        )
                    )
                )
            ));

            if ($existingMessage) {
                $messageContent = $this->request->data['Message']['message_content'];

                $this->Message->MessageDetail->create();
                $detailData = array(
                    'message_list_id' => $existingMessage['Message']['id'],
                    'message_content' => $messageContent,
                    'created_at_ip' => $this->request->clientIp(),
                    'sender_user_id' => $loggedInUserId,
                );

                if ($this->Message->MessageDetail->save($detailData)) {
                    $this->Flash->success(__('Message sent successfully.'));
                    $messageId = $existingMessage['Message']['id'];
                    return $this->redirect(array('action' => 'view/' . $messageId));
                } else {
                    $this->Flash->error(__('Error saving message details.'));
                }
            } else {
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
                            'sender_user_id' => $loggedInUserId,
                        );

                        if ($this->Message->MessageDetail->save($detailData)) {
                            $this->Flash->success(__('Message sent successfully.'));
                            return $this->redirect(array('action' => 'view/' . $messageId));
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
