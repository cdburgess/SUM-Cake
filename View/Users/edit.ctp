<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php echo __('Account Information'); ?></legend>
		<?php
			echo $this->Form->input('id', array('type' => 'hidden'));
			echo $this->Form->input('email_address', array('label' => __('Email Address')));
			echo $this->Form->input('first_name', array('label' => __('First Name')));
			echo $this->Form->input('last_name', array('label' => __('Last Name')));
		?>
	</fieldset>	
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<?php echo $this->element('users'); ?>
</div>