<div class="docs view">
<?php echo $this->Form->create('Doc');?>
<h2><?php  echo $doc['Doc']['name'];?></h2>
	<dl>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($doc['Doc']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($doc['Doc']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('By'); ?></dt>
		<dd>
			<?php echo $doc['User']['username']; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Group'); ?></dt>
		<dd>
			<?php echo $this->Html->link($doc['Group']['name'], array('controller' => 'groups', 'action' => 'view', $doc['Group']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Editor'); ?></dt>
		<dd>
			<?php echo $doc['Editor']['name']; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Priority'); ?></dt>
		<dd>
			<?php for($i=1; $i<=5; $i++) echo $this->Html->image(($doc['Doc']['priority']>=$i) ? 'on.png' : 'off.png',array('width'=>8)); ?>
			&nbsp;
		</dd>
	</dl>
	<br><br>
	<?php echo $doc['Doc']['text'];?>
</div>
<?php echo $this->element('menu');?>
	<h3><?php echo __('Doc Actions'); ?></h3>
	<ul>
		<li><?php if($canedit)echo $this->Html->link(__('Edit Doc'), array('action' => 'edit', $doc['Doc']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Print Doc'), array('action' => 'dprint', $doc['Doc']['id']),array('target'=>'none')); ?> </li>
	</ul>
</div>
<?php //debug($doc);?>
<div class="related">
	<?php if (!empty($doc['Comment'])):?>
	<h3><?php echo __('Comments');?></h3>
	<?php 
		foreach ($doc['Comment'] as $comment) {
			//loop for all comments
			echo '<p><small>'.$comment['created'].' by <i>'.$users[$comment['user_id']].'</i></small><br>';
			echo nl2br($comment['text']);
			echo '</p>';
		}
	?>
<?php endif; ?>
<span id="leavecomment"><?php echo $this->Html->link(__('New Comment'), 'javascript:showcomments();');?></span>
<span id="comment" style="display:none">
<?php 
	echo $this->Form->input('comment',array('type'=>'textarea','label'=>'Leave a comment:','id'=>'commentarea'));
	echo $this->Form->end(__('Submit'));
?></span>
</div>
<div class="related">
	<?php if (!empty($doc['Uploadedfile'])):?>
	<h3><?php echo __('Related Uploadedfiles');?></h3>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('File'); ?></th>
		<th><?php echo __('Group Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($doc['Uploadedfile'] as $uploadedfile): ?>
		<tr>
			<td><?php echo $uploadedfile['id'];?></td>
			<td><?php echo $uploadedfile['file'];?></td>
			<td><?php echo $uploadedfile['group_id'];?></td>
			<td><?php echo $uploadedfile['user_id'];?></td>
			<td><?php echo $uploadedfile['created'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'uploadedfiles', 'action' => 'view', $uploadedfile['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'uploadedfiles', 'action' => 'edit', $uploadedfile['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'uploadedfiles', 'action' => 'delete', $uploadedfile['id']), null, __('Are you sure you want to delete # %s?', $uploadedfile['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>
<div class="related">
	<?php if (false):?>
	<h3><?php echo __('Related Users');?></h3>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Username'); ?></th>
		<th><?php echo __('Password'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Email'); ?></th>
		<th><?php echo __('Hash'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($doc['User'] as $user): ?>
		<tr>
			<td><?php echo $user['id'];?></td>
			<td><?php echo $user['username'];?></td>
			<td><?php echo $user['password'];?></td>
			<td><?php echo $user['created'];?></td>
			<td><?php echo $user['email'];?></td>
			<td><?php echo $user['hash'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'users', 'action' => 'view', $user['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'users', 'action' => 'edit', $user['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'users', 'action' => 'delete', $user['id']), null, __('Are you sure you want to delete # %s?', $user['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>
<?php echo $this->Html->script(array('jquery-1.6.4.min','comments.js'));?>