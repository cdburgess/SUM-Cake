<?php
class User extends AppModel {
	var $name = 'User';
	var $displayField = 'email_address';
	var $validate = array(
		'email_address' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'This must be a valid email address.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
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
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'custom' => array(
				'rule' => array('matchingPasswords'),
				'message' => 'Passwords must match.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
                'confirm_password' => array(
                        'notempty' => array(
                                'rule' => array('notempty'),
                                'message' => 'Your password cannot be empty.',
                        ),
                ),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

    
    /**
     * matchingPasswords
     *
     * Compare the hashed passwords to make sure they are identical.
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
?>