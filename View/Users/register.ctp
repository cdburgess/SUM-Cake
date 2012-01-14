<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php echo __('New User'); ?></legend>
	<?php
		echo $this->Form->input('email_address');
		echo $this->Form->input('password', array('value' => ''));
		echo $this->Form->input('confirm_password', array('type' => 'password', 'value' => ''));
		echo $this->Form->input('first_name');
		echo $this->Form->input('last_name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Register'); ?></h3>
	<p>You will receive an email so you can confirm your registration.</p>
</div>