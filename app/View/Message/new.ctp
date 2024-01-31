<div class="container">
    <div class="card">
        <div class="card-header">
           New Message
        </div>
        <div class="card-body">
            <div class="row g-0">
                <div class="col-md-12">
                    <?php
                        echo $this->Form->create('Message', array(
                            'url' => array('controller' => 'Message', 'action' => 'new'),
                            'class' => 'form-horizontal',
                            'enctype' => 'multipart/form-data'
                        ));
                        $options = [];
                        foreach ($recipient as $userId => $userData) {
                            $userName = $userData['name'];
                            $profilePic = $userData['profile_pic'];

                            $options['User'][$userId] = $userName;
                            $options['Profile'][$userId] = $profilePic;
                        }
                        print_r($options);
                        echo $this->Form->input('to_user_id', array(
                            'label' => 'Recipient',
                            'type' => 'select',
                            'options' => $options['User'],
                            'empty' => 'Search for a recipient',
                            'class' => 'form-control ',
                            'data-placeholder' => 'Search for a recipient',
                            'id' => 'recipient-type',
                            'multiple' => 'multiple',
                        ));
                        echo $this->Form->input('message_content', array(
                            'label' => 'Message Content',
                            'rows' => '5',
                            'class' => 'form-control', 
                        ));
                        //echo $this->Form->button('Send Message', array('class' => 'btn btn-success '));
                        echo $this->Form->button('Send Message', ['class' => 'btn btn-success', 'type' => 'submit']);
                        ?>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        function formatState(recipient) {
            if (!recipient.id) {
                return recipient.text;
            }
            console.log('Recipient:', recipient.id);
            var $recipient = $(
                '<span> <?php 
                            echo $this->Html->image($users['Profile']['recipient.id'], array(
                                'class' => 'img-fluid rounded-circle',
                                'alt' => 'User Image',
                                'style' => 'width: 40px; height: 40px; border: 2px solid #ccc; border-radius: 50%;', // Add your additional styles here
                            )); 
                        ?> <span style="font-size: 15px; font-weight: bold">' + recipient.text + '</span></span>'
            );
            return $recipient;
        };

        $("#recipient-type").select2({
            templateResult: formatState,
            minimumInputLength: 1,
            language: {
                inputTooShort: function () {
                    return "Search for a recipient";
                }
            }
        });
    });
</script>