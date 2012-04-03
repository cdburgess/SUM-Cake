<?php echo $this->element('login'); ?>
<h2><?php echo 'Documentation for SUM-Cake  v'.Configure::read('version'); ?></h2>
<br>
<div width="200px">
	<center>
		<a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-sa/3.0/88x31.png" /></a><br /><span xmlns:dct="http://purl.org/dc/terms/" href="http://purl.org/dc/dcmitype/Text" property="dct:title" rel="dct:type">SUM-Cake</span> by <a xmlns:cc="http://creativecommons.org/ns#" href="http://blockchuck.com" property="cc:attributionName" rel="cc:attributionURL">Chuck Burgess</a> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/">Creative Commons Attribution-ShareAlike 3.0 Unported License</a>.<br />Based on a work at <a xmlns:dct="http://purl.org/dc/terms/" href="http://github.com/cdburgess/SUM-Cake" rel="dct:source">github.com</a>.
	</center>
</div>
<?php
if (Configure::read('debug') > 0):
	Debugger::checkSecurityKeys();
endif;
?>

<p>
<?php
	if (version_compare(PHP_VERSION, '5.2.6', '>=')):
		echo '<span class="notice success">';
			echo __d('cake_dev', 'Your version of PHP is 5.2.6 or higher.');
		echo '</span>';
	else:
		echo '<span class="notice">';
			echo __d('cake_dev', 'Your version of PHP is too low. You need PHP 5.2.6 or higher to use CakePHP.');
		echo '</span>';
	endif;
?>
</p>

<p>
	<?php
		if (is_writable(TMP)):
			echo '<span class="notice success">';
				echo __d('cake_dev', 'Your tmp directory is writable.');
			echo '</span>';
		else:
			echo '<span class="notice">';
				echo __d('cake_dev', 'Your tmp directory is NOT writable.');
			echo '</span>';
		endif;
	?>
</p>
<p>
	<?php
		$settings = Cache::settings();
		if (!empty($settings)):
			echo '<span class="notice success">';
				echo __d('cake_dev', 'The %s is being used for caching. To change the config edit APP/Config/core.php ', '<em>'. $settings['engine'] . 'Engine</em>');
			echo '</span>';
		else:
			echo '<span class="notice">';
				echo __d('cake_dev', 'Your cache is NOT working. Please check the settings in APP/Config/core.php');
			echo '</span>';
		endif;
	?>
</p>
<p>
	<?php
		$filePresent = null;
		if (file_exists(APP . 'Config' . DS . 'database.php')):
			echo '<span class="notice success">';
				echo __d('cake_dev', 'Your database configuration file is present.');
				$filePresent = true;
			echo '</span>';
		else:
			echo '<span class="notice">';
				echo __d('cake_dev', 'Your database configuration file is NOT present.');
				echo '<br/>';
				echo __d('cake_dev', 'Rename APP/Config/database.php.default to APP/Config/database.php');
			echo '</span>';
		endif;
	?>
</p>
<?php
if (isset($filePresent)):
	App::uses('ConnectionManager', 'Model');
	try {
		$connected = ConnectionManager::getDataSource('default');
	} catch (Exception $e) {
		$connected = false;
	}
?>
<p>
	<?php
		if ($connected && $connected->isConnected()):
			echo '<span class="notice success">';
	 			echo __d('cake_dev', 'Cake is able to connect to the database.');
			echo '</span>';
		else:
			echo '<span class="notice">';
				echo __d('cake_dev', 'Cake is NOT able to connect to the database.');
			echo '</span>';
		endif;
	?>
</p>
<?php endif;?>
<?php
	App::uses('Validation', 'Utility');
	if (!Validation::alphaNumeric('cakephp')) {
		echo '<p><span class="notice">';
		__d('cake_dev', 'PCRE has not been compiled with Unicode support.');
		echo '<br/>';
		__d('cake_dev', 'Recompile PCRE with Unicode support by adding <code>--enable-unicode-properties</code> when configuring');
		echo '</span></p>';
	}
?>
<h3><?php echo __d('cake_dev', 'Editing this Page'); ?></h3>
<p>
<?php echo __d('cake_dev', 'To change the content of this page, modify: APP/View/Elements/documentation.ctp.');
?>
</p>

<br />
<h3>Documentation</h3>
<p>
	This project is to help you get your site up and running quickly with user registration. It is not intended to
	be a package that contains all of the bells and whistles. It will be kept simple enough that it will be a good
	foundation for someone to build from.
</p><br />
<p>
	If you think there is some functionality this project could benefit from, please feel free to submit it. Keep
	in mind the goal to keep it simple. If I feel the functionality is worth adding, I will do so.
