<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php echo __('Admin Add User'); ?></legend>
	<?php
		echo $this->Form->input('email_address');
		echo $this->Form->input('password');
		echo $this->Form->input('confirm_password', array('type' => 'password'));
		echo $this->Form->input('role', array('type' => 'select', 'options' => $role));
		echo $this->Form->input('active', array('type' => 'select', 'options' => $active));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index'));?></li>
	</ul>
</div>