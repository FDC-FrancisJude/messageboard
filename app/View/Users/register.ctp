<div class="container mt-5">
    <div lass="row">
        <div class="col-md-4 offset-md-4">
            <div class="card">
                <div class="card-body">
                    <h1 class="mb-4 text-center">REGISTER</h1>
                    <?php
                    echo $this->Form->create('User', array('id' => 'UserForm', 'class' => 'needs-validation', 'novalidate' => true));
                    echo $this->Form->input('name', array('class' => 'form-control mb-3', 'required' => true, 'placeholder' => 'Enter name'));
                    echo $this->Form->input('email', array('class' => 'form-control mb-3', 'required' => true, 'placeholder' => 'Enter email address'));
                    echo $this->Form->input('password', array('class' => 'form-control mb-3', 'type' => 'password', 'required' => true, 'placeholder' => 'Enter password'));
                    echo $this->Form->input('verify_password', array('class' => 'form-control mb-3', 'type' => 'password', 'required' => true, 'placeholder' => 'Enter password again'));
                    echo $this->Form->end(['label' => 'Register', 'class' => 'btn btn-success btn-sm']);
                    echo $this->Html->link('Already have an account? Login here', ['controller' => 'users', 'action' => 'login'], ['class' => 'btn btn-link']);
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var UserName = document.getElementById('UserName');
            var UserEmail = document.getElementById('UserEmail');
            var addErrorDiv;

            UserName.addEventListener('input', function(event) {
                validateName();
            });

            UserEmail.addEventListener('input', function(event) {
                validateEmail();
            });

            function validateName() {
                var UserNameValue = UserName.value.trim();
                var checkNameError = document.querySelector(".input.text.required.error input[id='UserName']");
                var divClassName = document.querySelector('.input.text.required');
                var errorName = document.querySelector('.error-message');

                if (UserNameValue.length < 5 || UserNameValue.length > 20) {
                    if (!checkNameError) {
                        divClassName.classList.add('error');
                        addErrorDiv = document.createElement('div');
                        addErrorDiv.className = 'error-message';
                        addErrorDiv.textContent = 'Name must be between 5 and 20 characters.';
                        divClassName.appendChild(addErrorDiv);
                    }
                } else {
                    if (checkNameError) {
                        divClassName.classList.remove('error');
                        divClassName.removeChild(errorName);
                    }
                }
                return true;
            };

            function validateEmail() {
                var validCheck = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                var UserEmailValue = UserEmail.value.trim();
                var divClassEmail = document.querySelector('.input.email.required'); 
                var errorEmail = divClassEmail.querySelector('.error-message'); 
                var checkNameError = document.querySelector(".input.text.required.error input[id='UserName']");

                if (validCheck.test(UserEmailValue)) {
                    if (errorEmail) {
                        divClassEmail.classList.remove('error');
                        divClassEmail.removeChild(errorEmail);
                    }
                } else {
                    if (!errorEmail) {
                        if (checkNameError) {
                            divClassEmail.classList.remove('error');
                            divClassEmail.removeChild(errorEmail);
                        }
                        divClassEmail.classList.add('error');
                        addErrorDiv = document.createElement('div');
                        addErrorDiv.className = 'error-message';
                        addErrorDiv.textContent = 'Invalid email address.';
                        divClassEmail.appendChild(addErrorDiv);
                    } else {
                        errorEmail.textContent = 'Invalid email address.';
                    }
                }
            }

        });
    </script>
</div>