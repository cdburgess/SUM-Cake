<?php
/**
 * Permissions controller class.
 *
 * @link http://github.com/cdburgess/SUM-Cake
 * @package cake
 * @subpackage app.controller
 * @license http://creativecommons.org/licenses/by-sa/3.0/
 */
class PermissionsController extends AppController {

/**
 * Controller Name
 *
 * @access public
 */
	public $name = 'Permissions';

/**
 * Components
 *
 * @access public
 */
    public $components = array('ControllerList');

/**
 * Admin Index
 *
 * Show all permissions
 *
 * @return void
 * @access public
 */
	public function admin_index() {
		$this->loadModel('Role');
		$this->set('allRoles', $this->Role->formOptions());

        $this->set('controllerList', $this->ControllerList->getControllers());

		$this->Permission->recursive = 0;
		$permissions = $this->Permission->find('all');
		$perms = Set::combine($permissions, '{n}.Permission.role', '{n}.Permission.id', '{n}.Permission.name');
		$this->set('permissions', $perms);
	}

/**
 * Admin Add
 *
 * Add a new permission
 *
 * @return void
 * @access public
 */
	public function admin_add() {
		if (!empty($this->request->named)) {
			$data['Permission']['name'] = $this->request->named['name'];
			$data['Permission']['role'] = $this->request->named['role'];
			$this->Permission->create();
			if ($this->Permission->save($data)) {
				$this->Session->setFlash(__('The permission has been saved'), 'flash_success');
			} else {
				$this->Session->setFlash(__('The permission could not be saved. Please, try again.'));
			}
		}
		$this->redirect(array('controller' => 'permissions', 'action' => 'admin_index'));
	}

/**
 * Admin Delete
 *
 * Delete an existing permission
 *
 * @param string $id The id of the permission to delete
 * @return void
 * @access public
 */
	public function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for permission'));
			$this->redirect(array('action' => 'admin_index'));
		}
		if ($this->Permission->delete($id)) {
			$this->Session->setFlash(__('Permission deleted'), 'flash_success');
			$this->redirect(array('action' => 'admin_index'));
		}
		$this->Session->setFlash(__('Permission was not deleted'));
		$this->redirect(array('action' => 'admin_index'));
	}
}