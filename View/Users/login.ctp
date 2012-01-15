<div class="actions">
    <h3>Not a subscriber?</h3>
    <p><a href="/users/register"><?php echo __('Click here'); ?></a> <?php echo __('to register.'); ?></p>
    <br><br>
    <h3>Forgot password?</h3>
    <p><a href="/users/password_request"><?php echo __('Click here'); ?></a> <?php echo __('to reset your password.'); ?></p>
</div>

<div class="login form">
    <?php echo $this->Session->flash('auth'); ?>
    <h2>Login</h2>
    <?php
    echo $this->Form->create('User', array('action' => 'login'));
    echo $this->Form->input('email_address',array('between'=>'<br>','class'=>'text', 'label' => __('Email Address')));
    echo $this->Form->input('password',array('between'=>'<br>','class'=>'text', 'label' => __('Password')));    
    echo $this->Form->end('Sign In');    
    ?>
</div>