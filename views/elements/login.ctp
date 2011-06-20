<div class="link_content">
	<div class="user_permissions" <?php if ($this->here == '/users/login') { echo 'style="visibility: hidden;"'; } ?>>
		<?php
		if ($Auth) {
			echo $html->link('logout', array('controller' => 'users', 'action' => 'logout'));
		} else {
			echo $html->link('login', array('controller' => 'users', 'action' => 'login'));
		}
		?>
	</div>
</div>