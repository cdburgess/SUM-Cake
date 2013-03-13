<?php
/**
 * App controller class.
 *
 * @link http://github.com/cdburgess/SUM-Cake
 * @package cake
 * @subpackage app
 * @license http://creativecommons.org/licenses/by-sa/3.0/
 */
App::uses('Controller', 'Controller');
class AppController extends Controller {

/**
 * Components
 *
 * Load specific components for use in the application.
 * @access public
 */
    public $components = array(
		'Security' => array(
			'csrfUseOnce' => false,
		),
		'Auth' => array(
			'authError' => 'You must have permission to access that.',
			'authenticate' => array(
				'Form' => array(
					'fields' => array('username' => 'email_address')
				),
			),
			'authorize' => 'Controller',
			'loginRedirect' => '/users',
			'logoutRedirect' => '/',
			'autoRedirect' => false,
			'userScope' => array('User.active' => 1, 'User.disabled' => 0),
		),
		'Session',
	);

/**
 * Helpers
 *
 * Load specific helpers for use in the application.
 * @access public
 */
    public $helpers = array('Session','Html', 'Js', 'Form');

/**
 * Permitted
 *
 * Allow access to specific controllers for any visitors.
 * @access public
 */
    public $permitted = array('Pages');

/**
 * Before Filter
 *
 * @return void
 * @access public
 */
	public function beforeFilter() {
		$this->_checkAuthentication();
		$locale = Configure::read('Config.language');
		if ($locale && file_exists($locale . DS . $this->viewPath)) {
			$this->viewPath = $locale . DS . $this->viewPath;
		}
	}

/**
 * Check Authentication
 *
 * Check to see if the user is logged in.
 *
 * @return void
 * @access protected
 */
	protected function _checkAuthentication() {
		if (in_array($this->name, $this->permitted)) {
			$this->Auth->allow('*');
		}
		Configure::write('user_id', false);
		if ($this->Auth->user('role') !== 'Admin') {
			if ($this->Auth->user('id')) {
				Configure::write('user_id', $this->Auth->user('id'));
			}
		}
		if ($this->Auth->user('role') == 'Admin') {
			$this->Auth->allow();
		}
		$this->set('Auth', $this->Auth->user());
	}

/**
 * Is Authorized?
 *
 * What does the user have access to? This will set the permissions availble to this users role
 *
 * @return mixed True/False If the user is authorized to access or not
 * @access protected
 */
	protected function _isAuthorized() {
		if ($this->Auth->user('disabled')) {
			return false;
		}
		$controller_name = $this->name;
		if (!empty($this->request->params['plugin'])) {
			$controller_name = Inflector::camelize($this->request->params['plugin']).'.'.$controller_name;
		}
		if (!$this->Session->check('Permissions')) {
			$this->_buildPermissions();
		}
		$permissions = $this->Session->read('Permissions');
		if ( in_array('*', array_keys($permissions)) ||
			( isset($permissions[$controller_name]) &&
				( in_array('*', array_values($permissions[$controller_name])) ||
					in_array($this->request->action, array_values($permissions[$controller_name]))
				)
			)
		) {
			return true;
		} else {
			return false;
		}
	}

/**
 * Build Permissions
 *
 * Get the list of permissions from the database and build an access array
 *
 * @return void
 * @access protected
 */
	protected function _buildPermissions() {
		$permissions = array();
		$permissions['Users'][] = 'logout';
		$this->loadModel('Permission');
		$permissionList = $this->Permission->find('list', array(
			'conditions' => array('Permission.role' => $this->Auth->user('role')),
			'fields' => array('Permission.name'),
			'recursive' => -1,
			));
		foreach ($permissionList as $permissionId => $permissionName) {
			$controller = '';
			$action = '';
			if (strpos($permissionName, ':') !== false) {
				list($controller,$action) = explode(":", $permissionName);
			} else {
				$controller = $permissionName;
			}
			$permissions[$controller][] = $action;
		}
		$this->Session->write('Permissions', $permissions);
	}
}