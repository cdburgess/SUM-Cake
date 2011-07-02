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
    
    /**
    * Var Permission
    *
    * @var string $name 'User'
    * @access public
    */
	var $name = 'User';
	
	/**
	* Var DisplayField
	* @var string $displayField 'email_address'
	* @access public
	*/
	var $displayField = 'email_address';
	
	/**
	* Var Validate
	* @var array $validate
	* @access public
	*/
	var $validate = array(
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
    * Var VirtualFields
    * @var $virtualFields
    * @access public
    */
    var $virtualFields = array(
        'full_name' => 'CONCAT(User.first_name, " ", User.last_name)'
    );
    
    
    /**
     * matchingPasswords
     *
     * Validation rule to compare the hashed passwords to make sure they are identical.
     *
     * @return mixed true/false
     * @access public
     */
    function matchingPasswords() {
        $passed = true;
        if ($this->data['User']['password'] !== Security::hash($this->data['User']['confirm_password'], null, true)){
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
    function disable($id = null) {
        if ($id == null) {
            return false;
        }
        $data['User']['id'] = $id;
        $data['User']['disabled'] = 1;
        return $this->save($data);
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
    function enable($id = null) {
        if ($id == null) {
            return false;
        }
        $data['User']['id'] = $id;
        $data['User']['disabled'] = 0;
        return $this->save($data);
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
    function unset_password_request($id = null) {
        if($id == null) {
            return false;
        }
        $data['User']['id'] = $id;
        $data['User']['password_requested'] = 0;
        return $this->save($data);
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
    function set_password_request($id = null) {
        if($id == null) {
            return false;
        }
        $data['User']['id'] = $id;
        $data['User']['password_requested'] = String::uuid();
        if(!$this->save($data)) {
            return false;
        }
        return true;
    }
    
}