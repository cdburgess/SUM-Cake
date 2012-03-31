<div class="permissions view">
<h2><?php echo __('Permission');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $permission['Permission']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $permission['Permission']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Role'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $permission['Permission']['role']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $permission['Permission']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $permission['Permission']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Permission'), array('action' => 'edit', $permission['Permission']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Permission'), array('action' => 'delete', $permission['Permission']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $permission['Permission']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Permissions'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Permission'), array('action' => 'add')); ?> </li>
	</ul>
</div>
