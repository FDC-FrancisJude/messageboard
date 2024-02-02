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

        </div>
        <div class="card-body">
            <div class="row g-0">
                <?php
                echo $this->Form->create('MessageDetail', array('id' => 'replyForm'));
                echo $this->Form->hidden('message_list_id', array('required' => true, 'class' => 'form-control message_list_id', 'value' => $messagID));
                echo $this->Form->hidden('sender_user_id', array('required' => true, 'class' => 'form-control', 'value' => $users['User']['id']));
                echo $this->Form->textarea('message_content', array('required' => true, 'class' => 'form-control message_content', 'placeholder' => 'Reply message...'));
                echo $this->Form->button('Send Reply', array('id' => 'send-button', 'type' => 'submit', 'class' => 'send-button btn btn-success mt-2 float-end'));
                echo $this->Form->end();
                ?>

                <div id="message-list">
                    <div class="col-md-12 mt-3">
                        <div class="no-message d-none">
                            <div class="text-center mt-3">
                                <h4 style="color: #dbdbdb">No Conversation Found</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 text-center mt-3">
                    <button class="d-none btn btn-primary btn-sm text-center" id="show-more" onclick="loadMoreMessages()">Show More</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var limit = 10;
    var messageCount = 0;
    var loadedMessageIds = [];

    document.addEventListener('DOMContentLoaded', function() {
        loadData();
        $('.send-button').prop('disabled', true).text('Send Reply');

        setInterval(function() {
            loadData();
        }, 2000);


    });

    $('.message_content').on('input', function() {
        var inputValue = $(this).val();
        var charCount = inputValue.length;
        if (charCount > 0) {
            $('.send-button').prop('disabled', false).text('Send Reply');
        } else {
            $('.send-button').prop('disabled', true).text('Send Reply');
        }
    });

    $('#replyForm').submit(function(event) {
        event.preventDefault();
        $('.send-button').prop('disabled', true).text('Sending...');
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->Html->url(array('controller' => 'message', 'action' => 'add')); ?>',
            data: $('#replyForm').serialize(),
            success: function(response) {
                loadData();
                $('.send-button').prop('disabled', false).text('Reply Sent');
                $('.message_content').val('');
            },
            error: function(error) {
                console.log(error);
            }
        });
    });

    function loadMoreMessages() {
        limit += 10;
        loadData();
    }

    function deleteMessage(messageId, listItem) {
        
        fetch('<?php echo $this->Html->url(array('controller' => 'message', 'action' => 'deleteDetails')) ?>/' + messageId, {
                method: 'DELETE',
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error deleting message: ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                $(`.message-list.${messageId}`).fadeOut(500, function () {
                    messageCount = 0;
                    loadData();
                });
            })
            .catch(error => {
                console.error('Error deleting message:', error);
            });
            
    }

    function loadData() {
        fetch('<?php echo $this->Html->url(array('controller' => 'message', 'action' => 'messageDetailsData')) ?>')
            .then(response => response.json())
            .then(data => {
                console.log(data);
                $('.card-header').text(data.messageName);
                if (data.messages.length > 0) {
                    var messageList = document.getElementById('message-list');

                    let find = data.messages.filter(newMessages => newMessages.MessageDetail.deleted == 0);

                    if (find.length > limit) {
                        $('#show-more').removeClass('d-none');
                    } else {
                        $('#show-more').addClass('d-none');
                    }

                    if (find.length > 0) {
                        $('.no-message').addClass('d-none');
                        var newMessages = find.filter(message => !loadedMessageIds.includes(message.MessageDetail.id));
                        
                        newMessages.forEach(message => {
                            if (messageCount >= limit) {
                                return;
                            }
                            loadedMessageIds.push(message.MessageDetail.id);
                            if (data.loggedInUserId == message.MessageDetail.sender_user_id) {
                                var li = document.createElement('div');
                                li.className = `message-list ${message.MessageDetail.id} sender float-end mt-3`;
                            } else {
                                var li = document.createElement('div');
                                li.className = `message-list ${message.MessageDetail.id} recipient float-start mt-3`;
                            }

                                var img = document.createElement('img');
                                img.src = '<?php echo $this->Html->url(["controller" => "message", "action" => "display"]) ?>' + '/' + message.SenderUserProfile.profile_pic;
                                img.alt = 'User Image';
                                img.className = 'profile-pic mr-3';
                                img.style = 'width: 45px; height: 45px; border: 2px solid #ccc; border-radius: 50%;';

                                img.src = '<?php echo $this->Html->url(["controller" => "message", "action" => "display"]) ?>' + '/' + message.SenderUserProfile.profile_pic;
                                li.innerHTML = `<div class="d-flex align-items-center">
                                            <div class="flex-grow-1" style="padding-left: 10px">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <div class="d-block">
                                                        ${img.outerHTML}
                                                    </div>
                                                    <a class="m-2 mt-3" href="<?php echo $appRoot; ?>profile/view/${message.SenderUserProfile.id}" style="text-decoration: none; color: #000;">
                                                        <h3>${message.SenderUserProfile.name}</h3>
                                                    </a>
                                                    
                                                    <div class="ms-auto">
                                                        ${data.loggedInUserId == message.MessageDetail.sender_user_id ? ` <button class="btn btn-danger btn-sm" onclick="deleteMessage(${message.MessageDetail.id}, this.parentElement.parentElement.parentElement)">Delete</button>` : ''}
                                                    </div>
                                                </div>
                                                <div class="d-flex">
                                                    <p id="message" ${message.MessageDetail.message_content.length > 60 ? 'class="short-text"' : 'class="long-text"'}>${message.MessageDetail.message_content}</p>
                                                    ${message.MessageDetail.message_content.length > 60 ? '<a id="showMoreButton" style="margin-left: 10px;" href="#" onclick="showFullMessage(this.parentElement.parentElement.parentElement); return false;">Show Full</a>' : ''}
                                                </div>
                                                
                                                <small class="time-ago">${formatTimeAgo(message.MessageDetail.created_at)}</small>
                                            </div>
                                        </div>`;

                                messageList.appendChild(li);
                                messageCount++;
                        });
                    }  else {
                        $('.no-message').removeClass('d-none');
                    }
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