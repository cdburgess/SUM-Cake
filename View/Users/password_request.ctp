<div class="actions">
    <h3><?php echo __('Forgot your password?'); ?></h3>
    <p><?php echo __('No problem. Enter your email address and we will send you a link that will allow you to reset your password.'); ?></p>
</div>

<div class="login form">
    <?php echo $this->Session->flash('auth'); ?>
    <h2><?php echo __('Reset Password Request'); ?></h2>
    <?php
    echo $this->Form->create('User');
    echo $this->Form->input('email_address', array('label' => __('Email Address')));
    echo $this->Form->end(__('Submit'));
    ?>
</div>