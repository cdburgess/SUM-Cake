<?php
/*
 * Each developed project could collect different user data.
 * UserDetails helps to keep the system modular, flexible and easy to upgrade,
 * when new version is available.
 * 
 * If your UserDetails has many additional fields and/or associations with another models,
 * it would be a good idea to bake UserDetails once again and then reuse the code in the User's View system 
 * 
 */

App::uses('AppController', 'Controller');
/**
 * UserDetails Controller
 *
 * @property UserDetail $UserDetail
 */
class UserDetailsController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->UserDetail->recursive = 0;
		$this->set('userDetails', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->UserDetail->id = $id;
		if (!$this->UserDetail->exists()) {
			throw new NotFoundException(__('Invalid user detail'));
		}
		$this->set('userDetail', $this->UserDetail->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->UserDetail->create();
			if ($this->UserDetail->save($this->request->data)) {
				$this->Session->setFlash(__('The user detail has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user detail could not be saved. Please, try again.'));
			}
		}
		$users = $this->UserDetail->User->find('list');
		$delMethods = $this->UserDetail->DelMethod->find('list');
		$this->set(compact('users', 'delMethods'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->UserDetail->id = $id;
		if (!$this->UserDetail->exists()) {
			throw new NotFoundException(__('Invalid user detail'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->UserDetail->save($this->request->data)) {
				$this->Session->setFlash(__('The user detail has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user detail could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->UserDetail->read(null, $id);
		}
		$users = $this->UserDetail->User->find('list');
		$delMethods = $this->UserDetail->DelMethod->find('list');
		$this->set(compact('users', 'delMethods'));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->UserDetail->id = $id;
		if (!$this->UserDetail->exists()) {
			throw new NotFoundException(__('Invalid user detail'));
		}
		if ($this->UserDetail->delete()) {
			$this->Session->setFlash(__('User detail deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User detail was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->UserDetail->recursive = 0;
		$this->set('userDetails', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->UserDetail->id = $id;
		if (!$this->UserDetail->exists()) {
			throw new NotFoundException(__('Invalid user detail'));
		}
		$this->set('userDetail', $this->UserDetail->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->UserDetail->create();
			if ($this->UserDetail->save($this->request->data)) {
				$this->Session->setFlash(__('The user detail has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user detail could not be saved. Please, try again.'));
			}
		}
		$users = $this->UserDetail->User->find('list');
		$delMethods = $this->UserDetail->DelMethod->find('list');
		$this->set(compact('users', 'delMethods'));
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->UserDetail->id = $id;
		if (!$this->UserDetail->exists()) {
			throw new NotFoundException(__('Invalid user detail'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->UserDetail->save($this->request->data)) {
				$this->Session->setFlash(__('The user detail has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user detail could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->UserDetail->read(null, $id);
		}
		$users = $this->UserDetail->User->find('list');
		$delMethods = $this->UserDetail->DelMethod->find('list');
		$this->set(compact('users', 'delMethods'));
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
		$this->UserDetail->id = $id;
		if (!$this->UserDetail->exists()) {
			throw new NotFoundException(__('Invalid user detail'));
		}
		if ($this->UserDetail->delete()) {
			$this->Session->setFlash(__('User detail deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User detail was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
