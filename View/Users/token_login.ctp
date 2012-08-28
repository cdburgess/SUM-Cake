<div class="actions">
    <h3><?php echo __('Forgot your password?'); ?></h3>
    <p><?php echo __('No problem. Enter your email address and we will send you a link that will allow you to reset your password.'); ?></p>
</div>

<div class="login form">
    <?php echo $this->Session->flash('auth'); ?>
    <h2><?php echo __('Multifactor Authentication'); ?></h2>
    <?php echo $this->Form->create('User'); ?>
    <div>Enter the 6-digit passcode:</div>
    <?
    echo $this->Form->input('Token.passcode', array('label' => __('Passcode'), 'max_width' => 6));
    echo $this->Form->end(__('Submit'));
    ?>
</div>