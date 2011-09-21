<?php
class AppController extends Controller {
    var $components = array('Acl', 'Auth', 'Session');
	//var $helpers = array('Js' => array('jquery'));
    var $helpers = array('Html', 'Form', 'Session', 'Js');
	//var $loginErrorMsg = 'Username and/or Password incorrect.';

    function beforeFilter() {
		/*setup permission only run once
		$group =& $this->User->Group;
		//Allow admins to everything
		$group->id = 1;     
		$this->Acl->allow($group, 'controllers');
	 
		//allow managers to posts and widgets
		$group->id = 2;
		$this->Acl->allow($group, 'controllers');
	 
		//allow users to only add and edit on posts and widgets
		$group->id = 3;
		$this->Acl->allow($group, 'controllers');        
		//we add an exit to avoid an ugly "missing views" error message
		echo "all done";
		exit;*/
		
        //Configure AuthComponent
        $this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
        $this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');
        $this->Auth->loginRedirect = array('controller' => 'pages', 'action' => 'home');
		$this->Auth->fields = array('username' => 'email', 'password' => 'password');
		$this->Auth->userScope = array('authentication' => 'approved');
		$this->Auth->loginError = 'Username and/or Password incorrect.';
		//$this->Auth->authorize = 'action';
		$this->Auth->actionPath = 'controllers';

    }
	function isAuthorized() {
		/*if (isset($this->params[Configure::read('Routing.admin')])) {
			//  Usage: $this->Auth->user('field_in_user_model');
			if ($this->Auth->user('group_id') != 1) {
				return false;
			}
		}*/
		return true;
   }
}
?>
