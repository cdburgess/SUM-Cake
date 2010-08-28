<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php __('Name'); ?></legend>
	<?php
		echo $this->Form->input('id', array('type' => 'hidden'));
		echo $this->Form->input('first_name');
		echo $this->Form->input('last_name');
	?>
	</fieldset>	
	
	<fieldset>
 		<legend><?php __('Address'); ?></legend>
	<?php
		echo $this->Form->input('address');
		echo $this->Form->input('city');
		echo $this->Form->input('state');
		echo $this->Form->input('zipcode');
	?>
	</fieldset>
	
	<fieldset>
 		<legend><?php __('Other'); ?></legend>
	<?php
		echo $this->Form->input('gender', array('type' => 'select', 'options' => $gender));
		echo $this->Form->input('birthday', array('minYear' => date('Y') - 90, 'maxYear' => date('Y') - 17));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<?php echo $this->element('users'); ?>
</div>