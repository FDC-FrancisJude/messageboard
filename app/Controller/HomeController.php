<?php
class HomeController extends AppController {
    public function index() {
        $lastIdInserted = $this->Session->check('lastIdInserted');
        $this->Session->write('userId', $lastIdInserted);

        $userId = $this->Session->check('userId');
        if (!$userId) {
            $this->redirect(['controller' => 'home', 'action' => 'index']);
        }
    }
    public function logout() {
        $this->Session->destroy();
        $this->redirect(['controller' => 'login', 'action' => 'index']);
    }
}
?>