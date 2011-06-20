<h3>My Account</h3>
<ul>
        <li><?php echo $this->Html->link(__('My Account', true), array('action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('Edit Account', true), array('action' => 'edit')); ?> </li>
        <li><?php echo $this->Html->link(__('Change Password', true), array('action' => 'change_password')); ?> </li>
</ul>