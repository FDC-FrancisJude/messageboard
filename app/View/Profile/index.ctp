<div class="container">
    <div class="card">
        <div class="card-header">
            Profile Information
            <?php
                echo $this->Html->link(
                    'Edit Profile',
                    array('controller' => 'profile','action' => 'update'),
                    array('class' => 'btn btn-primary btn-sm float-end')
                );
            ?>
        </div>
        <div class="card-body">
            <div class="row g-0">
                <div class="col-md-4 text-center">
                    <?php
                        echo $this->Html->image($users['Profile']['profile_pic'], array(
                            'class' => 'img-fluid rounded',
                            'alt' => 'User Image',
                            'width' => 250,
                            'height' => 250,
                            'style' => 'width: 250px; height: 250px;',
                        ));
                    ?>
                </div>
                <div class="col-md-8">
                    <h2 class="card-title"><?php echo !empty($users['User']['name']) ? $users['User']['name'] : 'Unset'; ?></h2>
                    <p class="card-text">Gender: <?php echo !empty($users['Profile']['gender']) ? $users['Profile']['gender'] : 'Unset'; ?></p>
                    <p class="card-text">Birthdate: 
                        <?php 
                            if (!empty($users['Profile']['birthday'])) {
                                $dateString = $users['Profile']['birthday'];
                                $timestamp = strtotime($dateString);
                                $formattedDate = date("F j, Y", $timestamp);
                                echo $formattedDate;
                            } else {
                                echo 'Unset';
                            }
                        ?>
                    </p>

                    <p class="card-text">Join:
                        <?php 
                            if (!empty($users['Profile']['created_at'])) {
                                $dateString = $users['Profile']['created_at'];
                                $timestamp = strtotime($dateString);
                                $formattedDate = date("F j, Y g:i A", $timestamp);
                                echo $formattedDate;
                            } else {
                                echo 'Unset';
                            }
                        ?>
                    </p>
                    <p class="card-text">Last Login:
                        <?php 
                            if (!empty($users['User']['last_login_time'])) {
                                $dateString = $users['User']['last_login_time'];
                                $timestamp = strtotime($dateString);
                                $formattedDate = date("F j, Y g:i A", $timestamp);
                                echo $formattedDate;
                            } else {
                                echo 'Unset';
                            }
                        ?>
                    </p>
                    <p class="card-text">Hubby <br> <?php echo !empty($users['Profile']['hubby']) ? $users['Profile']['hubby'] : 'Unset'; ?></p>
                    <?php //print_r($users); ?>
                </div>
            </div>
        </div>
    </div>
</div>


