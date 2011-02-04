<h3>My Account</h3>
<ul>
        <li><?php echo $this->Html->link(__('My Account', true), array('action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('Edit Account', true), array('action' => 'edit')); ?> </li>
        <?php if (!$facebook_user): ?>
        <li><?php echo $this->Html->link(__('Change Password', true), array('action' => 'change_password')); ?> </li>
        <?php endif; ?>
        <li><?php //echo $this->Html->link(__('Delete User', true), array('action' => 'delete', $user['User']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $user['User']['id'])); ?> </li>
</ul>