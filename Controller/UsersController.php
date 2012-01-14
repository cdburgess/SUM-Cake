<?php
/**
* Users controller class.
*
* @link http://github.com/cdburgess/SUM-Cake
* @package cake
* @subpackage app.controller
* @license http://creativecommons.org/licenses/by-sa/3.0/
*/
class UsersController extends AppController {

    /**
    * Var Users
    * @var string 'Users'
    * @access public
    */
	var $name = 'Users';
	
	/**
	* Var Components
	* @var string Components
	* @access public
	*/
	var $components = array('Email');
	
	/**
	* Before Filer
	*
	* @return void
	* @access public
	*/
	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('login','logout','register','password_request','reset_password','confirm');            
	}

    /**
    * Login for Users
    *
    * Anyone can login using this method
    *
    * @return void
    * @access public
    */
	function login() { 
		if(!empty($this->request->data['User']) && $this->Auth->login()) {
	        $this->User->unset_password_request($this->Auth->user('id'));
			if($this->Auth->user('role') == 'Admin') {
				if ($this->Auth->redirect() == '/users') {
					$this->Session->write('Auth.redirect', '/admin/users');
				}
			}
			$this->redirect($this->Auth->redirect());
        }        
	}
	
	/**
    * Admin Login for Admins
    *
    * Anyone can login using this method
    *
    * @return void
    * @access public
    */
	function admin_login() { 
	    if(!empty($this->request->data['User']) && $this->Auth->login()) {
			$this->User->unset_password_request($this->Auth->user('id'));
	        if($this->Auth->user('role') == 'Admin') {
				if ($this->Auth->redirect() == '/users') {
					$this->Session->write('Auth.redirect', '/admin/users');
				}
			}
			$this->redirect($this->Auth->redirect());
        }
	}
	
    /**
    * Logout
    *
    * Users will logout.
    *
    * @return void
    * @access public
    */
	function logout(){  
		$this->Session->delete('Permissions');
		$this->redirect($this->Auth->logout());
	}
	
	/** 
	* Admin Logout
	*
	* Administrators logout.
	*
	* @return void
	* @access public
	*/
	function admin_logout(){
		$this->Session->delete('Permissions');
		$this->redirect($this->Auth->logout());
	}
	
	/**
	* Confirm Account
	*
	* The user clicks a confirmation link sent via email during the registration process and
	* is brought to this link to confirm they in fact are the subscriber. This will change the
	* user record by setting the active column = 1. This allows the user to login.
	*
	* @param string $id The user_id to confirm.
	* @return void
	* @access public
	*/
	function confirm($id = null){
	    if (!$id) {
		    $this->Session->setFlash(__('Sorry, this user could not be activated.'));
		    $this->redirect(array('action' => 'index'));
	    } else {
		    $this->set('user', $this->User->read(null, $id));
		    $this->User->set('id', $id);
		    $this->User->set('active', 1);
		    if ($this->User->save('', false)) {
    		    $this->Session->setFlash('You have been activated successfully.', 'flash_success');
    		    $this->redirect(array('action' => 'login'));
    		} else {
    		    $this->Session->setFlash(__('Sorry, this user could not be activated.'));
    		    $this->redirect(array('action' => 'login'));
    		}
	    }
	}
	
	
	/**
	 * Reset Password
	 *
	 * The custom code they come in with is only usable once. Once the password
	 * is reset, the code will no longer work for resetting any passwords. Also, the
	 * password_requested flag on the users table must be set to 1 for the code to
	 * to work.
	 *
	 * @param string $user_id The user_id to reset the password for
	 * @param string $password The encrypted password for the existing account
	 * @return void
	 * @access public
	 */
	function reset_password($user_id = null, $password_requested = null) {
		if (!empty($this->request->data)) {
			if ($this->User->save($this->request->data)) {
			    $this->User->unset_password_request($this->request->data['User']['id']);
				$this->Session->setFlash('Password has been updated', 'flash_success');
				$this->redirect(array('action' => 'login'));
			} else {
			    $this->Session->setFlash(__('Sorry! User information could not be saved.'));
				$this->redirect(array('action' => 'login'));
			}
		} else {
		    if ($user_id == null or $password_requested == null) {
    	        $this->Session->setFlash(__('Sorry! You request cannot be granted.'));
    			$this->redirect(array('action' => 'login'));
    	    }
			$user = $this->User->find('first', array('conditions' => array('id' => $user_id)));
			if($user['User']['password_requested'] == 0) {
			    $this->Session->setFlash(__('The password reset request was deactivated.'));
				$this->redirect(array('action' => 'login'));
			}
			if($user['User']['password_requested'] !== $password_requested) {
				$this->Session->setFlash(__('Sorry! User information did not match.'));
				$this->redirect(array('action' => 'login'));
			}
		}
		$this->set('id', $user_id);
		$this->set('email_address', $user['User']['email_address']);
	}
	
	/**
	 * Password Request
	 *
	 * Since the passwords are encrypted, we cannot just send them the password,
	 * we have to send them the ability to reset the password.
	 *
	 * @return void
	 * @access public
	 */
	function password_request() {
		if (!empty($this->request->data)) {
		    $user = '';
			$my_user = $this->User->find('first', array('conditions' => array('email_address' => $this->request->data['User']['email_address'])));
			if($this->User->set_password_request($my_user['User']['id'])) {
			    $user = $this->User->find('first', array('conditions' => array('id' => $my_user['User']['id'])));
			} else {
			    $this->Session->setFlash(__('Password could not be reset. Please, try again.'));
    			$this->redirect(array('action' => 'login'));
			}
			
			if (!empty($user['User']['email_address'])) {
		        $system_email = Configure::read('SystemEmail');
        		$this->Email->to = $user['User']['email_address'];
        		$this->Email->subject = 'Password Reset Request';
        		$this->Email->replyTo = $system_email;
        		$this->Email->from = $system_email;
        		$this->Email->template = 'password_reset'; 
        		$this->Email->sendAs = 'both'; //Send as 'html', 'text' or 'both' (default is 'text')
        		$this->set('site', FULL_BASE_URL . $this->request->base);
        		$this->set('link', FULL_BASE_URL . $this->request->base . '/users/reset_password/'.$user['User']['id'].'/'.$user['User']['password_requested']);
        		if(Configure::read('smtpEmailOn') == true) {
        		    $this->useSmtp();
        		}
        		$this->Email->send();
			}
			$this->Session->setFlash('Reset email has been sent.', 'flash_success');
			$this->redirect(array('action' => 'login'));
		}
	}
	
	/**
	* Register
	*
	* Allows users to register. This will send a welcome email (if enabled) allowing them to activate
	* their account from a link in an email. This provides a "double opt-in" security measure so people
	* cannot be given access on an email account they do not own. If autoValidate is set to true, the
	* account will be activated automatically.
	*
	* @return void
	* @access public
	*/
	function register() {
		if (!empty($this->request->data)) {
		    if(Configure::read('autoValidate') == true) {
		        $this->request->data['User']['active'] = 1;
		    } else {
		        $this->request->data['User']['active'] = 0;
		    }
        	$this->User->create();
        	if ($this->User->save($this->request->data)) {
	    
	            if(Configure::read('welcomeEmail') == true) {
        		    $company_name = Configure::read('WebsiteName');
            		$system_email = Configure::read('SystemEmail');
		
            		// send welcome email with confirmation link
            		$this->Email->to = $this->request->data['User']['email_address'];
            		$this->Email->subject = 'Welcome to '.$company_name;
            		$this->Email->replyTo = $system_email;
            		$this->Email->from = $system_email;
            		$this->Email->template = 'welcome'; 
            		$this->Email->sendAs = 'both'; //Send as 'html', 'text' or 'both' (default is 'text')
            		if(Configure::read('autoValidate') == false) {
            		    $this->set('site', FULL_BASE_URL . $this->request->base);
                		$this->set('link', FULL_BASE_URL . $this->request->base . '/users/confirm/' . $this->User->id);
            		}
            		$this->set('company_name', $company_name);
            		if(Configure::read('smtpEmailOn') == true) {
            		    $this->useSmtp(); // load the smpt values from app_controller.php
            		}
            		$this->Email->send();
		        }
        		$this->Session->setFlash('You have been registered!', 'flash_success');
        		if (Configure::read('autoValidate') == true) {
        		    $this->redirect(array('action' => 'login'));
        		} else {
        		    $this->render('register_success');
    		    }
        	} else {
        		$this->Session->setFlash(__('You could not be registered. Please, try again.'));
        	}
		}
	}
    
    /**
    * Index
    *
    * The main screen for the user to see their credentials. This can be modified to incorporate other
    * information as added by the developer. Currently it shows the users username (which is their email).
    *
    * @return void
    * @access public
    */
	function index() {
		$this->set('user', $this->User->find());
	}

    /**
    * Change Password
    *
    * This function allows the user to change their password.
    *
    * @return void
    * @access public
    */
	function change_password() {
		if (!empty($this->request->data)) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash('Your password has been changed', 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->User->find();
		}
	}
	
	/**
	* Edit
	*
	* Allows the user to change their email address.
	*
	* @return void
	* @access public
	*/
	function edit() {
		if (!empty($this->request->data)) {
			if ($this->User->save($this->request->data)) {
				$this->_update_session();
				$this->Session->setFlash('Your information has been updated', 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->User->find();
		}
	}
	
	/**
	 * Admin Content
	 */
    
    /**
    * Admin Index
    *
    * Show all users in the system.
    *
    * @param string $search_string The value of a search submission
    * @return void
    * @access public
    */
	function admin_index($search_string = null) {
		$conditions = null;
		if(!empty($this->request->data)){
			$filter = $this->request->data['User']['search_string'];
			$conditions = $this->User->build_filter_conditions($filter);
		}
		

		$this->User->recursive = 0;
		$this->set('users', $this->paginate($conditions));
		$this->set('search_string', $search_string);
	}

    /**
    * Admin View
    *
    * View details of a specific user.
    *
    * @param string $id The id of the user to view.
    * @return void
    * @access public
    */
	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid user'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

    /**
    * Admin Add
    * 
    * Add a new user to the system.
    *
    * @return void
    * @access public
    */
	function admin_add() {
		if (!empty($this->request->data)) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash('The user has been saved', 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
		$this->set('role', $this->User->getEnumValues('role'));
                $this->set('active', $this->User->getEnumValues('active'));
	}
    
    /**
    * Admin Edit
    *
    * Edit a user in the system.
    *
    * @param string $id The id of the user to edit
    * @return void
    * @access public
    */
	function admin_edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid user'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash('The user has been saved', 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->User->read(null, $id);
		}
		$this->set('role', $this->User->getEnumValues('role'));
        $this->set('active', $this->User->getEnumValues('active'));
	}

    /**
    * Admin Reset Password
    *
    * Sends the user a reset password request.
    *
    * @param string $id The id of the user to edit
    * @return void
    * @access public
    */
   	function admin_reset_password($id = null) {
   	    if ($id == null) {
   	        $this->Session->setFlash(__('The user is not valid. Please, try again.'));
   	        $this->redirect(array('action' => 'index'));
   	    }
   		$user = $this->User->find('first', array('conditions' => array('id' => $id)));
   		$password_request_id = $this->User->set_password_request($user['User']['id']);
		if (!empty($user['User']['email_address'])) {
	        $system_email = Configure::read('SystemEmail');
    		$this->Email->to = $user['User']['email_address'];
    		$this->Email->subject = 'Password Reset Request';
    		$this->Email->replyTo = $system_email;
    		$this->Email->from = $system_email;
    		$this->Email->template = 'password_reset'; 
    		$this->Email->sendAs = 'both'; //Send as 'html', 'text' or 'both' (default is 'text')
    		$this->set('site', FULL_BASE_URL . $this->request->base);
    		$this->set('link', FULL_BASE_URL . $this->request->base . '/users/reset_password/'.$user['User']['id'].'/'.$password_request_id);
    		if(Configure::read('smtpEmailOn') == true) {
    		    $this->useSmtp();
    		}
    		$this->Email->send();
    		$this->User->set_password_request($user['User']['id']);
		}
		$this->Session->setFlash('Password reset email has been sent.', 'flash_success');
		$this->redirect(array('action' => 'index'));
   	}

    /**
    * Admin Delete
    *
    * Delete a user from the system.
    *
    * @param string id The id of the user to delete.
    * @return void
    * @access public
    */
	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for user'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->delete($id)) {
			$this->Session->setFlash('User deleted', 'flash_success');
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	/**
    * Admin Disable
    *
    * Disable a user from logging into the system.
    *
    * @param string $id The id of the user to disable
    * @return void
    * @access public
    */
	function admin_disable($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid user'));
			$this->redirect(array('action' => 'index'));
		}
		
		if ($this->User->disable($id)) {
			$this->Session->setFlash('The user has been disabled', 'flash_success');
		} else {
		    $this->Session->setFlash(__('The user could not be updated. Please, try again.'));
		}
		$this->redirect(array('action' => 'index'));
	}
	
	/**
    * Admin Enable
    *
    * Enable a user so they can log into the system.
    *
    * @param string $id The id of the user to disable
    * @return void
    * @access public
    */
	function admin_enable($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid user'));
			$this->redirect(array('action' => 'index'));
		}
		
		if ($this->User->enable($id)) {
			$this->Session->setFlash('The user has been enabled', 'flash_success');
		} else {
		    $this->Session->setFlash(__('The user could not be updated. Please, try again.'));
		}
		$this->redirect(array('action' => 'index'));
	}
	
	
	/**
	* Update Session
	*
	*
	* @return void
	* @access private
	*/
	private function _update_session() {
	    $user = $this->User->find();
	    foreach($user['User'] as $key => $value) {
		    if($key !== 'password') {
    		    $this->Session->write('Auth.User.'.$key, $value);
    		}
	    }
	}
	
}