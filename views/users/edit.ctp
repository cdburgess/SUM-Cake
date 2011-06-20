<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php __('Name'); ?></legend>
		<?php
			echo $this->Form->input('id');
			echo $this->Form->input('email_address');
			echo $this->Form->input('password');
			echo $this->Form->input('confirm_password', array('type' => 'password'));
		?>
	</fieldset>	
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<?php echo $this->element('users'); ?>
</div>