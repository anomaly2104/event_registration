<?php

// This class created a form which will allow the user to login to the application.
class Application_Form_Login extends Zend_Form
{
    public function init()
    {
        $this->setName('users');

	// username and password are used here for the authentication and thus fields for them have been added to the form.
	$username = new Zend_Form_Element_Text('username');
        $username->setLabel('User Name: ')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty');
			  
        $password = $this->createElement('password','password');
        $password->setLabel('Password: ')
                ->setRequired(true)
              ->addValidator('NotEmpty');

        $login = new Zend_Form_Element_Submit('login');
        $login->setLabel('Login');
	$login -> setAttrib("class", "submitb");

        $this->addElements(array($username, $password, $login));
	//All the elements created above are finally added to the Login form.
    }
}
