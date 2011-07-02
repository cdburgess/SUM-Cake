<div class="users index">
	<h2><?php __('Users');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('full_name');?></th>
			<th><?php echo $this->Paginator->sort('email_address');?></th>
			<th><?php echo $this->Paginator->sort('role');?></th>
			<th><?php echo $this->Paginator->sort('active');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($users as $user):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
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
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $user['User']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $user['User']['id'])); ?>
			<?php
				if($user['User']['disabled'] == 1) {
					echo $this->Html->link(__('Enable', true), array('action' => 'enable', $user['User']['id']));
				} else {
					echo $this->Html->link(__('Disable', true), array('action' => 'disable', $user['User']['id']));
				}
			?>
			<?php echo $this->Html->link(__('Send Password', true), array('action' => 'reset_password', $user['User']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $user['User']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $user['User']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New User', true), array('action' => 'admin_add')); ?></li>
		<li><?php echo $this->Html->link(__('List Permissions', true), array('controller' => 'permissions', 'action' => 'admin_index')); ?></li>
		<li><?php echo $this->Html->link(__('Logout', true), array('controller' => 'users', 'action' => 'admin_logout')); ?></li>
	</ul>
</div>