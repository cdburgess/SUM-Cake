<?php
App::uses('AppController', 'Controller');
/**
 * Roles Controller
 *
 * @property Role $Role
 */
class RolesController extends AppController {


/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Role->recursive = 0;
		$this->set('roles', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Role->id = $id;
		if (!$this->Role->exists()) {
			throw new NotFoundException(__('Invalid role'));
		}
		$this->set('role', $this->Role->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Role->create();
			if ($this->Role->save($this->request->data)) {
				$this->Session->setFlash(__('The role has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The role could not be saved. Please, try again.'), 'flash_error');
			}
		}
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Role->id = $id;
		if (!$this->Role->exists()) {
			throw new NotFoundException(__('Invalid role'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Role->save($this->request->data)) {
				$this->Session->setFlash(__('The role has been saved'), 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The role could not be saved. Please, try again.'), 'flash_error');
			}
		} else {
			$this->request->data = $this->Role->read(null, $id);
		}
	}

/**
 * admin_delete method
 *
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Role->id = $id;
		if (!$this->Role->exists()) {
			throw new NotFoundException(__('Invalid role'));
		}
		if ($this->Role->delete()) {
			$this->Session->setFlash(__('Role deleted'), 'flash_success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Role was not deleted'), 'flash_error');
		$this->redirect(array('action' => 'index'));
	}
}
