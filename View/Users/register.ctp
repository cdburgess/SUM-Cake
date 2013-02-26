<h1><?php echo __('Registration'); ?></h1>
<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php echo __('New User'); ?></legend>
	<?php
		echo $this->Form->input('email_address', array('label' => __('Email Address')));
		echo $this->Form->input('password', array('value' => '', 'label' => __('Password')));
		echo $this->Form->input('confirm_password', array('type' => 'password', 'value' => '', 'label' => __('Confirm Password')));
		echo $this->Form->input('first_name', array('label' => __('First Name')));
		// Uncomment to activate the Additional Field
		// echo $this->Form->input('UserDetail.phone');
		echo $this->Form->input('last_name', array('label' => __('Last Name')));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Register'); ?></h3>
	<p><?php echo __('You will receive an email so you can confirm your registration.'); ?></p>
</div>