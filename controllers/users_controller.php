<?php
class UsersController extends AppController {

	var $name = 'Users';

	function initDB() {
		$group =& $this->User->Group;
		//Allow admins to everything
		$group->id = 1;     
		$this->Acl->allow($group, 'controllers');
	 
		//allow managers to posts and widgets
		//$group->id = 2;
		//$this->Acl->allow($group, 'controllers');
	 
		//allow users to only add and edit on posts and widgets
		/*$group->id = 3;
		$this->Acl->allow($group, 'controllers');      */  
		//we add an exit to avoid an ugly "missing views" error message
		echo "all done";
		exit;
}
	
	function login() {		
	//don't forget to check if the user has alreaady clicked the validation link
		if ($this->Session->read('Auth.User')) {
			$this->Session->setFlash('You are logged in!');
			$this->redirect('/', null, false);
		}
		
		//$this->loginErrorMsg = 'Username and/or Password incorrect.';
		
		$email =  $this->data['User']['email'];
		if ($email != '')
		{
			$user_entry = $this->User->find('first',array('conditions' => array('User.email'=>$email)));
			//$this->User->read(null, $user_entry['User']['id']);
			//	$this->User->set(array('authentication'=>'hello'));
			//	$this->User->save();
			if ($user_entry != null)
			{	
				if ($user_entry['User']['authentication'] != 'approved')
				{
				echo 'Account has NOT been validated. Please visit validation email again.';
				//$this->loginErrorMsg = 'Account has NOT been validated. Please visit validation email again.';
				}
					
			}
		}
		//echo $this->data['User']['email'];
		//echo ($this->Auth->hashPasswords($data));//$this->data['User']['password'];
		//echo $_POST['email'];
	}     


	//signup success
	function success()
	{

	}
	function rand_string( $length ) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";	
		$str ="";
		$size = strlen( $chars );
		for( $i = 0; $i < $length; $i++ ) {
			$str .= $chars[ rand( 0, $size - 1 ) ];
		}

		return $str;
	}    
	
	function validation($valStr, $email) {
		if ($valStr == null || $email == null)
			$this->redirect('/users/login');

		$validation_entry = $this->User->find('first',array('conditions' => array('User.email'=>$email, 'User.authentication' => $valStr)));

		if ($validation_entry == null)
		{	$this->redirect('/users/login');}
		else
		{
			//read($fields, $id)
			$this->User->read(null, $validation_entry['User']['id']);
			$this->User->set(array('authentication'=>'approved'));
			$this->User->save();
	
			echo $validation_entry['User']['name'];
		}
	}

	
	function signup()
	{
		if ($this->data == null)
			$this->redirect('/users/login');
		
		
		$user_entry = $this->User->find('first', array('conditions' => array('User.email' => $this->data['User']['email'])));
		
		if ($user_entry != null)
		{
			//email already registered
			/*?>
			<script type="text/javascript" charset="utf-8">
				alert("Email already registered.");
			</script>
			<?php*/
			$this->redirect('/users/duplicate_email');
		}
		else
		{
			$name = $this->data['User']['name'];
			$email = $this->data['User']['email'];
			$password = $this->data['User']['password'];
			$groupId = '1';
			$authentication = $this->rand_string(15);
			
			if ($this->User->save(array('name' => $name, 'email' => $email, 'password' => $password, 'group_id' => $groupId, 'authentication' => $authentication)))
			{
				$contact = $email;
				$subject = "Welcome to CampusWave!";
         
				$message = "<html><center>";
				$message .= "<head><font size=5 color=\"green\">Thank you for signing up with CampusWave!</font></head><body>";
				$message .= "<a href=\"http://campuswave.ca/index.php/users/validation/$authentication/$email\">Click here to confirm your registration.</a>";
				$message = rtrim(chunk_split(base64_encode($message)));
        
				$headers = "From: cwteam@campuswave.ca\r\n";
				$headers .= "Reply-To: cwteam@campuswave.ca\r\n";
				$headers .= "Return-Path: cwteam@campuswave.ca\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				$headers .= "Content-Transfer-Encoding: base64\r\n";
         
				mail($contact, $subject, $message, $headers);
			
			
				$this->redirect('/users/success');
			}
		}
		
		//echo $user_entry['User']['email'];
	}
    
	
	function duplicate_email(){}
	
	function logout()
	{
		$this->Session->setFlash('Good-Bye');
		$this->redirect($this->Auth->logout());

	}

	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allowedActions = array('login','validation','signup', 'duplicate_email' , 'success');
    }
	
	function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid user', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->User->create();
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The user has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.', true));
			}
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}

	function edit($id = null) {
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
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}

	function delete($id = null) {
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
}
?>