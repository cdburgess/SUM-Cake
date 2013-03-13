<?php
	if ($success == 1) {
		if ($permitted == 1) {
			echo $this->Html->image('tick.png', array('class' => 'permission-toggle', 'data-id' => $id));
		} else {
			echo $this->Html->image('cross.png', array('class' => 'permission-toggle', 'data-perm' => $perm, 'data-role' => $role));
		}
	} else {
		__('error');
	}
?>