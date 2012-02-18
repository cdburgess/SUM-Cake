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
    * Var Components
    *
    * Load specific components for use in the application.
    * @var $components
    * @access public
    */
    var $components = array(
		'Security',
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
    * Var Helpers
    *
    * Load specific helpers for use in the application.
    * @var $helpers
    * @access public
    */
    var $helpers = array('Session','Html', 'Js', 'Form');
    
    /**
    * Var Permitted
    *
    * Allow access to specific controllers for any visitors.
    * @var $permitted
    * @access public
    */
    var $permitted = array('Pages');
    
    /**
    * Before Filter
    *
    * @return void
    * @access public
    */
    function beforeFilter(){
		$this->_checkAuthentication();
    }
    
    /**
    * Check Authentication
    *
    * Check to see if the user is logged in.
    *
    * @return void
    * @access private
    */
    private function _checkAuthentication() {
		if(in_array($this->name, $this->permitted)) {
          $this->Auth->allow('*');
        }
		Configure::write('user_id', false);
        if($this->Auth->user('role') !== 'Admin') {
			if ($this->Auth->user('id')) {
            	Configure::write('user_id', $this->Auth->user('id'));
			}
        }
		$this->set('Auth', $this->Auth->user());
    }
    
    /**
    * Is Authorized?
    *
    * What does the user have access to? This will set the permissions availble to this users role
    *
    * @return mixed True/False If the user is authorized to access or not
    * @access public
    */
    function isAuthorized(){
        $controller_name = $this->name;
        if(!empty($this->request->params['plugin'])) {                                               // is this a plugin?
            $controller_name = Inflector::camelize($this->request->params['plugin']).'.'.$controller_name;   // prepend the name of the plugin
        }
        if (!$this->Session->check('Permissions')) { $this->buildPermissions(); }           // if permissions are not set in session
        $permissions = $this->Session->read('Permissions');                                 // read the permissions
        if ( in_array('*', array_keys($permissions)) ||                                     // super user (access to everything)
            ( isset($permissions[$controller_name]) and                                     // if permissions variable exists &&
              ( in_array('*', array_values($permissions[$controller_name])) ||              // global controller access OR
                in_array($this->request->action, array_values($permissions[$controller_name]))       // access to controller:action
              )
            ) 
        ) {
            return true;                                                                    // allow access
        } else {
            return false;                                                                   // reject access
        }
    }
    
    /**
    * Build Permissions
    *
    * Get the list of permissions from the database and build an access array
    *
    * @return void
    * @access public
    */
    public function buildPermissions() {
        $permissions = array();
        $permissions['Users'][] = 'logout';                                                 // everyone gets access to logout
        $this->loadModel('Permission');                                                     // load the Permission model
        $permissionList = $this->Permission->find('list', array(
                            'conditions' => array('Permission.role' => $this->Auth->user('role')),
                            'fields' => array('Permission.name'),
							'recursive' => -1,
                            )
                        );
        foreach ($permissionList as $permissionId => $permissionName) {                     // process each permission
            $controller = ''; $action = '';                                                 // clear the controller / action variables
            if (strpos($permissionName, ':') !== false) {                                   // if the permission has a :
                list($controller,$action) = explode(":",$permissionName);                   // split the controller / action
            } else {
                $controller = $permissionName;                                              // otherwise set the controller to permissionName
            }
            $permissions[$controller][] = $action;                                          // add controller[action] to permission array
        }
        $this->Session->write('Permissions',$permissions);                                  // write the permissions to the users session
    }
}