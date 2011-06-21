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
}