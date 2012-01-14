<div class="permissions form">
<?php echo $this->Form->create('Permission');?>
	<fieldset>
 	<legend><?php echo __('Delete Copied Permissions'); ?></legend>
		<?php echo $this->Form->input('copy_from', array('type' => 'select', 'options' => $role, 'label' => 'Delete the permissions added from this role')); ?>
		<?php echo $this->Form->input('copy_to', array('type' => 'select', 'options' => $role, 'label' => 'to this role')); ?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Permissions'), array('action' => 'index'));?></li>
	</ul>
	<br><br>
	<h3>Delete Copies</h3>
	<p>A quick easy method for removing copied permissions. </p>
</div>