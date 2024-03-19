<style>
    .item{
        border: 1px solid #dbdbdb;
        border-radius: 20px;
        margin: 2px;
        padding: 10px;
        
    }

    .recipient,
    .sender {
        width: 600px;
        margin: 0 20px;
    }

    .long-text {
        font-size: 1.5rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 500px;
    }

    .short-text {
        font-size: 1.5rem;
        max-width: 500px;
    }


    #showMoreButton {
        font-size: 15px;
        font-weight: lighter;
    }
    #main {
        max-height: 65vh;
        height: 65vh;
        overflow-y: auto;
        margin-bottom: 10px;
        overflow: auto;
    }
    .recipient-info {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }
    .profile img {
        margin: 20px;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5); /* Add a shadow effect */
    }
    .avatar-sender{
        display: flex;
        justify-content: flex-end;
        margin-right: -20px;
    }
    .avatar-recipient{
        display: flex;
        justify-content: flex-start;
        margin-left: -20px;
    }
</style>
<div class="container">
    <div class="card">
        <div class="card-header" id="sender-name">
            <?php echo $messageToUserName;?>
        </div>
        <div class="card-body">
            <div class="row g-0">
                
                <div class="main" id="main">
                    <div class="col-md-12 text-center" style="position: absolute; left: 0;">
                        <div class="spinner-border text-primary d-none" role="status"  id="show-more">
                            <span class="sr-only"></span>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3 ">
                        <div class="no-message d-none">
                            <div class="mt-3">
                            <?php if ($messageToUserDetails > 0 && $messageToUserDetails != '' ): ?>
                                <div class="recipient-info text-center">
                                    <div class="profile">
                                        <img src="<?php echo $this->Html->url(["controller" => "message", "action" => "display/". $messageToUserDetails["profile_pic"]]) ?>" alt="">
                                    </div>
                                    <div class="details">
                                        <h1><?php echo $messageToUserDetails["name"]?></h1>
                                        <p><span class="green-dot"></span>Online</p>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12 mt-3 ">
                        <div id="message-list">
                        </div>
                    </div>
                </div>
                <?php
                    echo $this->Form->create('MessageDetail', array('id' => 'replyForm'));
                    echo $this->Form->hidden('message_list_id', array('required' => true, 'class' => 'form-control message_list_id', 'value' => $messagID));
                    echo $this->Form->hidden('sender_user_id', array('required' => true, 'class' => 'form-control', 'value' => $users['User']['id']));
                    echo $this->Form->textarea('message_content', array('required' => true, 'class' => 'form-control message_content', 'placeholder' => 'Reply message...'));
                    echo $this->Form->button('Send Reply', array('id' => 'send-button', 'type' => 'submit', 'class' => 'send-button btn btn-success mt-2 float-end'));
                    echo $this->Form->end();
                ?>
            </div>
        </div>
    </div>
