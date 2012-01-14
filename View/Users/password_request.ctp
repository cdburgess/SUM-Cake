<div class="actions">
    <h3>Forgot your password?</h3>
    <p>No problem. Enter your email address and we will send you a link that will allow you to reset your password.</p>
</div>

<div class="login form">
    <?php echo $this->Session->flash('auth'); ?>
    <h2>Reset Password Request</h2>
    <?php
    echo $this->Form->create('User');
    echo $this->Form->input('email_address');
    echo $this->Form->end('Submit');
    ?>
</div>