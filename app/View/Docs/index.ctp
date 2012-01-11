<div class="docs index">
	<h2><?php echo __('Docs');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th><?php echo $this->Paginator->sort('group_id');?></th>
			<th><?php echo $this->Paginator->sort('editor_id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('priority');?></th>
			<th><?php echo $this->Paginator->sort('text');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($docs as $doc): ?>
	<tr>
		<td><?php echo h($doc['Doc']['id']); ?>&nbsp;</td>
		<td><?php echo h($doc['Doc']['name']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($doc['User']['username'], array('controller' => 'users', 'action' => 'view', $doc['User']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($doc['Group']['name'], array('controller' => 'groups', 'action' => 'view', $doc['Group']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($doc['Editor']['name'], array('controller' => 'editors', 'action' => 'view', $doc['Editor']['id'])); ?>
		</td>
		<td><?php echo h($doc['Doc']['created']); ?>&nbsp;</td>
		<td><?php echo h($doc['Doc']['modified']); ?>&nbsp;</td>
		<td><?php echo h($doc['Doc']['priority']); ?>&nbsp;</td>
		<td><?php echo h($doc['Doc']['text']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $doc['Doc']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $doc['Doc']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $doc['Doc']['id']), null, __('Are you sure you want to delete # %s?', $doc['Doc']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Doc'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Groups'), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group'), array('controller' => 'groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Editors'), array('controller' => 'editors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Editor'), array('controller' => 'editors', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Comments'), array('controller' => 'comments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Comment'), array('controller' => 'comments', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Uploadedfiles'), array('controller' => 'uploadedfiles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Uploadedfile'), array('controller' => 'uploadedfiles', 'action' => 'add')); ?> </li>
	</ul>
</div>
