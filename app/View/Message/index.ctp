<div class="container">
    <div class="card">
        <div class="card-header">
            Message List
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

                    </ul>
                </div>
                <div class="col-md-12 text-center mt-3">
                    <?php if (count($messagelists) >= $limit) : ?>
                        <button class="btn btn-primary btn-sm text-center" id="show-more" onclick="loadMoreMessages()">Show More</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var limit = 0;

    document.addEventListener('DOMContentLoaded', function () {
        loadData();
    });

    function loadMoreMessages() {
        limit += 2;
        loadData();
    }

    function deleteMessage(messageId, listItem) {
        // TODO: Implement the logic to delete a message with the given ID
        // Make an AJAX request to the server to delete the message
        // After successful deletion, fade out the corresponding list item
        fetch('<?php echo $this->Html->url(array('controller' => 'message', 'action' => 'delete')) ?>/' + messageId, {
            method: 'DELETE', // Use the appropriate HTTP method for deletion
        })
            .then(response => {
                if (response.ok) {
                    // Fade out the corresponding list item
                    fadeOut(listItem);
                } else {
                    console.error('Error deleting message:', response.statusText);
                }
            })
            .catch(error => {
                console.error('Error deleting message:', error);
            });
    }

    function fadeOut(element) {
        var opacity = 1;
        var intervalId = setInterval(function () {
            if (opacity > 0) {
                opacity -= 0.1; // Adjust the decrement value based on the desired fading speed
                element.style.opacity = opacity;
            } else {
                clearInterval(intervalId);
                element.style.display = 'none';
            }
        }, 100); // Adjust the interval value based on the desired fading speed
    }

    function loadData() {
        limit += 2;
        fetch('<?php echo $this->Html->url(array('controller' => 'message', 'action' => 'loadMore')) ?>/' + limit)
            .then(response => response.json())
            .then(data => {
                var messageList = document.getElementById('message-list');
                messageList.innerHTML = '';
                data.forEach(message => {
                    var li = document.createElement('li');
                    li.className = 'list-group-item';

                    var img = document.createElement('img');
                    img.src = '<?php echo $this->Html->url(["controller" => "message", "action" => "display"]) ?>' + '/' + message.RecipientProfile.profile_pic;
                    img.alt = 'User Image';
                    img.className = 'profile-pic mr-3';
                    img.width = 150;
                    img.height = 150;
                    img.style = 'width: 50px; height: 50px; border: 2px solid #ccc; border-radius: 50%;';

                    var truncatedMessage = message.MessageDetail[0].message_content.substring(0, 40);
                    if (message.MessageDetail[0].message_content.length > 40) {
                        truncatedMessage += '...';
                    }

                    li.innerHTML = `<div class="d-flex align-items-center">
                        ${img.outerHTML}
                        <div class="flex-grow-1" style="padding-left: 10px">
                            <div class="d-flex w-100 justify-content-between">
                                <h4 class="mb-1">${message.Recipient.name}</h4>
                                <small>Created Last: ${message.Message.created_at}</small>
                            </div>
                            <span style="color: gray; width: 100px">${truncatedMessage}</span>
                            <small>${message.MessageDetail[0].created_at}</small>
                        </div>
                    </div>`;

                    var deleteButton = document.createElement('button');
                    deleteButton.className = 'btn btn-danger btn-sm';
                    deleteButton.textContent = 'Delete';
                    deleteButton.onclick = function () {
                        deleteMessage(message.Message.id, li);
                    };

                    li.appendChild(deleteButton);

                    messageList.appendChild(li);
                });
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }
</script>
