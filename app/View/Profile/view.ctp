<div class="container">
    <div class="card">
        <div class="card-header">
            <?php echo $profile['Profile']['name']; ?>
        </div>
        <div class="card-body">
            <div class="row g-0">
                <div class="col-md-4 text-center">
                    <?php
                        echo $this->Html->image($profile['Profile']['profile_pic'], array(
                            'class' => 'img-fluid rounded',
                            'alt' => 'User Image',
                            'width' => 250,
                            'height' => 250,
                            'style' => 'width: 250px; height: 250px;',
                        ));
                    ?>
                </div>
                <div class="col-md-8">
                    <h2 class="card-title"><?php echo $profile['Profile']['name']; ?></h2>
                    <p class="card-text">Gender: <?php echo $profile['Profile']['gender']; ?></p>
                    <p class="card-text">Birthdate: <?php echo $profile['Profile']['birthday']; ?></p>

                    <p class="card-text">Join: <?php echo $this->TimeAgo->formalDate($profile['Profile']['created_at']); ?> </p>
                    <p class="card-text">Hubby <br> <?php echo $profile['Profile']['hubby']; ?></p>
                    <?php //print_r($users); ?>
                </div>
            </div>
        </div>
    </div>
</div>


