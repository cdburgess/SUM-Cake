<?php
/**
 * Permission model class.
 *
 * @link http://github.com/cdburgess/SUM-Cake
 * @package cake
 * @subpackage app.models
 * @license http://creativecommons.org/licenses/by-sa/3.0/
 */
class Permission extends AppModel {

/**
 * Model Name
 *
 * @access public
 */
    public $name = 'Permission';

/**
 * Model Validattion
 *
 * @access public
 */
	public $validate = array(
		'name' => array(
			'rule' => array('_checkNameRoleUnique'),
			'message' => 'A record already exists for this permission.',
		),
	);

/**
 * Model Acts As Fields
 *
 * @access public
 */
	public $actsAs = array(
		'Enum' => array(
			'fields' => array(
				'role' => array('Admin' => 'Admin', 'User' => 'User'),
				'copied_from' => array('Admin' => 'Admin', 'User' => 'User'),
			),
		),
	);

/**
 * Check Name Role Unique
 *
 * The permissions are set to eliminate duplicates by keeping the name/role fields combination
 * unique. This will validate the column pair combination to make sure they are unique before
 * adding the record to the database.
 *
 * @return void
 * @access protected
 */
	protected function _checkNameRoleUnique() {
		if ($this->isUnique(array('name', 'role'), false)) {
			return true;
		} else {
			return false;
		}
	}

/**
 * Copy
 *
 * Updates the receiver role with all of the permissions from the giver role.
 *
 * @param string $copy_from The role to copy the permissions from
 * @param string $copy_to The role to copy the permissions to
 * @return bool True/False If the data was saved to the permissions correctly
 * @access public
 */
	public function copy($copy_from = null, $copy_to = null) {
		if ($copy_to == null || $copy_from == null) {
			return false;
		}
		if ($this->_delete_copies($copy_to, $copy_from)) {
			$insert_data = $this->find('all', array('conditions' => array('role' => $copy_from), 'fields' => array('name')));
			$permission_count = count($insert_data);
			for ($loop = 0; $loop < $permission_count; $loop++) {
				$insert_data[$loop]['Permission']['role'] = $copy_to;
				$insert_data[$loop]['Permission']['copied_from'] = $copy_from;
			}
			if ($this->saveAll($insert_data)) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

/**
 * RemoveCopy
 *
 * Remove all of the copies made from one role to another.
 *
 * @param string $copy_from The role the defines what roles to delete
 * @param string $copy_to The role to delete from
 * @return bool True/False If the data was saved to the permissions correctly
 * @access public
 */
	public function delete_copy($copy_from = null, $copy_to = null) {
		if ($copy_to == null || $copy_from == null) {
			return false;
		}
		if ($this->_delete_copies($copy_to, $copy_from)) {
			return true;
		} else {
			return false;
		}
	}

/**
 * Delete Copies
 *
 * Delete all of the permissions that where copied to a specific role from another role.
 *
 * @param string $copy_to The role the permissions were copied to
 * @param string $copy_from The role the permissions were copied from
 * @return bool 
 * @access protected
 */
	protected function _delete_copies($copy_to = null, $copy_from = null) {
		if ($copy_to == null || $copy_from == null) {
			return false;
		}
		if ($this->deleteAll(array('role' => $copy_to, 'copied_from' => $copy_from), false, false)) {
			return true;
		} else {
			return false;
		}
	}
}