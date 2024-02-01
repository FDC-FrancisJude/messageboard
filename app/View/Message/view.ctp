<style>
    .message-list {
        border: 1px solid #dbdbdb;
        border-radius: 20px;
        margin: 2px;
        padding: 10px;
    }

    .recipient,
    .sender {
        width: 700px;
    }

    .short-text {
        color: gray;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 500px;
    }

    .long-text {
        color: gray;
        max-width: 500px;
    }

    #showMoreButton {
        font-size: 15px;
        font-weight: lighter;
    }
</style>
<div class="container">
    <div class="card">
        <div class="card-header">
            <?php echo $recipientName[0]['Recipient']['name'] ?>
        </div>
        <div class="card-body">
            <div class="row g-0">
                <?php
                echo $this->Form->create('MessageDetail', array('id' => 'replyForm'));
                echo $this->Form->hidden('message_list_id', array('required' => true, 'class' => 'form-control', 'value' => $recipientName[0]['Message']['id']));
                echo $this->Form->hidden('sender_user_id', array('required' => true, 'class' => 'form-control', 'value' => $users['User']['id']));
                echo $this->Form->textarea('message_content', array('required' => true, 'class' => 'form-control', 'placeholder' => 'Reply message...'));
                echo $this->Form->button('Send Reply', array('id' => 'send-button', 'type' => 'submit', 'class' => 'btn btn-success mt-2 float-end'));
                echo $this->Form->end();
                ?>

                <div id="message-list">
                    <div class="col-md-12 mt-3">
                    </div>
                </div>
                <div class="col-md-12 text-center mt-3">
                    <?php if (count($messageDetailslist) >= $limit) : ?>
                        <button class="btn btn-primary btn-sm text-center" id="show-more" onclick="loadMoreMessages()">Show More</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    var limit = 2;

    document.addEventListener('DOMContentLoaded', function() {
        loadData();

        // setInterval(function() {
        //     loadData();
        // }, 500);
    });


    $('#replyForm').submit(function(event) {

        event.preventDefault();
        $('#send-button').val('Sending...');
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->Html->url(array('controller' => 'message', 'action' => 'add')); ?>',
            data: $('#replyForm').serialize(),
            success: function(response) {
                console.log(response);
                loadData();
            },
            error: function(error) {
                console.log(error);
            }
        });
    });

    function loadMoreMessages() {
        limit += 2;
        loadData();
    }

    function deleteMessage(messageId, listItem) {
        fetch('<?php echo $this->Html->url(array('controller' => 'message', 'action' => 'delete')) ?>/' + messageId, {
                method: 'DELETE',
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error deleting message: ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                $(`.message-list.${messageId}`).fadeOut(500, function() {
                    location.reload();
                });
            })
            .catch(error => {
                console.error('Error deleting message:', error);
            });
    }

    function loadData() {

        fetch('<?php echo $this->Html->url(array('controller' => 'message', 'action' => 'viewLoadData')) ?>/' + limit)
            .then(response => response.json())
            .then(data => {
                console.log('data', data);
                if (data.messages.length > 0) {
                    var messageList = document.getElementById('message-list');
                    messageList.innerHTML = '';
                    data.messages.forEach(message => {
                        if (data.loggedInUserId == message.MessageDetail.sender_user_id) {
                            var li = document.createElement('div');
                            li.className = `message-list ${message.Message.id} sender float-end mt-3`;
                        } else {
                            var li = document.createElement('div');
                            li.className = `message-list ${message.Message.id} recipient float-start mt-3`;
                        }


                        var img = document.createElement('img');
                        img.src = '<?php echo $this->Html->url(["controller" => "message", "action" => "display"]) ?>' + '/' + message.SenderUserProfile.profile_pic;
                        img.alt = 'User Image';
                        img.className = 'profile-pic mr-3';
                        img.style = 'width: 45px; height: 45px; border: 2px solid #ccc; border-radius: 50%;';

                        if (data.loggedInUserId == message.MessageDetail.sender_user_id) {
                            img.src = '<?php echo $this->Html->url(["controller" => "message", "action" => "display"]) ?>' + '/' + message.SenderUserProfile.profile_pic;
                        } else {
                            img.src = '<?php echo $this->Html->url(["controller" => "message", "action" => "display"]) ?>' + '/' + message.SenderUserProfile.profile_pic;
                        }
                        li.innerHTML = `<div class="d-flex align-items-center">
                                            <div class="flex-grow-1" style="padding-left: 10px">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <div class="d-block">
                                                        ${img.outerHTML}
                                                    </div>
                                                    <a class="m-2 mt-3" href="<?php echo $appRoot;?>profile/view/${message.SenderUserProfile.id}" style="text-decoration: none; color: #000;">
                                                        <h3>${message.RecipientProfile.name}</h3>
                                                    </a>
                                                    <div class="ms-auto">
                                                        <button class="btn btn-danger btn-sm" onclick="deleteMessage(${message.Message.id}, this.parentElement.parentElement.parentElement)">Delete</button>
                                                    </div>
                                                </div>
                                                <div class="d-flex">
                                                    <div id="message" ${message.MessageDetail.message_content.length > 50 ? 'class="short-text"' : 'class="long-text"'}>${message.MessageDetail.message_content}</div>
                                                    ${message.MessageDetail.message_content.length > 50 ? '<a id="showMoreButton" style="margin-left: 10px;" href="#" onclick="showFullMessage(this.parentElement.parentElement.parentElement); return false;">Show Full</a>' : ''}
                                                </div>
                                                
                                                <small class="time-ago">${formatTimeAgo(message.MessageDetail.created_at)}</small>
                                            </div>
                                        </div>`;


                        messageList.appendChild(li);
                    });
                } else {
                    var li = document.createElement('div');
                    li.className = `no-message`;
                    li.innerHTML = `<div class="text-center mt-3">
                        <h4 style="color: #dbdbdb">No Conversation Found</h4>
                    </div>`;
                    messageList.appendChild(li);
                }

            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }

    function showFullMessage(parentElement) {
        const messageElement = parentElement.querySelector('#message');
        const showMoreButton = parentElement.querySelector('#showMoreButton');

        if (messageElement.classList.contains('short-text')) {
            messageElement.classList.remove('short-text');
            messageElement.classList.add('long-text');
            showMoreButton.innerText = 'Show Less';
        } else {
            messageElement.classList.add('short-text');
            messageElement.classList.remove('long-text');
            showMoreButton.innerText = 'Show More';
        }
    }
</script>