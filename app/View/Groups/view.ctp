<?php echo $this->element('menu');?>
<?php if($isadmin):?>
	<h3><?php echo __('Group Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Invite New Member'), array('controller' => 'invites', 'action' => 'add',$group['Group']['id'])); ?> </li>
		<li><?php if($isowner) echo $this->Html->link(__('Edit Group'), array('action' => 'edit', $group['Group']['id'])); ?> </li>
		<li><?php if($isowner) echo $this->Form->postLink(__('Delete Group'), array('action' => 'delete', $group['Group']['id']), null, __('Are you sure you want to delete # %s?', $group['Group']['id'])); ?> </li>
	</ul>
<?php endif;?>
</div>
<div class="groups view">
<h2><?php  echo $group['Group']['name'];?></h2>
	<dl>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo nl2br($group['Group']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Owner'); ?></dt>
		<dd>
			<?php echo $group['Owner']['username']; ?>
			&nbsp;
		</dd>
	</dl>
<div class="related">
	<?php if (!empty($group['Doc'])):?>
	<h3><?php echo __('Group Docs');?></h3>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Creator'); ?></th>
		<th><?php echo __('Policy'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Priority'); ?></th>
		<th class="actions"></th>
	</tr>
	<?php
		$i = 0;//debug($group['Doc']);
		foreach ($group['Doc'] as $doc): ?>
		<tr>
			<td><?php echo $doc['name'];?></td>
			<td><?php echo $users[$doc['user_id']];?></td>
			<td><?php echo $editors[$doc['editor_id']];?></td>
			<td><?php echo $doc['created'];?></td>
			<td><?php echo $doc['modified'];?></td>
			<td><?php echo $doc['priority'];?></td>
			<?php
				$canedit=false;
				if($doc['editor_id']==3) $canedit=true;
				if($doc['editor_id']==2 && $isadmin) $canedit=true;
				if($doc['editor_id']==1 && $doc['user_id']==$this->Session->read('Auth.User.id')) $canedit=true;
			?>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'docs', 'action' => 'view', $doc['id'])); ?>
				<?php if($canedit)echo $this->Html->link(__('Edit'), array('controller' => 'docs', 'action' => 'edit', $doc['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>

<div class="related">
	<?php if (!empty($group['User'])):?>
	<h3><?php echo __('Group Members');?></h3>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Username'); ?></th>
		<th><?php echo __('Role'); ?></th>
		<th><?php echo __('Email'); ?></th>
		<th class="actions"></th>
	</tr>
	<?php
		$i = 0;
		foreach ($group['User'] as $user): ?>
		<tr>
			<td><?php echo $user['username'];?></td>
			<td><?php 
				$admin=false;
				$owner=($user['id']==$group['Group']['owner_id']);
				if($owner) {echo 'Owner';$admin=true;}
				else {
					//find if user is admin
					if($user['GroupsUser']['admin']) $admin=true;
					echo $admin ? 'Admin' : 'Member';
				}
			?></td>
			<td><?php echo $user['email'];?></td>
			<td class="actions">
				<?php if($isadmin && !$owner)echo $this->Form->postLink(__('Remove from Group'), 
					array('controller' => 'users', 'action' => 'removefromgroup', $user['id'], $group['Group']['id']), null, 
					__('Are you sure you want to remove user %s from this group?', $user['username'])); ?>
				<?php if($isowner && !$owner && !$admin)echo $this->Form->postLink(__('Make Admin'), 
					array('controller' => 'users', 'action' => 'makeadmin', $user['id'], $group['Group']['id']), null, 
					__('Are you sure you want to make user %s an admin for this group?', $user['username'])); ?>
				<?php if($isowner && !$owner && $admin)echo $this->Form->postLink(__('Remove Admin'), 
					array('controller' => 'users', 'action' => 'removeadmin', $user['id'], $group['Group']['id']), null, 
					__('Are you sure you want to remove admin privilege for user %s from this group?', $user['username'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>

<div class="related">
	<?php if (!empty($group['Uploadedfile'])):?>
	<h3><?php echo __('Group Uploaded Files');?></h3>
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
		foreach ($group['Uploadedfile'] as $uploadedfile): ?>
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
	<?php if (!empty($group['Invite'])):?>
	<h3><?php echo __('Group Invites');?></h3>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Email'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('Date Invited'); ?></th>
		<th><?php echo __('Date Accepted'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($group['Invite'] as $invite): ?>
		<tr>
			<td><?php echo $invite['email'];?></td>
			<td><?php echo empty($invite['user_id']) ? 'Pending' : 'Accepted';?></td>
			<td><?php echo $invite['created'];?></td>
			<td><?php if(!empty($invite['user_id'])) echo $invite['modified'];?></td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>
</div>
