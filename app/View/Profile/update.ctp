<div class="container">
    <div class="card">
        <div class="card-header">
            Update Profile
        </div>
        <div class="card-body">
            <div class="row g-0">
                <?php
                    echo $this->Form->create('Profile', array(
                        'url' => array('controller' => 'profile', 'action' => 'update'),
                        'class' => 'form-horizontal',
                        'enctype' => 'multipart/form-data'
                    ));
                    $profileValue = isset($this->request->data['Profile']['profile_pic']) ? $this->request->data['Profile']['profile_pic'] : $users['Profile']['profile_pic'];
                    $nameValue = isset($this->request->data['Profile']['name']) ? $this->request->data['Profile']['name'] : $users['Profile']['name'];
                    $emailValue = isset($this->request->data['Profile']['email']) ? $this->request->data['Profile']['email'] : $users['User']['email'];
                    $birthdayValue = isset($this->request->data['Profile']['birthday']) ? $this->request->data['Profile']['birthday'] : $users['Profile']['birthday'];
                    $genderValue = isset($this->request->data['Profile']['gender']) ? $this->request->data['Profile']['gender'] : $users['Profile']['gender'];
                    $hubbyValue = isset($this->request->data['Profile']['hubby']) ? $this->request->data['Profile']['hubby'] : $users['Profile']['hubby'];
                ?>
                    <div class="row g-0">
                        <div class="col-md-4 text-center">
                            <?php
                                echo $this->Html->image($profileValue, array(
                                    'id' => 'profile-pic-preview',
                                    'class' => 'img-fluid rounded',
                                    'alt' => 'Profile Picture',
                                    'width' => 150,
                                    'height' => 150,
                                    'style' => 'width: 150px; height: 150px;',
                                ));
                
                                echo $this->Form->input('profile_pic_img', array(
                                    'type' => 'file',
                                    'label' => 'Profile Picture',
                                    'class' => 'form-control',
                                    'div' => array('class' => 'form-group'),
                                    'onChange' => 'readURL(this)',
                                    'required' => $profileValue == 'no_image.jpg' ? true : false,
                                ));

                                echo $this->Form->input('profile_pic', array(
                                    'type' => 'hidden',
                                    'id' => 'profile_pic_name',
                                    'class' => 'form-control',
                                    'value' => $profileValue
                                ));
                            ?>
                        </div>

                        <div class="col-md-8">
                            <?php
                                echo $this->Form->input('name', array(
                                    'label' => 'Name',
                                    'class' => 'form-control',
                                    'div' => array('class' => 'form-group'),
                                    'value' => $nameValue
                                ));

                                echo $this->Form->input('email', array(
                                    'type' => 'hidden',
                                    'label' => 'Email',
                                    'class' => 'form-control',
                                    'div' => array('class' => 'form-group'),
                                    'value' => $emailValue
                                ));

                                echo $this->Form->input('birthday', array(
                                    'label' => 'Birthday',
                                    'class' => 'form-control datepicker',
                                    'div' => array('class' => 'form-group'),
                                    'value' => $birthdayValue
                                ));

                                echo $this->Form->input('gender', array(
                                    'label' => 'Gender',
                                    'class' => 'form-control',
                                    'div' => array('class' => 'form-group'),
                                    'options' => array('Male' => 'Male', 'Female' => 'Female'),
                                    'empty' => 'Select Gender',
                                    'value' => $genderValue
                                ));

                                echo $this->Form->input('hubby', array(
                                    'label' => 'Hubby',
                                    'class' => 'form-control',
                                    'div' => array('class' => 'form-group'),
                                    'value' => $hubbyValue
                                ));

                                echo $this->Form->button('Save Profile', ['class' => 'btn btn-success mb-3', 'type' => 'submit']);
                            ?>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('.datepicker').datepicker({
            dateFormat: 'yy-mm-dd',
            changeYear: true,
            yearRange: '1900:+nn',
        });
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            
            var reader = new FileReader();
            var allowedExtensions = /(\.jpg|\.jpeg|\.gif|\.png)$/i;

            var errorContainer = document.getElementById('file-error-container');
            if (errorContainer) {
                errorContainer.parentNode.removeChild(errorContainer);
            }

            if (!allowedExtensions.exec(input.files[0].name)) {
                var errorDiv = document.createElement('div');
                errorDiv.id = 'file-error-container';
                errorDiv.className = 'error-message';
                errorDiv.textContent = 'Invalid file type. Please choose a JPG, GIF, or PNG file.';

                // Insert the error message div after the file input
                input.parentNode.insertBefore(errorDiv, input.nextSibling);

                // Clear the file input value
                input.value = '';

                return;
            }

            reader.onload = function (e) {
                $('#profile-pic-preview').attr('src', e.target.result);

                // Set fixed size for the preview
                $('#profile-pic-preview').css({
                    'width': '150px',
                    'height': '150px'
                });
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

</script>
