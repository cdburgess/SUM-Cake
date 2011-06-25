<?php
/**
* Controller List component class.
*
* @link http://github.com/cdburgess/SUM-Cake
* @package cake
* @subpackage app.controllers.components
* @license http://creativecommons.org/licenses/by-sa/3.0/
*/
class ControllerListComponent extends Object {
    
    /**
    * Initialize
    *
    * @param object $controller Reference to the calling controller
    * @return void
    * @access public
    */
	function initialize(&$controller) {
		$this->controller =& $controller;
	}

	/**
	* Startup
	* 
	* called after Controller::beforeFilter()
	*
	* @param object $controller Reference to the calling controller
	* @return void
	* @access public
	*/
	function startup(&$controller) {
	}

	/**
	* Get
	* 
	* Returns the array of the controllers and their methods
	*
	* @return array List of all controllers and their methods in this system
	*/
	function get() {
		return $this->_getControllers();
	}
	
	/**
	* Methods
	*
	* List of all methods in each controller
	*
	* @return array $methods All of the methods 
	* @access public
	*/
	function methods() {
		$all = $this->get();
		foreach($all as $key => $value)  {
			$methods[$key.':*'] = $key.':*';
			foreach($value as $number => $action) {
				$methods[$key.':'.$action] = $key.':'.$action;
			}
		}
		return $methods;
	}
	
	/**
	* Get Controllers
	*
	* Get a list of controllers as objects
	*
	* @return array $controllers List of all controllers in this system
	* @access public
	*/
	function _getControllers() {
		$controllerList = App::objects('controller', App::path('controllers'), false);  // clear and rebuild the cache
		$controllers = array();
		foreach($controllerList as $controller) {
			$controllers[$controller] = $this->_getControllerMethods($controller);
		}
		return $controllers;
	}
	
	/**
	* Get Controller Methods
	*
	* Get all of the methods from each of the controllers.
	*
	* @param string $controllerName The name of the controller to query
	* @return array $classMethodsCleaned All of the methods from the class
	* @access private
	*/
	private function _getControllerMethods($controllerName) {
		$classMethodsCleaned = array();
		App::import('Controller', $controllerName);
		$parentClassMethods = get_class_methods('Controller');
		$subClassMethods = get_class_methods(Inflector::camelize($controllerName).'Controller');
		$classMethods = array_diff($subClassMethods, $parentClassMethods);
		foreach($classMethods as $method) {
			if($method{0} <> "_") $classMethodsCleaned[] = $method;
		}
		return $classMethodsCleaned;
	}	
}