<div class="docs form">
<?php echo $this->Form->create('Doc');?>
	<fieldset>
		<legend><?php echo __('New Doc'); ?></legend>
	<?php
		echo $this->Form->input('name');
//		echo $this->Form->input('user_id');
		echo $this->Form->input('group_id');
		echo $this->Form->input('editor_id',array('label'=>'Who can edit this doc:'));
		echo $this->Form->input('priority',array('type'=>'hidden','id'=>'rating'));
		//show priority bangs
		echo 'Priority:<table style="width:300px;"><tr>';
		for ($i=0; $i<5; $i++) echo '<td><div class="tdBox">'.$this->Html->image('off.png',
			array('class'=>'L1','url'=>"javascript:rating(".($i+1).")",'style'=>'position:relative;')).$this->Html->image('on.png',
			array('class'=>'L1','url'=>"javascript:rating(".($i+1).")",'id'=>'on',
			'style'=>'display:none;')).'</div></td>';
		echo '</tr></table>';
//		echo $this->Form->input('text');
//		echo $this->Form->input('Uploadedfile');
//		echo $this->Form->input('User');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<?php echo $this->element('menu');?>

</div>
<?php echo $this->Html->script(array('jquery-1.6.4.min','priority.js'));?>
<style type='text/css'>
.tdBox { position:relative; padding:0;}
.L1 { position:absolute; top:0px; left:0px; z-index:1; }
</style>
