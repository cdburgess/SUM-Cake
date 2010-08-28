<?php
/*
* List controller an actions component
*
*/
class ControllerListComponent extends Object
{
	function initialize(&$controller, $settings = array()) {
		// saving the controller reference for later use
		$this->controller =& $controller;
	}

	//called after Controller::beforeFilter()
	function startup(&$controller) {
	}

	/**
	 * Public Function: Returns the array of the controllers and their methods
	 */
	function get()
	{
		return $this->_getControllers();
	}
	
	function methods(){
		$all = $this->get();
		foreach($all as $key => $value){
			$methods[$key.':*'] = $key.':*';
			foreach($value as $number => $action){
				$methods[$key.':'.$action] = $key.':'.$action;
			}
		}
		return $methods;
	}
	
	function _getControllers()
	{
		$controllerList = Configure::listObjects('controller');
		$controllers = array();
		
		foreach($controllerList as $controller)
		{
			$controllers[$controller] = $this->_getControllerMethods($controller);
		}
	
		return $controllers;
	}
	
	function _getControllerMethods($controllerName)
	{
		$classMethodsCleaned = array();
		$file = APP."controllers".DS.Inflector::underscore($controllerName)."_controller.php";
		
		if(file_exists($file)){ 
			require_once($file);
			$parentClassMethods = get_class_methods('Controller');
			$subClassMethods = get_class_methods(Inflector::camelize($controllerName).'Controller');
			$classMethods = array_diff($subClassMethods, $parentClassMethods);
		
			foreach($classMethods as $method)
			{
				if($method{0} <> "_") $classMethodsCleaned[] = $method;
			}
		}
		return $classMethodsCleaned;
	}
	
}
?>