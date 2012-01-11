<div class="docs form">
<?php echo $this->Form->create('Doc');?>
	<fieldset>
		<legend><?php echo __('New Doc'); ?></legend>
	<?php
		echo $this->Form->input('name');
//		echo $this->Form->input('user_id');
		echo $this->Form->input('group_id');
		echo $this->Form->input('editor_id',array('label'=>'Who can edit this doc:'));
		echo $this->Form->input('priority',array('label'=>'Priority(1-5)'));
//		echo $this->Form->input('text');
//		echo $this->Form->input('Uploadedfile');
//		echo $this->Form->input('User');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<?php echo $this->element('menu');?>

</div>
