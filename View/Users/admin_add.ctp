<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php echo __('Admin Add User'); ?></legend>
	<?php
		echo $this->Form->input('email_address', array('label' => __('Email Address')));
		echo $this->Form->input('password', array('label' => __('Password')));
		echo $this->Form->input('confirm_password', array('type' => 'password', 'label' => __('Confirm Password')));
		echo $this->Form->input('first_name', array('label' => __('First Name')));
		echo $this->Form->input('last_name', array('label' => __('Last Name')));
		echo $this->Form->input('role', array('type' => 'select', 'options' => $role, 'label' => __('Role')));
		echo $this->Form->input('active', array('type' => 'select', 'options' => $active, 'label' => __('Active')));
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