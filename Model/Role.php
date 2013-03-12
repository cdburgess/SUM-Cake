<?php
App::uses('AppModel', 'Model');
/**
 * Role Model
 *
 */
class Role extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Form Options
 *
 * Build an options list array for the html form.
 *
 * @return void
 * @author Chuck Burgess
 **/
	public function formOptions() {
		return $this->find('list', array('fields' => array('name','name')));
	}
}
