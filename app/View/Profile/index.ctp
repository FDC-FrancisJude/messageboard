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
                    <img src="https://placekitten.com/250/250" class="img-fluid rounded" alt="User Image">
                </div>
                <div class="col-md-8">
                    <h2 class="card-title"><?php echo !empty($users['User']['name']) ? $users['User']['name'] : 'Unset'; ?></h2>
                    <p class="card-text">Gender: <?php echo !empty($users['Profile']['gender']) ? $users['Profile']['gender'] : 'Unset'; ?></p>
                    <p class="card-text">Birthdate: <?php echo !empty($users['Profile']['birthday']) ? $users['Profile']['birthday'] : 'Unset'; ?></p>
                    <p class="card-text">Email: <?php echo !empty($users['User']['email']) ? $users['User']['email'] : 'Unset'; ?></p>
                    <p class="card-text">Join: <?php echo !empty($users['Profile']['created_at']) ? $users['Profile']['created_at'] : 'Unset'; ?></p>
                    <p class="card-text">Last Login: <?php echo !empty($users['User']['last_login_time']) ? $users['User']['last_login_time'] : 'Unset'; ?></p>
                    <p class="card-text">Hubby <br> <?php echo !empty($users['Profile']['hobby']) ? $users['Profile']['hobby'] : 'Unset'; ?></p>
                    <?php //print_r($users); ?>
                </div>
            </div>
        </div>
    </div>
</div>


