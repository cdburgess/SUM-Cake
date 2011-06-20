<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $components = array('Email');
	
	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('login','logout','register','password_request','reset_password');            
	}

	function login(){  }
	function admin_login(){ }

	function logout(){  
		$this->Session->delete('Permissions');
		$this->redirect($this->Auth->logout());
	}
	function admin_logout(){
		$this->Session->delete('Permissions');
		$this->redirect($this->Auth->logout());
	}
	
	function confirm($id = null){
	    if (!$id) {
		$this->Session->setFlash(__('Sorry, this user could not be activated.', true));
		$this->redirect(array('action' => 'index'));
	    } else {
		$this->set('user', $this->User->read(null, $id));
		$this->User->set('id', $id);
		$this->User->set('active', 1);
		if ($this->User->save('', false)) {
		    $this->Session->setFlash(__('You have been activated successfully.', true));
		    $this->redirect(array('action' => 'login'));
		} else {
		    $this->Session->setFlash(__('Sorry, this user could not be activated.', true));
		    $this->redirect(array('action' => 'login'));
		}
	    }
	}
	
	
	/**
	 * reset_password
	 *
	 * The custom code they come in with is only usable once. Once the password
	 * is reset, the code will no longer work for resetting any passwords.
	 */
	function reset_password($user_id = null, $password = null) {
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('Password has been updated', true));
				$this->redirect(array('action' => 'login'));
			} else {
				$user = $this->User->find('first', array('conditions' => array('id' => $this->data['User']['id'])));   
			}
		} else {
			// if data is empty, this is the first visit
			if(!empty($user_id) and !empty($password)) {
				// allow the user to reset the password if the userid and password match
				$user = $this->User->find('first', array('conditions' => array('id' => $user_id)));
				
				if($user['User']['password'] !== $password) {
					$this->Session->setFlash(__('Sorry! User information did not match.', true));
					$this->redirect(array('action' => 'index'));
				}
			} else {
				$this->Session->setFlash(__('Sorry! You request cannot be granted.', true));
				$this->redirect(array('action' => 'index'));
			}
		}
		$this->set('id', $user_id);                                     // required for updating
		$this->set('email_address', $user['User']['email_address']);    // required for hashing passwords
	}
	
	/**
	 * reset_password_request
	 *
	 * Since the passwords are encrypted, we cannot just send them the password,
	 * we have to send them the ability to reset the password.
	 */
	function password_request() {
		if (!empty($this->data)) {
			$user = $this->User->find('first', array('conditions' => array('email_address' => $this->data['User']['email_address'])));
			if (!empty($user['User']['email_address'])) {
		$system_email = Configure::read('SystemEmail');
		$this->Email->to = $user['User']['email_address'];
		$this->Email->subject = 'Password Reset Request';
		$this->Email->replyTo = $system_email;
		$this->Email->from = $system_email;
		$this->Email->template = 'password_reset'; 
		$this->Email->sendAs = 'both'; //Send as 'html', 'text' or 'both' (default is 'text')
		$this->set('site', FULL_BASE_URL . $this->base);
		$this->set('link', FULL_BASE_URL . $this->base . '/users/reset_password/'.$user['User']['id'].'/'.$user['User']['password']);
		$this->Email->send();
			}
			$this->Session->setFlash(__('Reset email has been sent.', true));
			$this->redirect(array('action' => 'login'));
		}
	}
	
	function register() {
		if (!empty($this->data)) {
		    if(Configure::read('autoValidate') == true) {
		        $this->data['User']['active'] = 1;
		    } else {
		        $this->data['User']['active'] = 0;
		    }
        	$this->User->create();
        	if ($this->User->save($this->data)) {
	    
	            if(Configure::read('welcomeEmail') == true) {
        		    $company_name = Configure::read('CompanyName');
            		$system_email = Configure::read('SystemEmail');
		
            		// send welcome email with confirmation link
            		$this->Email->to = $this->data['User']['email_address'];
            		$this->Email->subject = 'Welcome to '.$company_name;
            		$this->Email->replyTo = $system_email;
            		$this->Email->from = $system_email;
            		$this->Email->template = 'welcome'; 
            		$this->Email->sendAs = 'both'; //Send as 'html', 'text' or 'both' (default is 'text')
            		if(Configure::read('autoValidate') == false) {
            		    $this->set('site', FULL_BASE_URL . $this->base);
                		$this->set('link', FULL_BASE_URL . $this->base . '/users/confirm/' . $this->User->id);
            		}
            		$this->set('company_name', $company_name);
            		$this->Email->send();
		        }
        		$this->Session->setFlash(__('You have been registered!', true));
        		$this->redirect(array('action' => 'login'));
        	} else {
        		$this->Session->setFlash(__('You could not be registered. Please, try again.', true));
        	}
		}
	}
        	
	function index() {
		$this->set('user', $this->User->find());
	}

	function change_password() {
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The user has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->find();
		}
	}
	
	function edit() {
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->_update_session();
				$this->Session->setFlash(__('The user has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->find();
		}
        $this->set('gender', $this->User->getEnumValues('gender'));
	}
	
	/**
	 * Admin Content
	 */
	function admin_index() {
            $this->User->recursive = 0;
            $this->set('users', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid user', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->User->create();
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The user has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.', true));
			}
		}
		$this->set('role', $this->User->getEnumValues('role'));
                $this->set('active', $this->User->getEnumValues('active'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid user', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The user has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}
		$this->set('role', $this->User->getEnumValues('role'));
                $this->set('active', $this->User->getEnumValues('active'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for user', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->delete($id)) {
			$this->Session->setFlash(__('User deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('User was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	function _update_session() {
	    $user = $this->User->find();
	    foreach($user['User'] as $key => $value) {
		if($key !== 'password') {
		    $this->Session->write('Auth.User.'.$key, $value);
		}
	    }
	}
}