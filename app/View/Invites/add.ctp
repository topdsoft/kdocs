<div class="invites form">
<?php echo $this->Form->create('Invite');?>
	<fieldset>
		<legend><?php echo __('Invite User to Group:').$group['Group']['name']; ?></legend>
	<?php
		echo $this->Form->input('group_id',array('type'=>'hidden'));
		echo "Enter the user's email address and they will be sent an invitation to the group.";
		echo $this->Form->input('email',array('id'=>'def'));
		echo $this->Form->input('hash',array('type'=>'hidden'));
		echo $this->Form->input('text',array('label'=>'Greeting Message:'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<script type='text/javascript'>document.getElementById('def').focus();</script>
<?php echo $this->element('menu');?>
</div>