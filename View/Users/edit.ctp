<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php echo __('Account Information'); ?></legend>
		<?php
			echo $this->Form->input('id', array('type' => 'hidden'));
			echo $this->Form->input('UserDetail.id', array('type' => 'hidden'));
			echo $this->Form->input('email_address', array('label' => __('Email Address')));
			echo $this->Form->input('first_name', array('label' => __('First Name')));
			echo $this->Form->input('last_name', array('label' => __('Last Name')));
			// Uncomment to activate the Additional Field
			// echo $this->Form->input('UserDetail.phone');
		?>
	</fieldset>	
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<?php echo $this->element('users'); ?>
	<?php echo $this->Html->link(__('Change Password'), array('controller'=>'users', 'action' => 'change_password')); ?> 
</div>