</p><br />
<p>
	The code should be an obvious setup. Drop the entire application into cake as the beginning of your app, load
	the sql (APP/Config/Schema/users_schema.sql) into your database, configure the database, and point to /users/login
	and you will be off and running. What I want to document here is some of the functionality that may NOT be so
	obvious.
</p><br />
<h4><b>Set Up</b></h4>
<p>
	The SUM-Cake package is basically the app directory that you can start building an application in. You can add the
	Config/Schema/users_schema.sql to the database, update the Config/database.php and start using it. 
</p><br />
<p>
	Default usernames and passwords for the base installation:
</p><br/>
<table>
	<tr><th><b>Username</b></th><th><b>Password</b></th></tr>
	<tr><td>admin@example.com</td><td> password</td></tr>
	<tr><td>user@example.com</td><td> password</td>
</table><br/>

<h4><b>User Validation</b></h4>
<p>
	Once a user registers, an email will be sent to that user with a validation link. The email content can be modified
	and is stored in the email directory (APP/View/Emails/html/welcome.ctp & APP/View/Email/text/welcome.ctp).
	The email will be sent using the SystemEmail and WebsiteName variables from the bootstrap file: APP/Config/bootstrap.
</p><br />
<p>
	Once a user clicks on the validation link in the email, the database is updated and the user is directed to the
	login page. They will now be able to login to the site. 
</p><br />

<h4><b>User Validation: Auto Login</b></h4>
<p>	
	To auto enable logins so the user does NOT have to be validated through a validation link, set autoValidate to true in 
	the bootstrap file. Once the user is logged in, they will be sent a welcome email and automatically logged in. The email 
	content can be modified and is stored in the email directory (APP/View/Emails/html/welcome_auto.ctp & APP/View/Email/text/welcome_auto.ctp).
	If you do not want to send a welcome email at all, you can also disable that in the bootstrap file.
</p><br />

<h4><b>Resetting Password</b></h4>
<p>
	A user can request a lost password. This will send the user a link to their email address on file allowing them to
	create a new password. Once the new password is created, the password reset link becomes invalid. If someone sends a 
	password reset request for an email address they do not own, the request link will become invalid as soon as the
	user either: a) resets the password or b) logs in to their account using their existing email / password.
</p><br />

<h4><b>System Email</b></h4>
<p>
	With CakePHP 2.x, email configuration is a breeze. You can configure the email sending the way you want. All you need
	to do is configure the email you want to use in APP/Config/email.php and then set the emailConfig variable in the
	APP/Config/bootstrap.php file. Then everywhere email is sent, it will your your configuration. 

	By setting the required variables and turning smtpEmailOn = true, the system will send the emails as you define.
</p><br />

<h4><b>Permissions</b></h4>
<p>
	As you start adding controllers and methods to your application, you will need to give the users permissions if they
	are going to access them. All controllers will be available in the permissions list. This includes controllers found
	in the main application, controllers added to the application by App::build(), and controllers found in plugins. The
	naming conventions are as follows:
</p><br />
<table>
	<tr><td><b>Main App</b></td><td> {ControllerName}:{MethodName}</td></tr>
	<tr><td><b>App::build() paths</b></td><td> {ControllerName}:{MethodName}</td>
	<tr><td><b>Plugins</b></td><td> {PluginName}.{ControllerName}:{MethodName}</td>
</table>
<br />
<p>
	<b>Global Access:</b> If you want to provide access to a specific controller or method, you simply add it inside the
	controller. For controller wide access add $this->Auth->allow('*'); to your beforeFilter() method in the controller.
	For a specific method add $this->Auth->allow('method1','method2','etc.'); to your beforeFilter() method in the controller.
</p><br />
<p>
	<b>Registered User Access:</b> To give access to specific roles, use the permissions section of the website. As you
	add controllers and methods, you simply provide access by going to New Permission link in the permissions section
	of the website. It will allow you to select the Name of the permission and the Role to assign the permission to.
	(http://SEM-Cake/admin/permissions)
</p><br />

<h3>More about Me</h3>
<p>
I enjoy writing code. It is my passion. I learn more every day.
</p>

<ul>
	<li><a href="http://blogchuck.com/">My Blog</a>
	<ul><li>My ramblings about stuff</li></ul></li>
	<li><a href="http://github.com/cdburgess">My GitHub</a>
	<ul><li>The code I have posted for public use</li></ul></li>
	<li><a href="http://code.google.com/p/blogchuck/">My Google Code</a>
	<ul><li>More code I have posted for public use</li></ul></li>
</ul>