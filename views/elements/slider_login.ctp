<?php if ($this->here !== '/users/login' and $this->here !== '/users/register'): ?>
<!-- Panel -->
<div id="slider_toppanel">
	<div id="slider_panel">
		<div class="slider_content clearfix">
			<div class="slider_left">
				<h1>Welcome to <?php echo Configure::read('WebsiteName'); ?></h1>
				<h2>Sliding login panel Demo with jQuery</h2>		
				<p class="slider_grey">You can add any information you want here. Just edit views/elements/slider_login.ctp!</p>
				<h2>Turn it off</h2>
				<p class="slider_grey">This can be turned off by changing the setting in the bootstrap.</p>
			</div>
			<div class="slider_left">
				<!-- Login Form -->
				<?php echo $form->create('User', array('controller' => 'users', 'action' => 'login'), array('class' => 'slider_clearfix')); ?>
					<h1>Member Login</h1>
					<label class="slider_grey" for="log">Username:</label>
					<?php echo $form->input('email_address', array('class'=>'slider_field', 'id' => 'slider_log', 'size' => 23, 'label' => false, 'div' => false, 'value' => '')); ?>
					<label class="slider_grey" for="pwd">Password:</label>
					<?php echo $form->input('password', array('class'=>'slider_field', 'id' => 'slider_pwd', 'size' => 23, 'label' => false, 'div' => false, 'value' => '')); ?>
	            	<label>&nbsp;</label>
        			<div class="slider_clear"></div>
					<input type="submit" name="submit" value="Login" class="slider_bt_login" /> <a class="slider_lost-pwd" href="/users/password_request">Lost your password?</a>
				</form>
			</div>
			<div class="slider_left right">			
				<!-- Register Form -->
				<?php echo $this->Form->create('User', array('controller' => 'users', 'action' => 'register'));?>
					<h1>Not a member yet? Sign Up!</h1>				
					<label class="slider_grey" for="signup">Email:</label>
					<?php echo $form->input('email_address', array('class'=>'slider_field', 'id' => 'slider_signup', 'size' => 23, 'label' => false, 'div' => false, 'value' => '')); ?>
					<label class="slider_grey" for="email">Password:</label>
					<?php echo $form->input('password', array('class'=>'slider_field', 'id' => 'slider_signup_pwd', 'size' => 23, 'label' => false, 'div' => false, 'value' => '')); ?>
					<label class="slider_grey" for="email">Confirm Password:</label>
					<?php echo $form->input('confirm_password', array('class'=>'slider_field', 'id' => 'slider_confirm_pwd', 'size' => 23, 'label' => false, 'div' => false, 'type' => 'password', 'value' => '')); ?>
					<label>A confirmation will be e-mailed to you.</label>
					<input type="submit" name="submit" value="Register" class="slider_bt_register" />
				</form>
			</div>
		</div>
</div> <!-- /login -->	

	<!-- The tab on top -->	
	<div class="slider_tab">
		<ul class="slider_login">
			<li class="slider_left">&nbsp;</li>
			<?php 
				if(isset($Auth) and $Auth) {
					$name = $Auth['User']['first_name'];
				} else {
					$name = 'Guest';
				}
			?>
			<li>Welcome <?php echo $name; ?>!</li>
			<li class="slider_sep">|</li>
			<li id="slider_toggle">
				<?php if(isset($Auth) and $Auth): ?>
					<?php echo $html->link('logout', array('controller' => 'users', 'action' => 'logout')); ?>
				<?php else: ?>
					<a id="slider_open" class="slider_open" href="#">Log In | Register</a>
					<a id="slider_close" style="display: none;" class="slider_close" href="#">Close Panel</a>
				<?php endif; ?>			
			</li>
			<li class="slider_right">&nbsp;</li>
		</ul> 
	</div> <!-- / top -->
</div> 
<!--panel -->
<?php endif; ?>