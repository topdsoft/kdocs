<?php echo nl2br($invite['Invite']['text'])?>
To create a kDocs account click the following link:
<?php echo $this->Html->url( array('controller'=>'users','action' => 'register', $invite['Invite']['hash']),true);?>
If this does not work, copy the link and open it in your web browser.
