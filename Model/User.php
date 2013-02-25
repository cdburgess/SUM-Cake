<?php
/**
 * User model class.
 *
 * @link http://github.com/cdburgess/SUM-Cake
 * @package cake
 * @subpackage app.models
 * @license http://creativecommons.org/licenses/by-sa/3.0/
 */
class User extends AppModel {
	
	var $primaryKey = 'id';

/**
 * Model Name
 *
 * @access public
 */
	public $name = 'User';

/**
 * DisplayField
 *
 * @access public
 */
	public $displayField = 'email_address';

/**
 * SearchFields
 *
 * @access public
 */
	public $searchFields = array('User.email_address', 'User.first_name', 'User.last_name');

/**
 * Validation
 *
 * @access public
 */
	public $validate = array(
		'email_address' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'This must be a valid email address.',
			),
            'isUnique' => array(
                'rule' => array('isUnique'),
                'message' => 'This email address already exists',
            ),
		),
		'password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Your password cannot be empty.',
			),
			'custom' => array(
				'rule' => array('matchingPasswords'),
				'message' => 'Passwords must match.',
			),
		),
        'confirm_password' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Your password cannot be empty.',
            ),
        ),
        'first_name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter your first name.',
			),
		),
        'last_name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter your last name.',
			),
		),
	);

/**
 * VirtualFields
 *
 * @access public
 */
    public $virtualFields = array(
        'full_name' => 'CONCAT(User.first_name, " ", User.last_name)'
    );

/**
 * beforeSave
 *
 * Make sure the email-address is converted to all lowercase.
 *
 * @return true
 * @access public
 */
	public function beforeSave($options = array()) {
		parent::beforeSave();
		if (isset($this->data['User']['email_address'])) {
			$this->data['User']['email_address'] = strtolower($this->data['User']['email_address']);
		}
		return true;
	}

/**
 * beforeFind
 *
 * Convert the email address to lowercase before searching the DB.
 *
 * @param array $queryData The query data that is headed to the model
 * @return array $queryData Pass the updated queryData back to caller
 * @access public
 */
	public function beforeFind($queryData) {
		$queryData = parent::beforeFind($queryData);
		if (isset($queryData['conditions']) && !empty($queryData['conditions']['User.email_address'])) {
			$queryData['conditions']['User.email_address'] = strtolower($queryData['conditions']['User.email_address']);
		}
		return $queryData;
	}

/**
 * beforeValidate
 *
 * Convert the email_address to lowercase
 *
 * @return bool True
 * @access public
 */
	public function beforeValidate($options = array()) {
		if (isset($this->data['User']['email_address'])) {
			$this->data['User']['email_address'] = strtolower($this->data['User']['email_address']);
		}
		return true;
	}

/**
 * matchingPasswords
 *
 * Validation rule to compare the hashed passwords to make sure they are identical.
 *
 * @return mixed true/false
 * @access public
 */
	public function matchingPasswords() {
		$passed = true;
		if ($this->data['User']['password'] !== AuthComponent::password($this->data['User']['confirm_password'])) {
			$passed = false;
			$this->invalidate('checkpassword');
		}
		return $passed;
	}

/**
 * Disable user account
 *
 * Set the disable flag to 1
 *
 * @param string $id The id of the account to disable
 * @return bool
 * @access public
 */
	public function disable($id = null) {
		if (!$id) {
			return false;
		}
		$this->id = $id;
		return ($this->saveField('disabled', true));
	}

/**
 * Enable user account
 *
 * Set the disable flag to 0
 *
 * @param string $id The id of the account to enable
 * @return bool
 * @access public
 */
	public function enable($id = null) {
		if (!$id) {
			return false;
		}
		$this->id = $id;
		return ($this->saveField('disabled', false));
	}

/**
 * Unset Password Request Bit
 *
 * This will remove the password request so it is not active
 *
 * @param string $id The user id
 * @return bool
 * @access public
 */
	public function unset_password_request($id = null) {
		if (!$id) {
			return false;
		}
		$this->id = $id;
		return ($this->saveField('password_requested', 0));
	}

/**
 * Set Password Request Bit
 *
 * This will add the password request so it is not active
 *
 * @param string $id The user id
 * @return bool
 * @access public
 */
	public function set_password_request($id = null) {
		if (!$id) {
			return false;
		}
		$this->id = $id;
		return ($this->saveField('password_requested', String::uuid()));
	}
}