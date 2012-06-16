<div class="roles form">
<?php echo $this->Form->create('Role');?>
	<fieldset>
		<legend><?php echo __('Admin Add Role'); ?></legend>
	<?php
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Roles'), array('action' => 'index'));?></li>
	</ul>
</div>
