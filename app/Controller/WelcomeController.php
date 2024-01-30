<?php
class WelcomeController extends AppController {
    
    public function index() {
        if (!$this->Auth->loggedIn()) {
            $this->Flash->error(__('Unauthorized access. Please register first.'));
            $this->redirect(['controller' => 'login', 'action' => 'index']);
        }
    }

}
?>
