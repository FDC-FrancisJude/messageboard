<div class="container">
    <div class="card">
        <div class="card-header">
            Updated Profile
        </div>
        <div class="card-body">
            <div class="row g-0">
                <div class="col-md-12">
                    <div class="card-body">
                        <?php

                        ?>
                        <div class="row g-0">
                            <div class="col-md-4 text-center">
                                <img src="https://placekitten.com/250/250" class="img-fluid rounded" alt="User Image">
                            </div>
                            <div class="col-md-8">
                                <?php
                                echo $this->Form->create('Profile', array(
                                    'url' => array('controller' => 'profile', 'action' => 'update'),
                                    'class' => 'form-horizontal'
                                ));
                                echo $this->Form->input('email', array(
                                    'label' => 'Email',
                                    'class' => 'form-control',
                                    'div' => array('class' => 'form-group'),
                                ));
                                echo $this->Form->input('name', array(
                                    'label' => 'Name',
                                    'class' => 'form-control',
                                    'div' => array('class' => 'form-group'),
                                ));
                                
                                echo $this->Form->input('birthday', array(
                                    'label' => 'Birthday',
                                    'class' => 'form-control datepicker', 
                                    'div' => array('class' => 'form-group'),
                                ));
                                
                                echo $this->Form->input('gender', array(
                                    'label' => 'Gender',
                                    'class' => 'form-control',
                                    'div' => array('class' => 'form-group'),
                                    'options' => array('Male' => 'Male', 'Female' => 'Female'),
                                    'empty' => 'Select Gender',
                                ));
                                echo $this->Form->input('hubby', array(
                                    'label' => 'Hubby',
                                    'class' => 'form-control',
                                    'div' => array('class' => 'form-group'),
                                ));
                                
                                echo $this->Form->end(array('label' => 'Save Profile', 'class' => 'btn btn-primary'));
                                ?>
                            </div>
                        </div>
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
</script>
