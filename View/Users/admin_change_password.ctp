<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php echo __('Admin Change User Password'); ?></legend>
		<h3>Changing password for: <?php echo $this->request->data['User']['email_address']; ?></h3>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('password');
		echo $this->Form->input('confirm_password', array('type' => 'password'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('User.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('User.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index'));?></li>
	</ul>
</div>