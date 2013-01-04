<?php

//This Class creates a form to register for the event.
class Application_Form_Event extends Zend_Form
{
    public function init()
    {
        $this->setName('event');
	
	//Many Fields are created to be added to the form of the event/
	/*
		Fields are:
			1. name of the event
			2. type of event
			3. about the event 
			4. organizer of the event
			5. Date
			6. Time
			7. Venue
			8. Contact Details
	*/
	$name = new Zend_Form_Element_Text('name');
        $name->setLabel('Name')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty');
			  
        $type = new Zend_Form_Element_Text('type');
        $type->setLabel('Type')
              ->setRequired(true)
               ->addFilter('StripTags')
               ->addFilter('StringTrim')
              ->addValidator('NotEmpty');
	
	$about = new Zend_Form_Element_Text('about');
        $about->setLabel('About the Event')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty');

	$organizer = new Zend_Form_Element_Text('organizer');
        $organizer->setLabel('Organizer')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty');

	$dt = new Zend_Form_Element_Text('dt');
        $dt->setLabel('Date')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty');
	
	$tym = new Zend_Form_Element_Text('tym');
        $tym->setLabel('Time')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty');
			  
	$venue = new Zend_Form_Element_Text('venue');
        $venue->setLabel('Venue')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty');
			  
	$contactno = new Zend_Form_Element_Text('contactno');
        $contactno->setLabel('Contact Number')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty');	  
	
	$contactemail = new Zend_Form_Element_Text('contactemail');
        $contactemail->setLabel('Contact Email')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty');	  
			  
        $createButton = new Zend_Form_Element_Submit('submit');
	$createButton->setLabel('Create New Event');
        $createButton->setAttrib('class', 'submitb');
        
	$this->addElements(array($name, $type, $about, $organizer, $dt, $tym, $venue, $contactno, $contactemail, $createButton));
	// All the elements created above are finally added to the form
    }
}
