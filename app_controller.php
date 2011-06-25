<?php
/**
* App controller class.
*
* @link http://github.com/cdburgess/SUM-Cake
* @package cake
* @subpackage app
* @license http://creativecommons.org/licenses/by-sa/3.0/
*/
class AppController extends Controller {

    var $components = array('Auth','Session');
    var $helpers = array('Session','Html', 'Javascript', 'Form');
    var $user_id;
    var $permitted = array('/','Pages');                                                        // add any controllers that allow total access
    
    /**
    * Before Filter
    *
    * @return void
    * @access public
    */
    function beforeFilter(){
        $this->_checkAuthentication();
        $this->Auth->allow();         // override access by adding '*' inside the parenthesis
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
        $this->Auth->fields = array('username'=>'email_address','password'=>'password');    //Override default fields used by Auth component
        $this->Auth->logoutRedirect = '/';                                                  //Set the default redirect for users who logout
        $this->Auth->loginRedirect = '/admin/users';                                        //Set the default redirect for users who login
        $this->Auth->authorize = 'controller';                                              //Extend auth component to include authorisation via isAuthorized action
        $this->Auth->userScope = array('User.active = 1');                                  //User must be active to gain access
        $this->set('Auth',$this->Auth->user());                                             //Pass auth component data over to view files
        if($this->Auth->user('role') !== 'Admin') {
            Configure::write('user_id', $this->Auth->user('id'));
            $this->Auth->loginRedirect = '/users';
        }
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
        if (!$this->Session->check('Permissions')) { $this->buildPermissions(); }           // if permissions are not set in session
        $permissions = $this->Session->read('Permissions');                                 // read the permissions
        if ( in_array('*', array_keys($permissions)) ||                                     // super user (access to everything)
             in_array('*', array_values($permissions[$this->name])) ||                      // global controller access
             in_array($this->action, array_values($permissions[$this->name]))               // access to controller:action
        ) {
            return true;                                                                    // allow access
        } else {
            return false;                                                                   // reject access
        }
    }

    /**
    * Allow Access
    *
    * @return void
    * @access private
    */
    private function allowAccess() {
        if(in_array($this->name, $this->permitted)) {
          $this->Auth->allow('*');
        }
    }
    
    /**
    * Build Permissions
    *
    * Get the list of permissions from the database and build an access array
    *
    * @return void
    * @access private
    */
    private function buildPermissions() {
        $permissions = array();
        $permissions['Users'][] = 'logout';                                                 // everyone gets access to logout
        $this->loadModel('Permission');                                                     // load the Permission model
        $permissionList = $this->Permission->find('list', array(
                            'conditions' => array('Permission.role' => $this->Auth->user('role')),
                            'fields' => array('Permission.name'),
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
    
    /**
    * Use SMPT
    *
    * Set the email component to allow for SMPT connections. Settings are in the Bootstrap file.
    *
    * @return true
    * @access public
    */
    function useSmtp() {
        $this->Email->smtpOptions = array(
            'port' => Configure::read('smtpPort'),
            'timeout' => Configure::read('smtpTimeOut'),
            'host' => Configure::read('smtpHost'),
            'username' => Configure::read('smtpUsername'),
            'password' => Configure::read('smtpPassword'),
         );
        $this->Email->delivery = 'smtp';
        return true;
    }
}