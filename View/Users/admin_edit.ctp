<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php echo __('Admin Edit User'); ?></legend>
	<?php
		echo $this->Form->input('id', array('type' => 'hidden'));
		echo $this->Form->input('email_address', array('label' => __('Email Address')));
		echo $this->Form->input('first_name', array('label' => __('First Name')));
		echo $this->Form->input('last_name', array('label' => __('Last Name')));
		echo $this->Form->input('role', array('type' => 'select', 'options' => $role, 'label' => __('Role')));
		echo $this->Form->input('active', array('label' => __('Active')));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('User.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('User.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index'));?></li>
	</ul>
</div>