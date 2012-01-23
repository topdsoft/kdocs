<?php echo nl2br($invite['Invite']['text'])?><br>
To create a kDocs account click the following link:<br>
<?php echo $this->Html->url( array('controller'=>'users','action' => 'register', $invite['Invite']['hash']),true);?><br><br>
If this does not work, copy the link and open it in your web browser.</p>
