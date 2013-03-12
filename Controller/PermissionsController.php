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
    public $components = array('ControllerList', 'RequestHandler');

/**
 * beforeFilter
 *
 * @return void
 * @access public
 **/
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Security->unlockedActions = array('givestar');
		if (isset($this->Security) && $this->action == 'admin_toggle' && $this->RequestHandler->isAjax()) {
			$this->Security->enabled = false;
			$this->Security->csrfCheck = false;
		}
	}

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
	public function admin_toggle($perm, $role, $id = null) {
		if (!$this->RequestHandler->isAjax()) {
			$this->redirect(array('controller' => 'permissions', 'action' => 'admin_index'));
		}

		$success = 0;

		$conditions = array();
		if ($id !== 'undefined') {
			$conditions['Permission.id'] =  $id;
		} else {
			$perm = preg_replace('/\./', ':', $perm);
			$conditions = array(
				'Permission.name' => $perm,
				'Permission.role' => $role,
			);
		}

		if ($this->Permission->hasAny($conditions)) {
			// toggle delete
			$data = $this->Permission->find('first', array('conditions' => $conditions));
			$perm = $data['Permission']['name'];
			$role = $data['Permission']['role'];
			$id = $data['Permission']['id'];

			if ($this->Permission->delete($data['Permission']['id'])) {
				$success = 1;
			}
			$permitted = 0;
		} else {
			// toggle add
			$data['Permission']['name'] = $perm;
			$data['Permission']['role'] = $role;
			if ($this->Permission->save($data)) {
				$id = $this->Permission->id;
				$data['Permission']['id'] = $id;
				$success = 1;
			}
			$permitted = 1;
		}
		$this->set(compact('perm', 'role', 'id', 'data', 'success', 'permitted'));
		$this->layout = 'ajax';
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