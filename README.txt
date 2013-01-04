
CreEvent : EVENT/WORKSHOP REGISTRATION APPLICATION

Tree Structure of the project;
.
|-- application
|   |-- Bootstrap.php
|   |-- configs
|   |   `-- application.ini => contains all the resources related information like database name, login username and password of database etc.
|   |-- controllers
|   |   |-- ErrorController.php
|   |   `-- IndexController.php => It is a fallback controller and which also serves the home page of the site. Contains many actions.
|   |-- forms
|   |   |-- Event.php	=>	Form for event registration.
|   |   |-- Login.php	=>	Form for user login.
|   |   `-- RegisterForm.php	=>	Form for user registration.
|   |-- layouts
|   |   `-- scripts
|   |       `-- layout.phtml	=> Defines the layout.
|   |-- models
|   |   `-- DbTable
|   |       |-- Events.php	=> 	To interact with events table in the database like insert, delete and modify event information.
|   |       `-- Users.php	=> 	To interact with users table in the database like insert, delete and modify user information.
|   `-- views
|       |-- helpers
|       `-- scripts
|           |-- error
|           |   `-- error.phtml
|           `-- index
|               |-- allevents.phtml	=> View for 'allevents' action
|               |-- create.phtml	=> View for 'create' action
|               |-- delete.phtml	=> View for 'delete' action
|               |-- edit.phtml	=> View for 'edit' action
|               |-- home.phtml	=> View for 'home' action
|               |-- index.phtml	=> View for 'index' action
|               |-- logout.phtml	=> View for 'logout' action
|               |-- promote.phtml	=> View for 'promote' action
|               |-- publish.phtml	=> View for 'publish' action
|               |-- register.phtml	=> View for 'register' action
|               `-- sampledata.phtml	=> View for 'sampledata' action
|-- library
|-- public
|   |-- css
|   |   |-- \
|   |   |-- images
|   |   |   `-- head-logo.png
|   |   `-- style.css		=>	this file contains all styling information of system
|   `-- index.php	
`-- tests
    |-- application
    |   `-- bootstrap.php
    |-- library
    |   `-- bootstrap.php
    `-- phpunit.xml


There are total 10 actions created in this application which are:
	insert => to insert new event
	edit => to edit existing event
	delete => to delete existing event
	allevents => to displays all the events created.
	publish => to publish the existing event
	promote => to promote the existing event
	home => this file contains home page to event registraion system after the user logs in
	index => this file displays the login form
	register => this file displays the signup form
	logout => this file is for logging user out
