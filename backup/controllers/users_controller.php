<?php
class UsersController extends AppController {

	var $scaffold;
	function login() {
		if ($this->Session->read('Auth.User')) {
			$this->Session->setFlash('You are logged in!');
			$this->redirect('/', null, false);
		}
		echo $data;
		//echo ($this->Auth->hashPasswords($data));//$this->data['User']['password'];
		//echo $_POST['email'];
	}       

	function logout()
	{
		$this->Session->setFlash('Good-Bye');
		$this->redirect($this->Auth->logout());

	}
	
	function index() {
		$this->set('users', $this->User->find('all'));
	}
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('*'));
    }

	
	function initDB() {
		$group =& $this->User->Group;
		//Allow admins to everything
		$group->id = 1;     
		$this->Acl->allow($group, 'controllers');
	 
		//allow managers to posts and widgets
		$group->id = 2;
		$this->Acl->allow($group, 'controllers');
	 
		//allow users to only add and edit on posts and widgets
		/*$group->id = 3;
		$this->Acl->allow($group, 'controllers');      */  
		//we add an exit to avoid an ugly "missing views" error message
		echo "all done";
		exit;
}

}
?>