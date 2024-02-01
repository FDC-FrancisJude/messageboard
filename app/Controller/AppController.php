<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

App::uses('Router', 'Routing');




/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		https://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $components = array(
        'Flash',
        'Session',
        'Auth' => [
            'loginAction' => [
                'controller' => 'users',
                'action' => 'login',
            ],
            'authenticate' => [
                'Form' => [
                    'fields' => ['username' => 'email', 'password' => 'password'],
                ],
            ],
            'loginRedirect' => [
                'controller' => 'message',
                'action' => 'index',
            ],
            'logoutRedirect' => [
                'controller' => 'users',
                'action' => 'login',
            ],
        ],
    );

    public function beforeFilter() {
        $this->Auth->allow('register', 'login');
        if($this->Session->read('login_success')){
            $this->Auth->allow('welcome');
        }
        
        $isLogin = $this->Auth->loggedIn();
        $this->set('is_login', $isLogin);
        $loginUser = $this->Auth->user();
        $this->set('login_user', $loginUser);

        if ($isLogin) {
            $loggedInUserId = $loginUser['id'];
            
            $this->loadModel('User');
            $this->loadModel('Profile');

            $userData = $this->User->find('first', array(
                'conditions' => array('User.id' => $loggedInUserId),
                'contain' => array('Profile'),
            ));
            $this->set('users', $userData);
            $this->set('appRoot', Router::url('/', true));
        }
    }
}
