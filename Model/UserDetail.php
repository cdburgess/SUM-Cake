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

App::uses('AppModel', 'Model');
/**
 * UserDetail Model
 *
 * @property User $User
 * @property DelMethod $DelMethod
 */
class UserDetail extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	
	public $validate = array(
		/*
		'phone' => array(
					'notempty' => array(
						'rule' => array('notempty'),
						'message' => 'Cannot be empty.',
					)
				)
		 */
	);
	
}
