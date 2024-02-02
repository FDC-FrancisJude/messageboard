<style>
    .message-list {
        border: 1px solid #dbdbdb;
        border-radius: 20px;
        margin: 2px;
        padding: 10px;
    }
</style>
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
                    <input class="form-control mb-3" type="search" placeholder="Search message..." aria-label="Search" oninput="handleSearchChange(this)">
                </div>
                <div class="col-md-12">
                    <div class="list-group" id="message-list">

                    </div>
                </div>
                <div class="col-md-12 text-center mt-3">
                    <button class="btn btn-primary btn-sm text-center d-none" id="show-more" onclick="loadMoreMessages()">Show More</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var limit = 10;
    var messageCount = 0;
    var searchValue = "all";
    
    function handleSearchChange(input) {
        var search = input.value;
        searchValue = search;
        loadData(search);
    }

    $(document).ready(function() {
        loadData(searchValue);
        // setInterval(function() {
        //     loadData(searchValue);
        // }, 2000);
    });

    function loadMoreMessages() {
        limit += 10;
        loadData(searchValue);
    }

    function deleteMessage(messageId, listItem) {
        fetch('<?php echo $this->Html->url(array('controller' => 'message', 'action' => 'deleteMessage')) ?>/' + messageId, {
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
                    loadData('all');
                });
            })
            .catch(error => {
                console.error('Error deleting message:', error);
            });
    }

    function loadData(search) {
        messageCount = 0;
        fetch('<?php echo $this->Html->url(array('controller' => 'message', 'action' => 'messageListData')) ?>?search=' + encodeURIComponent(search))
            .then(response => response.json())
            .then(data => {
                console.log(data);
                var messageList = document.getElementById('message-list');
                messageList.innerHTML = '';
                console.log(data.messages);
                if (data.messages.length > limit) {
                    $('#show-more').removeClass('d-none');
                } else {
                    $('#show-more').addClass('d-none');
                }
                if (data.messages.length > 0) {
                    data.messages.forEach(message => {
                        if (messageCount >= limit) {
                            return; 
                        }
                        var li = document.createElement('div');
                        li.className = `message-list ${message.Message.id}`;

                        var img = document.createElement('img');
                        if (data.loggedInUserId == message.Sender.id) {
                            img.src = '<?php echo $this->Html->url(["controller" => "message", "action" => "display"]) ?>' + '/' + message.RecipientProfile.profile_pic;
                        } else {
                            img.src = '<?php echo $this->Html->url(["controller" => "message", "action" => "display"]) ?>' + '/' + message.SenderProfile.profile_pic;
                        }

                        img.alt = 'User Image';
                        img.className = 'profile-pic mr-3';
                        img.style = 'width: 70px; height: 70px; border: 2px solid #ccc; border-radius: 50%;';

                        var truncatedMessage = message.MessageDetail[0].message_content.substring(0, 40);
                        if (message.MessageDetail[0].message_content.length > 40) {
                            truncatedMessage += '...';
                        }

                        if (data.loggedInUserId == message.Sender.id) {
                            li.innerHTML = `<div class="d-flex align-items-center">
                                                ${img.outerHTML}
                                                <div class="flex-grow-1" style="padding-left: 10px">
                                                    <div class="d-flex w-100 justify-content-between">
                                                        <a href="message/view/${message.Message.id}" style="text-decoration: none; color: #000;">
                                                            <h4 class="mb-1">${message.Recipient.name}</h4>
                                                        </a>
                                                        <!-- <a href="profile/view/${message.Recipient.id}" style="text-decoration: none; color: #000;">
                                                            <p>View Profile</p>
                                                        </a> -->
                                                        <small>Created At: ${formatFormalDate(message.Message.created_at)}</small>
                                                    </div>
                                                    <small>Created By: You</small>
                                                    <small class="time-ago">${formatTimeAgo(message.MessageDetail[0].created_at)}</small>
                                                    <div class="float-end" >
                                                        <button class="btn btn-danger btn-sm" onclick="deleteMessage(${message.Message.id}, this.parentElement.parentElement.parentElement)">Delete</button>
                                                    </div>
                                                </div>
                                            </div>`;
                        } else {
                            li.innerHTML = `<div class="d-flex align-items-center">
                                                ${img.outerHTML}
                                                <div class="flex-grow-1" style="padding-left: 10px">
                                                    <div class="d-flex w-100 justify-content-between">
                                                        <a href="message/view/${message.Message.id}" style="text-decoration: none; color: #000;">
                                                            <h4 class="mb-1">${message.Sender.name}</h4>
                                                        </a>
                                                        <!-- <a href="profile/view/${message.Sender.id}" style="text-decoration: none; color: #000;">
                                                            <p>View Profile</p>
                                                        </a> -->
                                                        <small>Created At: ${formatFormalDate(message.Message.created_at)}</small>
                                                    </div>
                                                    <small>Created By: ${message.Sender.name}</small>
                                                    <small class="time-ago">${formatTimeAgo(message.MessageDetail[0].created_at)}</small>
                                                    <div class="float-end" >
                                                        <button class="btn btn-danger btn-sm" onclick="deleteMessage(${message.Message.id}, this.parentElement.parentElement.parentElement)">Delete</button>
                                                    </div>
                                                </div>
                                            </div>`;
                        }
                        messageList.appendChild(li);
                        messageCount++;
                    });
                } else {
                    var li = document.createElement('div');
                    li.className = `no-message`;
                    li.innerHTML = `<div class="text-center mt-3">
                        <h4 style="color: #dbdbdb">No Message Conversation Found</h4>
                    </div>`;
                    messageList.appendChild(li);
                }

            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }
</script>