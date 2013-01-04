<?php
require_once 'Zend/Auth.php';
require_once 'Zend/Auth/Adapter/DbTable.php';
require_once 'Zend/Auth/Adapter/Interface.php';

//IndexController is a fallback controller and also serves the home page of the site.

class IndexController extends Zend_Controller_Action
{

	public function init()
	{
		/* Initialize action controller here */
	}

	// Code for various action are defined over here.

	public function indexAction()
	{
		// body for index action.
		// Checking whether the user is already logged in. If yes then skipping the login part.
		$sessionStorage = new Custom_Session_Storage();	// Using Zend Session in the Custom session storage to store the user information in the session.
		$data = $sessionStorage -> load("username");	// Loading user information from zend session
		if($data != null){				// Checking whether the user information is there in the zend session.
			$this->_redirect('index/home'); 	//Login is skipped
		}

		$loginForm=new Application_Form_Login(); 	// Object form for the applcation form is created.
		$loginForm->setMethod('post');	// Form method is defined to be post.

		$users= new Application_Model_DbTable_Events();	// Connection with the database is done over here.

		$this->view->loginForm=$loginForm;	// The login form is assigned to the view.
		
		// First, We first check that whether the users has posted the request. 
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();
		   	
			//If yes, then we check that he has submitted valid form. 
			if ($loginForm->isValid($formData)) {
		   		//If both the condition return true, we get the values submitted.
				
				$inUsername=$loginForm->getValue('username'); // Getting the user input values.
				$inPassword=$loginForm->getValue('password');

				$adapter = new Zend_Auth_Adapter_DbTable($users->getAdapter(),'users'); /*Here DbTable Adapter provided by Zendis being used, giving adapter and database table name..*/
				$adapter->setTableName('users')		/*Next we set identity and credential columns.*/
					->setIdentityColumn('username')		
					->setCredentialColumn('password');

				$adapter->setIdentity($inUsername) /*After that we give posted values to the $adapter.*/
					->setCredential($inPassword);

				$auth=Zend_Auth::getInstance(); /*Getting instance of Zend_Auth to be used for authentication.*/
				$result=$auth->authenticate($adapter);	/*Calling Zend_Auth authenticate() for authentication.*/
				if($result->isValid()){		 /*Checking for the Valid User.*/
					 /*If the user is valid then storing the user info into the session for later use.*/
					$identity=$adapter->getResultRowObject();  
					$sessionStorage = new Custom_Session_Storage();
					$sessionStorage -> save('username', $identity); // Storing user data in session
					$this->_redirect('index/home');
				}
				else{
					$this->view->errorMessage="Wrong Username or Password";
				}
			}
			else {
				$loginForm->populate($formData);
			}
		}

	}

	 /*This function checkswhether the user is already logged in. If not then the user should not be allowed to perform any work until it logs in.*/
	public function checkLogin(){
		$sessionStorage = new Custom_Session_Storage(); // Getting user data from the session.
		$data = $sessionStorage -> load("username");
		if($data === null){		// Checking for a valid user.
			$this -> _helper -> redirector('index');
		}

	}

	/*This action is for the home page of the user.*/
	public function homeAction(){
		$sessionStorage = new Custom_Session_Storage();
		$data = $sessionStorage -> load("username");
		if($data === null){
			$this -> _helper -> redirector('index');
		}

		// Set the view first name and last name.
		$this -> view -> firstname = $data -> fname;
		$this -> view -> lastname = $data -> lname;
	}

	/* This action displays all the events created by all the users of the application.*/
	public function alleventsAction()
	{
		$this -> checkLogin();
		$events = new Application_Model_DbTable_Events();
		$this->view->events = $events->fetchAll(); // Fetching all the events stored in the dtabase.
	}

	/* This action allows the user to create a new event. */
	public function createAction()
	{
		$this -> checkLogin();
		$createForm = new Application_Form_Event();	// Form steps explained above.
		$this->view->createEventForm = $createForm;
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();
			if ($createForm->isValid($formData)) {
				$name = $createForm->getValue('name');	// Getting event data to be inserted.
				$type = $createForm->getValue('type');
				$about = $createForm->getValue('about');
				$organizer = $createForm->getValue('organizer');
				$dt = $createForm->getValue('dt');
				$tym = $createForm->getValue('tym');
				$venue = $createForm->getValue('venue');
				$contactno = $createForm->getValue('contactno');
				$contactemail = $createForm->getValue('contactemail');

				$eventsDbHandler = new Application_Model_DbTable_Events();
				$eventsDbHandler->insertEvent($name, $type, $about, $organizer, $dt, $tym, $venue, $contactno, $contactemail);					/*calling the insertEvent function made to insert event info in database*/

				$this->_redirect('index');
			} else {
				$createForm->populate($formData);
			}
		}

	}
	
	/* This action allows the user to edit a existing event. */
	public function editAction()
	{
		$this -> checkLogin();
		$editForm = new Application_Form_Event();
		$editForm->submit->setLabel('Save Changes');
		$this->view->form = $editForm;
		$id = $this->_getParam('id', 0);

		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();
			if ($editForm->isValid($formData)) {
				$name = $editForm->getValue('name');	// Getting data to be updated.
				$type = $editForm->getValue('type');
				$about = $editForm->getValue('about');
				$organizer = $editForm->getValue('organizer');
				$dt = $editForm->getValue('dt');
				$tym = $editForm->getValue('tym');
				$venue = $editForm->getValue('venue');
				$contactno = $editForm->getValue('contactno');
				$contactemail = $editForm->getValue('contactemail');
				$eventsDbHandler = new Application_Model_DbTable_Events();
				$eventsDbHandler->updateEvent($id, $name, $type, $about, $organizer, $dt, $tym, $venue, $contactno, $contactemail);				/*calling the updateEvent function made to update event info in database*/
				$this->_redirect('index/allevents');
			} else {
				$editForm->populate($formData);
			}
		} else {
			if ($id > 0) {
				$events = new Application_Model_DbTable_Events();
				$editForm->populate($events->getEvent( $id ));
			}
		}

	}

	/* This action allows the user to delete an existing event. */
	public function deleteAction()
	{
		$this -> checkLogin();
		if ($this->getRequest()->isPost()) {
			$del = $this->getRequest()->getPost('del');
			if ($del == 'Yes') {		// Conforming deletion from the user.
				$id = $this->getRequest()->getPost('id');
				$events = new Application_Model_DbTable_Events();
				$events->removeEvent($id);	/* Here the event is deleted from database by using the id*/
			}
			$this->_redirect('index/allevents');
		} else {
			$id = $this->_getParam('id', 0);
			$events = new Application_Model_DbTable_Events();
			$this->view->event = $events->getEvent($id);
		}
	}

	/* This action allows the user to publish an existing event. */
	public function publishAction()
	{
		$this -> checkLogin();
		$form = new Application_Form_Event();
		$id = $this->_getParam('id', 0);	// Finding the id passed in the url.
		if($id>0){
			$events = new Application_Model_DbTable_Events();
			$this->view->event = $events->getEvent($id);	// Event data to be sent to the view.
		}
	}
	
	/* This action allows the user to promote an existing event. */
	public function promoteAction()
	{
		$this -> checkLogin();
		$form = new Application_Form_Event();
		$id = $this->_getParam('id', 0);	// Finding the id passed in the url.
		if($id>0){
			$events = new Application_Model_DbTable_Events();
			$this->view->event = $events->getEvent($id);
		}
	}

	/* This action allow the user to log out of the application. */
	public function logoutAction()
	{
		$sessionStorage = new Custom_Session_Storage(); 
		$sessionStorage -> clear('username'); // Clearing user info from the zend session.
		$this->_redirect('index');
	}

	/*This action allows a new user to get registered with the application. */
	public function registerAction()
	{
		$users= new Application_Model_DbTable_Users();
		$form=new Application_Form_RegisterForm();
		$this->view->form=$form;
		if($this->getRequest()->isPost()){	// Form functioning already explained above.
			if($form->isValid($_POST)){
				$data = $form->getValues();
				if($data['password'] != $data['confirmPassword']){	/*checking if passwords match if they do not match then credentials are not inserted*/
					$this->view->errorMessage = "Passwords don't match.";
					return;
				}
				unset($data['confirmPassword']);
				$users->insertUser($data);	/*calling the insertUser function made in Users.php to insert the data*/
				$this->_redirect('index/index');
			}
		}
	}

	/* This action is for inserting sample events data into the database. */
	public function sampledataAction(){
		$events = new Application_Model_DbTable_Events();

		// Insert Data Record 1
		$name = "New year party";
		$type = "Dance And Music";
		$about = "New Year Party in Delhi. Welcome New Year 2013 with a bash";
		$organizer = "Udit Aagarwal";
		$dt = "1/1/2013";
		$tym = "8:00 pm";
		$venue = "Delhi";
		$contactno = "9411656264";
		$contactemail = "uditiiita@gmail.com";

		$events -> insertEvent($name, $type, $about, $organizer, $dt, $tym, $venue, $contactno, $contactemail);

		$this -> view -> message = $this -> view -> message . " <br>Sample Data 1 Inserted";

		// Insert Data Record 2
		$name = "Freshers Party";
		$type = "Food, Music, Dance... n much more";
		$about = "Welcome party for the Freshers who have joined IIIT Allahabad this year.";
		$organizer = "Btech 4th Year Batch";
		$dt = "14 February 2013";
		$tym = "4:00 pm	";
		$venue = "IIITA Main Ground";
		$contactno = "9528852960";
		$contactemail = "uditagarwal37@gmail.com";

		$events -> insertEvent($name, $type, $about, $organizer, $dt, $tym, $venue, $contactno, $contactemail);

		$this -> view -> message = $this -> view -> message . " <br> Sample Data 2 Inserted";

		$this -> view -> message = $this -> view -> message . " <br><br> All Sample Data Inserted";
	}
}

/*This class provides th storage facility in the session. It uses Zend Sessions for its functioning. */
class Custom_Session_Storage {

	/* This funtion stores data in the zend session in the specified namespace. */
	public function save($name = 'default', $data) {

		$session = new Zend_Session_Namespace($name);
		$session->data = $data; // Saving data in the zend session.

		return true;
	}

	/* This funtion loads data from the zend session in the specified namespace. */
	public function load($name = 'default', $part = null) {

		$session = new Zend_Session_Namespace($name);

		if (!isset($session->data))
			return null;

		$data = $session->data; // getting the data.

		if ($part && isset($data[$part]))
			return $data[$part];

		return $data;
	}

	/* This funtion clears data from the zend session from the specified namespace. */
	public function clear($name = 'default') {

		$session = new Zend_Session_Namespace($name);

		if (isset($session->data))
			unset($session->data);

		return true;
	}
}

?>
