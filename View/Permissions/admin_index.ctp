<div class="permissions index">
	<h2><?php echo __('Permissions');?></h2>
	<table cellpadding="0" cellspacing="0">

	<?php foreach($controllerList as $controller => $methods): ?>
		<tr class="controller-row">
			<th><div class="controller expand"><?php echo str_replace('.', '-', $controller);?></div></th>
			<?php foreach ($allRoles as $role): ?>
			<th><?php echo $role;?></th>
			<?php endforeach; ?>
		</tr>

		<?php foreach($methods as $method): ?>
			<tr class="hidden controller-<?php echo str_replace('.', '-', $controller);?>">
				<td><?php echo $method; ?>&nbsp;</td>

			<?php foreach ($allRoles as $role): ?>
				<td>
					<?php if ($role == 'Admin'): ?>
						<?php echo $this->Html->image('tick_disabled.png'); ?>
					<?php elseif (isset($permissions[$controller . ':' . $method][$role])): ?>
						<?php
							echo $this->Html->image(
								'tick.png',
								array(
									'class' => 'permission-toggle',
									'data-id' => $permissions[$controller . ':' . $method][$role],
								)
							);
						?>
						&nbsp;
					<?php else: ?>
						<?php
							echo $this->Html->image(
								'cross.png',
								array(
									'class' => 'permission-toggle',
									'data-perm' => $controller . '.' . $method,
									'data-role' => $role,
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

<?php echo $this->Html->script('/js/permissions.js'); ?>