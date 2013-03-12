<div class="permissions index">
	<h2><?php echo __('Permissions');?></h2>
	<table cellpadding="0" cellspacing="0">

	<?php foreach($controllerList as $controller => $methods): ?>
		<tr>
			<th><?php echo $controller;?></th>
		<?php foreach($allRoles as $role): ?>
			<th><?php echo $role;?></th>
		<?php endforeach; ?>
		</tr>

		<?php foreach($methods as $method): ?>
			<tr>
				<td><?php echo $method; ?>&nbsp;</td>

			<?php foreach($allRoles as $role): ?>
				<td>
				<?php if ($role == 'Admin'): ?>
					<?php echo $this->Html->image('tick_disabled.png'); ?>
				<?php elseif (isset($permissions[$controller . ':' . $method][$role])): ?>
						<?php
							echo $this->Html->link(
								$this->Html->image('tick.png'),
								array('action' => 'admin_delete', $permissions[$controller . ':' . $method][$role]),
								array('escape' => false,),
								sprintf(__('Are you sure you want to delete # %s?'), $permissions[$controller . ':' . $method][$role])
							);
						?>
						&nbsp;
				<?php else: ?>
					<?php
							echo $this->Html->link(
								$this->Html->image('cross.png'),
								array('action' => 'admin_add', 'name' => $controller . ':' . $method, 'role' => $role ),
								array(
									'escape' => false,
								)
							);
						?>
						&nbsp;
				<?php endif; ?>
				</td>
			<?php endforeach; ?>

			</tr>
		<?php endforeach; ?>

	<?php endforeach; ?>
	</table>

</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'admin_index')); ?></li>
		<li><?php echo $this->Html->link(__('List Roles'), array('controller' => 'roles', 'action' => 'admin_index')); ?> </li>
		<li><?php echo $this->Html->link(__('Logout'), array('controller' => 'users', 'action' => 'admin_logout')); ?></li>
	</ul>
</div>