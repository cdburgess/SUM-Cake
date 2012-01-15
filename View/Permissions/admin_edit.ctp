<div class="permissions form">
<?php echo $this->Form->create('Permission');?>
	<fieldset>
 		<legend><?php echo __('Admin Edit Permission'); ?></legend>
	<?php
		echo $this->Form->input('name', array('type' => 'select', 'options' => $controllerList, 'label' => __('Name')));
		echo $this->Form->input('role', array('type' => 'select', 'options' => $role, 'label' => __('Role')));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('Permission.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('Permission.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Permissions'), array('action' => 'index'));?></li>
	</ul>
</div>