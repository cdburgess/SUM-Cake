<h3><?php echo __('My Account'); ?></h3>
<ul>
        <li><?php echo $this->Html->link(__('My Account'), array('action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('Edit Account'), array('action' => 'edit')); ?> </li>
        <li><?php echo $this->Html->link(__('Change Password'), array('action' => 'change_password')); ?> </li>
        <li><?php echo $this->Html->link(__('Logout'), array('action' => 'logout', 'admin' => false)); ?> </li>
</ul>