<div class="actions">
    <h3><?php echo __('Notice'); ?></h3>
    <p><?php echo __('Enter your new password and it will be reset.'); ?></p>
</div>

<div class="login form">
    <?php echo $this->Session->flash('auth'); ?>
    <h2><?php echo __('Reset Password'); ?></h2>
    <?php
    echo $this->Form->create('User');
    echo $this->Form->input('id', array('type' => 'hidden', 'value' => $id));
    echo $this->Form->input('email_address', array('type' => 'hidden', 'value' => $email_address, 'label' => __('Email Address')));
    echo $this->Form->input('password', array('label' => __('Password')));
    echo $this->Form->input('confirm_password', array('type' => 'password', 'label' => __('Confirm Password')));
    echo $this->Form->end(__('Submit'));
    ?>
</div>