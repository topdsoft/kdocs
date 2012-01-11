<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
		<legend><?php echo __('Register for kDocs'); ?></legend>
		You have been invited to join the group: <?php echo $invite['Group']['name']; ?>.<br><br>
		If you want to <strong>create a new account</strong> and join the group, fill out the form below.<br><br>
		If you have an existing account and just want to join the new group click here: 
		<?php echo $this->Html->link(__('Log In'),array('action'=>'login')); ?><br><br>
	<?php
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		echo $this->Form->input('password2',array('label'=>'Re-type password','type'=>'password'));
		echo $this->Form->input('email');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
