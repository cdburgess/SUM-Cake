<div class="actions">
    <h3><?php echo __('Forgot your password?'); ?></h3>
    <p><?php echo __('No problem. Enter your email address and we will send you a link that will allow you to reset your password.'); ?></p>
</div>

<div class="login form">
    <?php echo $this->Session->flash('auth'); ?>
    <h2><?php echo __('Multifactor Authentication'); ?></h2>
    <?php echo $this->Form->create('User'); ?>
    <div>First, using Google Authenticator, scan this QR Code:</div>
    <?php echo $this->Html->image($qrcode); ?>
    <div>... or enter this secret key into your Google Authenticator device:</div>
    <?php
    echo $this->Form->input('authenticator_key', array('type' => 'hidden', 'value' => $authenticator_key));
    echo $authenticator_key;
    ?>
    <div>Next, enter the 6-digit passcode and click submit to activate:</div>
    <?
    echo $this->Form->input('passcode', array('label' => __('6 Digit Passcode'), 'max_width' => 6));
    echo $this->Form->end(__('Submit'));
    ?>
</div>