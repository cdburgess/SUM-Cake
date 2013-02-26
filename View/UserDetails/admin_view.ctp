<div class="userDetails view">
<h2><?php  echo __('User Detail');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($userDetail['UserDetail']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($userDetail['User']['email_address'], array('controller' => 'users', 'action' => 'view', $userDetail['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Phone'); ?></dt>
		<dd>
			<?php echo h($userDetail['UserDetail']['phone']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($userDetail['UserDetail']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($userDetail['UserDetail']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User Detail'), array('action' => 'edit', $userDetail['UserDetail']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete User Detail'), array('action' => 'delete', $userDetail['UserDetail']['id']), null, __('Are you sure you want to delete # %s?', $userDetail['UserDetail']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List User Details'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Detail'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
