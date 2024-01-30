<div class="container mt-5">
    <div lass="row">
        <div class="col-md-4 offset-md-4">
            <div class="card">
                <div class="card-body">
                    <h1 class="mb-4 text-center">LOGIN</h1>
                    <?php
                    echo $this->Form->create('Login', array('id' => 'loginForm', 'class' => 'needs-validation', 'novalidate' => true));
                    echo $this->Form->input('email', array('class' => 'form-control mb-3', 'required' => true, 'placeholder' => 'Enter email address'));
                    echo $this->Form->input('password', array('class' => 'form-control mb-3', 'type' => 'password', 'required' => true, 'placeholder' => 'Enter password'));
                    echo $this->Form->end(['label' => 'Login']);
                    ?>
                </div>
            </div>
        </div>
    </div>
    
</div>