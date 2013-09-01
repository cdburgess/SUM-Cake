<?php
/**
 * Controller List component class.
 *
 * @link http://github.com/cdburgess/SUM-Cake
 * @package cake
 * @subpackage app.controllers.components
 * @license http://creativecommons.org/licenses/by-sa/3.0/
 */
App::uses('Component', 'Controller');
class ControllerListComponent extends Component {

/**
 * Initialize
 *
 * @param object $controller Reference to the calling controller
 * @return void
 * @access public
 */
    public function initialize(Controller $controller) {
        $this->controller = $controller;
    }

/**
 * shutdown
 *
 * @return void
 * @access public
 * @author Chuck Burgess
 **/
    public function shutdown(Controller $controller) {
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
    public function startup(Controller $controller) {
    }

/**
 * Get
 *
 * Returns the array of the controllers and their methods
 *
 * @return array List of all controllers and their methods in this system
 * @access public
 */
    public function get() {
        $controllersAndPluginControllers = array_merge($this->getControllers(), $this->_getPluginControllerMethods());
		return $controllersAndPluginControllers;
    }

/**
 * Methods
 *
 * List of all methods in each controller. This will include plugin controllers. All plugin
 * controllers will be prepended with the plugin name: Plugin.Controller:method
 *
 * @return array $methods All of the methods
 * @access public
 */
	public function methods() {
		$all = $this->get();
		$plugins = App::objects('plugin');
		if (!empty($plugins)) {
			$all = array_merge($all, $this->_getPluginControllerMethods());
		}
		foreach ($all as $key => $value) {
			$methods[$key.':*'] = $key.':*';
			foreach ($value as $number => $action) {
				$methods[$key.':'.$action] = $key.':'.$action;
			}
		}
		sort($methods);
		foreach ($methods as $value) {
			$data[$value] = $value;
		}
		return $data;
	}

/**
 * Get Controllers
 *
 * Get a list of controllers as objects
 *
 * @return array $controllers List of all controllers in this system
 * @access public
 */
	public function getControllers() {
		$controllerList = App::objects('controller', App::path('controllers'), false);  // clear and rebuild the cache
		$controllers = array();
		foreach ($controllerList as $controller) {
			if ($controller !== 'AppController') {
				$controllerName = preg_replace('/Controller$/', '',  $controller);
				$controllers[$controllerName] = $this->getControllerMethods($controller);
			}
		}
		return $controllers;
	}

/**
 * Get Controller Methods
 *
 * Get all of the methods from each of the controllers. This will also include the controllers
 * found in paths included by App::build. Use the reflection class and get only the names of 
 * the public methods in the controller class, sort them, and return the array.
 *
 * @param string $controllerName The name of the controller to query
 * @return array $classMethodsCleaned All of the methods from the class
 * @access public
 */
	public function getControllerMethods($controllerName) {
		$classMethodsCleaned = array();
		App::uses($controllerName, 'Controller');
		$controller = new ReflectionClass($controllerName);
		$methods = array();
		foreach ($controller->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
			if ($method->class == $controllerName) {
				$methods[] = $method->name;
			}
		}
		$subClassMethods = get_class_methods($controllerName);
		$parentClass = get_parent_class($controllerName);
		$parentClassMethods = get_class_methods($parentClass);
		$classMethods = array_diff($subClassMethods, $parentClassMethods);

		$parentClassMethods = get_class_methods('Controller');
		$classMethods = array_diff($classMethods, $parentClassMethods);
		foreach ($classMethods as $method) {
			if ($method{0} <> "_") {
				$classMethodsCleaned[] = $method;
			}
		}
		sort($classMethodsCleaned);
		return $classMethodsCleaned;
	}

/**
 * Get Plugin Controller Methods
 *
 * Get all a list of plugin controllers as objects and their methods
 *
 * @return array $controllers List of all plugin controllers and their methods
 * @access protected
 */
	protected function _getPluginControllerMethods() {
		$plugins = App::objects('plugin');
		$controllers = array();
		if (!empty($plugins)) {
			CakePlugin::loadAll();
			$parentClassMethods = get_class_methods('Controller');
			foreach ($plugins as $plugin) {
				$controllerList = App::objects($plugin.'.Controller');
				foreach ($controllerList as $controller) {
					$controllerName = $plugin.'.'. $controller;
					$controllerName = preg_replace('/Controller$/', '',  $controller);
					App::uses($controller, $plugin.'.Controller');
					if ($controller !== $plugin.'AppController') {
						$subClassMethods = get_class_methods($controller);
						if (is_array($subClassMethods)) {
							$classMethods = array_diff($subClassMethods, $parentClassMethods);
							foreach ($classMethods as $method) {
								if ($method{0} <> "_") {
									$classMethodsCleaned[] = $method;
								}
							}
							$controllers[$controllerName] = $classMethods;
						}
					}
				}
			}
		}
		return $controllers;
	}
}