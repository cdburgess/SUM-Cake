<div class="actions">
    <h3><?php echo __('Not a subscriber?'); ?></h3>
    <p><a href="/users/register" class="text"><?php echo __('Click here'); ?></a> <?php echo __('to register.'); ?></p>
    <br><br>
    <h3><?php echo __('Forgot your password?'); ?></h3>
    <p><a href="/users/password_request" class="text"><?php echo __('Click here'); ?></a> <?php echo __('to reset your password.'); ?></p>
</div>

<div class="login form">
    <h2><?php echo __('Login'); ?></h2>
    <?php
    echo $this->Form->create('User', array('action' => 'login'));
    echo $this->Form->input('username',array('between'=>'<br>','class'=>'text', 'label' => __('Username or Email')));
    echo $this->Form->input('password',array('between'=>'<br>','class'=>'text', 'label' => __('Password')));    
    echo $this->Form->end(__('Sign In'));    
    ?>
</div>