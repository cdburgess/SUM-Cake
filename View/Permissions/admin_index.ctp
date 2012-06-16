<div class="permissions index">
	<h2><?php echo __('Permissions');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('role');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($permissions as $permission):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $permission['Permission']['name']; ?>&nbsp;</td>
		<td><?php echo $permission['Permission']['role']; ?>&nbsp;</td>

		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $permission['Permission']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $permission['Permission']['id'])); ?>
			<?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $permission['Permission']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $permission['Permission']['id'])); ?>
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
		<?php echo $this->Paginator->prev('<< ' . __('previous'), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 	 |	<?php echo $this->Paginator->next(__('next') . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
	<?php endif; ?>

</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Permission'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Copy Permissions'), array('action' => 'copy')); ?></li>
		<li><?php echo $this->Html->link(__('Delete Copies'), array('action' => 'delete_copy')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'admin_index')); ?></li>
		<li><?php echo $this->Html->link(__('List Roles'), array('controller' => 'roles', 'action' => 'admin_index')); ?> </li>
		<li><?php echo $this->Html->link(__('Logout'), array('controller' => 'users', 'action' => 'admin_logout')); ?></li>
	</ul>
</div>