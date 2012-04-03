<div class="link_content" style="float:right;">
	<div class="user_permissions" <?php if ($this->request->here == '/users/login') { echo 'style="visibility: hidden;"'; } ?>>
		<?php
		if (isset($Auth) and $Auth) {
			echo $this->Html->link(__('logout'), array('controller' => 'users', 'action' => 'logout'));
		} else {
			echo $this->Html->link(__('login'), array('controller' => 'users', 'action' => 'login'));
		}
		?>
	</div>
</div>