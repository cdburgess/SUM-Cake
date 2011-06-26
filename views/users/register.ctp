<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php __('New User'); ?></legend>
	<?php
		echo $this->Form->input('email_address');
		echo $this->Form->input('password', array('value' => ''));
		echo $this->Form->input('confirm_password', array('type' => 'password', 'value' => ''));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Register'); ?></h3>
	<p>You will recieve an email so you can confirm your registration.</p>
</div>