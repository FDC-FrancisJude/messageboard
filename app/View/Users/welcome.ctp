<div class="container welcome-container">
    <h1 class="display-4">Welcome To Message Board</h1>
    <p class="lead">Thank you for registering. Message board is a space for open discussions, idea-sharing, and connecting with others!</p>
    <?php
    echo $this->Html->link(
        'Procced to Home',
        array('controller' => 'users','action' => 'proceed'),
        array('class' => 'btn btn-primary btn-lg')
    );
    ?>
</div>