</div>
<script>
    var limit = 10;
    var offset = 0;
    var messageCount = 0;
    var loadedMessageIds = [];
    var lastPosition = 0;
    var totalResponse = 0
    var toRefresh = true;
    document.addEventListener('DOMContentLoaded', function() {
        loadData();
        $('.send-button').prop('disabled', true).text('Send Reply');

        setInterval(function() {
            if (toRefresh == true) {
                loadData();
            }
        }, 1000);
    });

    function scrollDown() {
        $("#main").scrollTop($("#main")[0].scrollHeight);
    }
    function scrollRemain(currentPosition) {
        $("#main").scrollTop($("#main")[0].scrollHeight - (currentPosition - lastPosition + 14));
    }

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
                
                $('.send-button').prop('disabled', false).text('Reply Sent');
                $('.message_content').val('');
                loadData(true);
            },
            error: function(error) {
                console.log(error);
            }
        });
    });

    $("#main").scroll(function() {
        var st = $(this).scrollTop();
        if (st < lastPosition) {
            if (st == 0) {
                $('#show-more').removeClass('d-none');
                setTimeout(() => {
                    $('#show-more').addClass('d-none');
                    if (totalResponse > limit && totalResponse > 10 ) {
                        loadMoreMessages();    
                    } 
                    
                }, 1000);
                
            }
        }
        lastPosition = st;
        
    });
    function loadMoreMessages() {
        offset += 10;
        limit += 10;
        var scrollPos = $("#message-list")[0].scrollHeight;
        scrollRemain(scrollPos);
        loadData();
    }

    function deleteMessage(messageId, listItem) {
        toRefresh = false;
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
                    loadData(false, true);
                });
            })
            .catch(error => {
                console.error('Error deleting message:', error);
            });
            
    }

    function loadData(isReply = false, isDelete = false) {
        console.log(isReply);
        var url = null;
        if (isReply == true) {
            url = '<?php echo $this->Html->url(array("controller" => "message", "action" => "messageDetailsData")) ?>';
        } else {
            url = '<?php echo $this->Html->url(array("controller" => "message", "action" => "messageDetailsData")) ?>?offset=' + offset;
        }
        $('#message-list').hide();
        
        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.messages && data.messages.length > 0) {
                    totalResponse = data.dataAllCount;

                    var messageList = document.getElementById('message-list');

                    let find = data.messages.filter(newMessages => newMessages.MessageDetail.deleted == 0);

                    if (find.length > 0) {
                        $('.no-message').addClass('d-none');
                        var newMessages = find
                                    .filter(message => !loadedMessageIds.includes(message.MessageDetail.id))
                                    .slice(-10);
                        if (offset == 0) {
                            newMessages.reverse();
                        } 
                        
                        newMessages.forEach(message => {  
                            
                            var img = document.createElement('img');
                            img.src = '<?php echo $this->Html->url(["controller" => "message", "action" => "display"]) ?>' + '/' + message.SenderUserProfile.profile_pic;
                            img.alt = 'User Image';
                            img.className = 'profile-pic mr-3';
                            img.style = 'width: 30px; height: 30px; border: 2px solid #ccc; border-radius: 50%;';
                            img.src = '<?php echo $this->Html->url(["controller" => "message", "action" => "display"]) ?>' + '/' + message.SenderUserProfile.profile_pic;
                            var avatar = ``;
                            var isYou = false;
                            loadedMessageIds.push(message.MessageDetail.id);
                            if (data.loggedInUserId == message.MessageDetail.sender_user_id) {
                                isYou = true;
                                var li = document.createElement('div');
                                li.className = `message-list ${message.MessageDetail.id} sender float-end mt-3`;
                                avatar = `<div class="avatar-sender">${img.outerHTML}</div>`;
                            } else {
                                isYou = false;
                                var li = document.createElement('div');
                                li.className = `message-list ${message.MessageDetail.id} recipient float-start mt-3`;
                                avatar = `<div class="avatar-recipient">${img.outerHTML}</div>`;
                            }
                                li.innerHTML = `
                                        <div class="d-flex item align-items-center">
                                            <div class="flex-grow-1" style="padding-left: 10px">
                                                <div class="d-flex align-items-center justify-content-center">
                                                   <!-- <a class="mt-3" href="<?php echo $appRoot; ?>profile/view/${message.SenderUserProfile.id}" style="text-decoration: none; color: #000;">
                                                        <h3>${message.SenderUserProfile.name} ${isYou ? '(You)' :' '}</h3>
                                                    </a>-->
                                                    
                                                    
                                                </div>
                                                <div class="d-flex">
                                                    <p id="message-${message.MessageDetail.id}" class="message-card long-text"}>
                                                        ${message.MessageDetail.message_content}
                                                        <br/>
                                                       <a id="showMoreButton" class="show-${message.MessageDetail.id} d-none" href="#" onclick="showFullMessage(this.parentElement.parentElement.parentElement, ${message.MessageDetail.id}); return false;">Show Full</a>
                                                    </p>
                                                   
                                                    <div class="ms-auto">
                                                        ${data.loggedInUserId == message.MessageDetail.sender_user_id ? ` <button class="btn btn-outline-danger btn-sm" onclick="deleteMessage(${message.MessageDetail.id}, this.parentElement.parentElement.parentElement)"><i class="fas fa-trash"></i></button>` : ''}
                                                    </div>
                                                </div>
                                                
                                                <small class="time-ago">${formatTimeAgo(message.MessageDetail.created_at)}</small>
                                            </div>
                                        </div>
                                        ${avatar}`;
                                if (offset == 0) {
                                    console.log('isDelete', isDelete)
                                    if (isDelete == true) {
                                        messageList.prepend(li);
                                    } else {
                                        messageList.appendChild(li);
                                        scrollDown();
                                    }
                                } else {
                                    if (isReply == true) {
                                        messageList.appendChild(li);
                                        scrollDown();
                                    } else {
                                        messageList.prepend(li);
                                    }
                                    //scrollRemain();
                                }

                                var messageElement = document.getElementById(`message-${message.MessageDetail.id}`);
                                var hasEllipsis = messageElement.scrollWidth > messageElement.clientWidth;

                                if (hasEllipsis) {
                                    $(`.show-${message.MessageDetail.id}`).removeClass('d-none')
                                } 
                                
                                messageCount++;
                                
                        });
                        
                    }  else {
                        $('.no-message').removeClass('d-none');
                    }
                } else {
                    $('.no-message').removeClass('d-none');
                }
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });

            $('#message-list').show();
            toRefresh = true;
    }
    

    function showFullMessage(parentElement, id) {
        const messageElement = parentElement.querySelector('.message-card ');
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
     

        var scrollPos = $("#message-list")[0].scrollHeight;
        scrollRemain(scrollPos);
        
    }
</script>