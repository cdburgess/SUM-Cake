<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php echo __('Change Password'); ?></legend>
	<?php
		echo $this->Form->input('id', array('type' => 'hidden'));
		echo $this->Form->input('password', array('label' => __('Password')));
		echo $this->Form->input('confirm_password', array('type' => 'password', 'label' => __('Confirm Password')));
	?>
	</fieldset>	
	
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<?php echo $this->element('users'); ?>
</div>