<div class="link_content">
	<div class="user_permissions" <?php if ($this->request->here == '/users/login') { echo 'style="visibility: hidden;"'; } ?>>
		<?php
		if (isset($Auth) and $Auth) {
			echo $this->Html->link('logout', array('controller' => 'users', 'action' => 'logout'));
		} else {
			echo $this->Html->link('login', array('controller' => 'users', 'action' => 'login'));
		}
		?>
	</div>
</div>