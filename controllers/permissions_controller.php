<?php
class PermissionsController extends AppController {

	var $name = 'Permissions';
    var $components = array('ControllerList');
        
	function admin_index() {
		$this->Permission->recursive = 0;
		$this->set('permissions', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid permission', true));
			$this->redirect(array('action' => 'admin_index'));
		}
		$this->set('permission', $this->Permission->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Permission->create();
			if ($this->Permission->save($this->data)) {
				$this->Session->setFlash(__('The permission has been saved', true));
				$this->redirect(array('action' => 'admin_index'));
			} else {
				$this->Session->setFlash(__('The permission could not be saved. Please, try again.', true));
			}
		}
		$this->set('role', $this->Permission->getEnumValues('role'));
                $controllerList = $this->ControllerList->methods();
                array_unshift($controllerList, array('*' => '*'));
		$this->set('controllerList', $controllerList);
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid permission', true));
			$this->redirect(array('action' => 'admin_index'));
		}
		if (!empty($this->data)) {
			if ($this->Permission->save($this->data)) {
				$this->Session->setFlash(__('The permission has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The permission could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Permission->read(null, $id);
		}
		$this->set('role', $this->Permission->getEnumValues('role'));
                $controllerList = $this->ControllerList->methods();
                array_unshift($controllerList, array('*' => '*'));
		$this->set('controllerList', $controllerList);
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for permission', true));
			$this->redirect(array('action'=>'admin_index'));
		}
		if ($this->Permission->delete($id)) {
			$this->Session->setFlash(__('Permission deleted', true));
			$this->redirect(array('action'=>'admin_index'));
		}
		$this->Session->setFlash(__('Permission was not deleted', true));
		$this->redirect(array('action' => 'admin_index'));
	}
       
}