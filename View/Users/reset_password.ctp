<div class="actions">
    <h3>Notice</h3>
    <p>Enter your new password and it will be reset.</p>
</div>

<div class="login form">
    <?php echo $this->Session->flash('auth'); ?>
    <h2>Reset Password</h2>
    <?php
    echo $this->Form->create('User');
    echo $this->Form->input('id', array('type' => 'hidden', 'value' => $id));
    echo $this->Form->input('email_address', array('type' => 'hidden', 'value' => $email_address));
    echo $this->Form->input('password');
    echo $this->Form->input('confirm_password', array('type' => 'password'));
    echo $this->Form->end('Submit');
    ?>
</div>