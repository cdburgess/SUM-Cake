<div class="actions">
    <h3>Notice</h3>
    <p>Enter your new password and it will be reset.</p>
</div>

<div class="login form">
    <?php echo $session->flash('auth'); ?>
    <h2>Reset Password</h2>
    <?php
    echo $form->create('User');
    echo $form->input('id', array('type' => 'hidden', 'value' => $id));
    echo $form->input('email_address', array('type' => 'hidden', 'value' => $email_address));
    echo $form->input('password');
    echo $form->input('confirm_password', array('type' => 'password'));
    echo $form->end('Submit');
    ?>
</div>