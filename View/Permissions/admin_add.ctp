<div class="permissions form">
<?php echo $this->Form->create('Permission');?>
	<fieldset>
 		<legend><?php echo __('Add Permission'); ?></legend>
	<?php
		echo $this->Form->input('name', array('type' => 'select', 'options' => $controllerList));
		echo $this->Form->input('role', array('type' => 'select', 'options' => $role));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Permissions'), array('action' => 'index'));?></li>
	</ul>
	<br><br>
	<h3>Adding Permissions</h3>
	<p>The name is created by putting ControllerName:Action and then selecting the Role that has access.</p>
</div>