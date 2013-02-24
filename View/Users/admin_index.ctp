<div class="users index">
	<?php echo $this->element('model_search', array('model' => 'User')); ?>
	<h2><?php echo __('Users');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('full_name');?></th>
			<th><?php echo $this->Paginator->sort('email_address');?></th>
			<th><?php echo $this->Paginator->sort('role');?></th>
			<th><?php echo $this->Paginator->sort('active');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($users as $user):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
		if ($user['User']['active'] != 1) {
			$class = ' class="user_not_confirmed"';
		}
		if ($user['User']['disabled'] == 1) {
			$class = ' class="user_disabled"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $user['User']['full_name']; ?>&nbsp;</td>
		<td><?php echo $user['User']['email_address']; ?>&nbsp;</td>
		<td><?php echo $user['User']['role']; ?>&nbsp;</td>
		<td><?php echo $user['User']['active']; ?>&nbsp;</td>
		<td><?php echo date ( 'd.m.Y - H:i', strtotime($user['User']['created'])); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $user['User']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $user['User']['id'])); ?>
			<?php
				if($user['User']['disabled'] == 1) {
					echo $this->Html->link(__('Enable'), array('action' => 'enable', $user['User']['id']));
				} else {
					echo $this->Html->link(__('Disable'), array('action' => 'disable', $user['User']['id']));
				}
			?>
			<?php echo $this->Html->link(__('Send Password'), array('action' => 'reset_password', $user['User']['id'])); ?>
			<?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $user['User']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $user['User']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
	));
	?>	</p>
	
	<?php if ($this->Paginator->counter(array('format' => '%pages%')) > 1): ?>
	<div class="paging">
		<?php 
			echo $this->Paginator->prev('<< ' . __('previous'), array(), null, array('class'=>'prev disabled'));
			echo $this->Paginator->numbers(array('separator' => ''));
 			echo $this->Paginator->next(__('next') . ' >>', array(), null, array('class' => 'next disabled'));
 		?>
	</div>
	<?php endif; ?>
	
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New User'), array('action' => 'admin_add')); ?></li>
		<li><?php echo $this->Html->link(__('List Roles'), array('controller' => 'roles', 'action' => 'admin_index'), array('style' => 'color:red')); ?> </li>
		<li><?php echo $this->Html->link(__('List Permissions'), array('controller' => 'permissions', 'action' => 'admin_index'), array('style' => 'color:red')); ?></li>
		<li><?php echo $this->Html->link(__('Logout'), array('controller' => 'users', 'action' => 'admin_logout')); ?></li>
	</ul>
</div>