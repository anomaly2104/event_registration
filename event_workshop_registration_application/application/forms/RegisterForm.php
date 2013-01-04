<?php

// This creates a form for reistering a user.
class Application_Form_RegisterForm extends Zend_Form
{
    public function init()
    {
	$fname = new Zend_Form_Element_Text('fname');
        $fname->setLabel('First Name:')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty');
        
	$lname = new Zend_Form_Element_Text('lname');
        $lname->setLabel('Last Name:')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty');
	
	$email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email Address:')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty');
	
	$username = new Zend_Form_Element_Text('username');
        $username->setLabel('Username:')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty');
                
        $password = $this->createElement('password','password');
        $password->setLabel('Password: *')
                ->setRequired(true);
                
        $confirmPassword = $this -> createElement( 'password', 'confirmPassword' );
        $confirmPassword -> setLabel( 'Confirm Password: *' )
                -> setRequired(true);
                
        $register = $this->createElement( 'submit', 'register' );
        $register-> setLabel( 'Register' )
                -> setIgnore( true )
              ->setRequired(true);
                
        $this -> addElements ( array( $fname, $lname, $email, $username, $password, $confirmPassword, $register ) );
	// All the elements are added to the form.
    }
}
