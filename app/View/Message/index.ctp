<div class="container">
    <div class="card">
        <div class="card-header">
            Messgae List
            <?php
            echo $this->Html->link(
                'New Message',
                array('controller' => 'message', 'action' => 'new'),
                array('class' => 'btn btn-success btn-sm float-end')
            );
            ?>
        </div>
        <div class="card-body">
            <div class="row g-0">
                <div class="col-md-12">
                    <ul class="list-group" id="message-list">
                        <?php foreach ($messagelists as $messagelist) : ?>
                            <li class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                            
                                    <?php //echo $messagelist['Recipient']['profile_pic']; ?>
                                    <h5 class="mb-1"><?php echo $messagelist['Recipient']['name']; ?></h5>
                                    <small><?php echo $messagelist['Message']['created_at']; ?></small>
                                </div>
                                <?php echo $messagelist['MessageDetail'][0]['message_content']; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="col-md-12 text-center mt-2">
                    <?php if (count($messagelists) >= $limit) : ?>
                        <button class="btn btn-primary text-center" id="show-more">Show More</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var limit = <?php echo $limit; ?>;

    document.getElementById('show-more').addEventListener('click', function() {
        limit += 2;
        fetch('<?php echo $this->Html->url(array('controller' => 'message', 'action' => 'loadMore')) ?>/' + limit)
            .then(response => response.json())
            .then(data => {
                var messageList = document.getElementById('message-list');

                messageList.innerHTML = '';

                data.forEach(message => {
                    var li = document.createElement('li');
                    li.className = 'list-group-item';
                    li.innerHTML = '<div class="d-flex w-100 justify-content-between">' +
                        '<h5 class="mb-1">' + message.Recipient.name + '</h5>' +
                        '<small>' + message.Message.created_at + '</small>' +
                        '</div>' +
                        message.MessageDetail[0].message_content;
                    messageList.appendChild(li);
                });
            });
    });
</script>