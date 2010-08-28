<div class="users view">
	<h2><?php  __('Credentials');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email Address'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['email_address']; ?>
			&nbsp;
		</dd>
	
	<br><br>
	<h2><?php  __('Contact Information');?></h2>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['first_name']; ?> <?php echo $user['User']['last_name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Address'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['address']; ?><br>
			<?php echo $user['User']['city']; ?>, <?php echo $user['User']['state']; ?> <?php echo $user['User']['zipcode']; ?>
			&nbsp;
		</dd>
	</dl>
	
	
</div>
<div class="actions">
	<?php echo $this->element('users'); ?>
</div>
