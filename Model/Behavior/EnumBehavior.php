<?php
/**
* ENUM Behavior
* 
* This Behavior provides a convenient way to work with ENUM fields. It will support multiple
* enums in the same table. Just define which fields should work as an enum type and the 
* available values for those types.
* 
* @example
* In your model : 
* 	var $actsAs = array(
*		'Enum' => array(
*			'fields' => array(
*				'FIELD1' => array('VALUE1', 'VALUE2', 'VALUE3'...),
*				'FIELD2' => array('VALUE1', 'VALUE2', 'VALUE3'...),
*			),
*		),
*	);
*
* In your controller :
* $this->set($this->Enum->enumValues());
* 
* @author Chuck Burgess
*
*/
class EnumBehavior extends ModelBehavior {

	/**
	* Setup
	*
	*  Setup enum behavior with the specified configuration settings.
	* 
	* @param object $model Model using this behavior
	* @param array $config Configuration settings for $model
	* @return void
	*/
	public function setup(&$model, $config = array()) { 
		$this->settings[$model->name] = $config;
		foreach ($config['fields'] as $field => $values) {
			$model->validate[$field]['allowedValues'] = array(
		  		'rule' => array('inList', $values),
		  		'message' => sprintf(__('Please choose one of the following values : %s', true), join(', ', $values))
		  	);
		}
	}	
}