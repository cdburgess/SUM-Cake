<div class="permissions form">
<?php echo $this->Form->create('Permission');?>
	<fieldset>
 		<legend><?php __('Admin Edit Permission'); ?></legend>
	<?php
		echo $this->Form->input('name', array('type' => 'select', 'options' => $controllerList));
		echo $this->Form->input('role', array('type' => 'select', 'options' => $role));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Permission.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Permission.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Permissions', true), array('action' => 'index'));?></li>
	</ul>
</div>