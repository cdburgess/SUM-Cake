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
    * Var Name
    * @var string 'Permissions'
    * @access public
    */
	var $name = 'Permissions';
	
	/**
	* Var Components
	* @var string Components
	* @access public
	*/
    var $components = array('ControllerList');
    
    /**
    * Admin Index
    *
    * Show all permissions
    *
    * @return void
    * @access public
    */
	function admin_index() {
		$this->Permission->recursive = 0;
		$this->set('permissions', $this->paginate());
	}

    /**
    * Admin View
    * 
    * View a permission setting
    *
    * @param string $id The id of the permission to view
    * @return void
    * @access public
    */
	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid permission', true));
			$this->redirect(array('action' => 'admin_index'));
		}
		$this->set('permission', $this->Permission->read(null, $id));
	}

    /**
    * Admin Add
    *
    * Add a new permission
    *
    * @return void
    * @access public
    */
	function admin_add() {
		if (!empty($this->data)) {
			$this->Permission->create();
			if ($this->Permission->save($this->data)) {
				$this->Session->setFlash('The permission has been saved', 'flash_success');
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

    /**
    * Admin Edit
    *
    * Edit an existing permission
    *
    * @param string $id The id of the permission to edit
    * @return void
    * @access public
    */
	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid permission', true));
			$this->redirect(array('action' => 'admin_index'));
		}
		if (!empty($this->data)) {
			if ($this->Permission->save($this->data)) {
				$this->Session->setFlash('The permission has been saved', 'flash_success');
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

    /**
    * Admin Delete
    *
    * Delete an existing permission
    *
    * @param string $id The id of the permission to delete
    * @return void
    * @access public
    */
	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for permission', true));
			$this->redirect(array('action'=>'admin_index'));
		}
		if ($this->Permission->delete($id)) {
			$this->Session->setFlash('Permission deleted', 'flash_success');
			$this->redirect(array('action'=>'admin_index'));
		}
		$this->Session->setFlash(__('Permission was not deleted', true));
		$this->redirect(array('action' => 'admin_index'));
	}
	
	/**
    * Admin Copy
    *
    * Inherit permissions from one role to another without having to select each one individually. This
    * will do a delete / copy so if the inheritance is run multiple times, it will not store multiple copies
    * of the permissions for a given user.role.
    *
    * @return void
    * @access public
    */
	function admin_copy() {
	    if (!empty($this->data)) {
	        if ($this->data['Permission']['copy_to'] == $this->data['Permission']['copy_from']) {
	            $this->Session->setFlash(__('The roles cannot match. Please, try again.', true));
	        } else {
	            if ($this->Permission->copy($this->data['Permission']['copy_from'], $this->data['Permission']['copy_to'])) {
    				$this->Session->setFlash('The permissions have been updated', 'flash_success');
    				$this->redirect(array('action' => 'index'));
    			} else {
    				$this->Session->setFlash(__('The copied permissions could not be saved. Please, try again.', true));
    			}
	        }
		}
		// get the roles to use in both fields
		$this->set('role', $this->Permission->getEnumValues('role'));
	}
	
	/**
    * Admin Delete Copy
    *
    * Remove the permissions copied to this role from another role.
    *
    * @return void
    * @access public
    */
	function admin_delete_copy() {
	    if (!empty($this->data)) {
	        if ($this->data['Permission']['copy_to'] == $this->data['Permission']['copy_from']) {
	            $this->Session->setFlash(__('The roles cannot match. Please, try again.', true));
	        } else {
	            if ($this->Permission->delete_copy($this->data['Permission']['copy_from'], $this->data['Permission']['copy_to'])) {
    				$this->Session->setFlash('The copied permissions have been deleted', 'flash_success');
    				$this->redirect(array('action' => 'index'));
    			} else {
    				$this->Session->setFlash(__('The copied permission could not be removed. Please, try again.', true));
    			}
	        }
		}
		// get the roles to use in both fields
		$this->set('role', $this->Permission->getEnumValues('role'));
	}
}