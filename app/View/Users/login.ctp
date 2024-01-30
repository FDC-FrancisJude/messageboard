<div class="container mt-5">
    <div lass="row">
        <div class="col-md-4 offset-md-4">
            <div class="card">
                <div class="card-body">
                    <h1 class="mb-4 text-center">LOGIN</h1>
                    <?php
                        echo $this->Form->create('User', ['id' => 'loginForm', 'class' => 'needs-validation', 'novalidate' => true]);
                        
                        echo $this->Form->input('email', [
                            'class' => 'form-control mb-3',
                            'required' => true,
                            'placeholder' => 'Enter email address',
                        ]);

                        echo $this->Form->input('password', [
                            'class' => 'form-control mb-3',
                            'type' => 'password',
                            'required' => true,
                            'placeholder' => 'Enter password',
                        ]);

                        echo $this->Form->button('Login', ['class' => 'btn btn-success mb-3', 'type' => 'submit']);

                        echo $this->Form->end();

                        echo $this->Html->link('Need an account? Register here', ['controller' => 'users', 'action' => 'register'], ['class' => 'btn btn-link']);
                    ?>
                </div>
            </div>
        </div>
    </div>
    
</div>