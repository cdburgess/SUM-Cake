<?php
class AppController extends Controller {

    var $components = array('Auth','Session');
    var $user_id;
    var $permitted = array('Pages');                                                        // add any controllers that allow total access
    
    function beforeFilter(){
        $this->checkAuthentication();
    }
    
    private function checkAuthentication() {
        $this->Auth->fields = array('username'=>'email_address','password'=>'password');    //Override default fields used by Auth component
        $this->allowAccess();                                                               //run all generic access
        $this->Auth->logoutRedirect = '/';                                                  //Set the default redirect for users who logout
        $this->Auth->loginRedirect = '/';                                                   //Set the default redirect for users who login
        $this->Auth->authorize = 'controller';                                              //Extend auth component to include authorisation via isAuthorized action
        $this->Auth->userScope = array('User.active = 1');                                  //User must be active to gain access
        $this->set('Auth',$this->Auth->user());                                             //Pass auth component data over to view files
        if($this->Auth->user('role') !== 'Admin') {
            Configure::write('user_id', $this->Auth->user('id'));
        }
    }
        
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

    private function allowAccess() {
        if(in_array($this->name, $this->permitted)) {
          $this->Auth->allow('*');
        }
    }
    
    private function buildPermissions() {
        $permissions = array();
        $permissions['Users'][] = 'logout';                                                 // everyone gets access to logout
        App::import('Model', 'Permission');                                                 // get access to the Permissions model
        $thisPermission = new Permission;                                                   // create a new Permission instance
        $permissionList = $thisPermission->find('list', array(
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
}
?>