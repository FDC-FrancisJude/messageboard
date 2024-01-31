<div class="container">
    <div class="card">
        <div class="card-header">
            Update Account
        </div>
        <div class="card-body">
            <div class="row g-0">
                <div class="col-md-12">
                    <?php
                        $emailValue = isset($this->request->data['Account']['email']) ? $this->request->data['Account']['email'] : $users['User']['email'];
                        echo $this->Form->create('Account', array('id' => 'accountForm', 'class' => 'needs-validation', 'novalidate' => true));
                        echo $this->Form->input('email', array(
                            'class' => 'form-control',
                            'label' => array('class' => 'form-label'),
                            'label' => 'Email',
                            'value' => $emailValue, 
                        ));
                        echo $this->Form->input('password', array(
                            'class' => 'form-control',
                            'label' => array('class' => 'form-label'),
                            'label' => 'New Password',
                        ));
                        echo $this->Form->input('verify_password', array(
                            'type' => 'password',
                            'class' => 'form-control',
                            'label' => array('class' => 'form-label'),
                            'label' => 'Verify New Password',
                        ));
                        echo $this->Form->button('Update Account', ['class' => 'btn btn-success mb-3', 'type' => 'submit']);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
