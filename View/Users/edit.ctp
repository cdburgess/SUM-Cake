<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php echo __('Account Information'); ?></legend>
		<?php
			echo $this->Form->input('id', array('type' => 'hidden'));
			echo $this->Form->input('email_address');
			echo $this->Form->input('first_name');
			echo $this->Form->input('last_name');
		?>
	</fieldset>	
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<?php echo $this->element('users'); ?>
</div>