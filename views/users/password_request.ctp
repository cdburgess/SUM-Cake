<div class="actions">
    <h3>Forgot your password?</h3>
    <p>No problem. Enter your email address and we will send you a link that will allow you to reset your password.</p>
</div>

<div class="login form">
    <?php echo $session->flash('auth'); ?>
    <h2>Reset Password Request</h2>
    <?php
    echo $form->create('User');
    echo $form->input('email_address');
    echo $form->end('Submit');
    ?>
</div>