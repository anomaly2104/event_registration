<?php

// This class deals with the operations which are associated with the users table of the database. 
// It defines the various routines to facilitate the insertion, deletion and modification of the users data.
class Application_Model_DbTable_Users extends Zend_Db_Table_Abstract
{

	protected $_name = 'users'; // Table name users is defined over here.


	public function insertUser($data)	// This function inserts the user information into the database. The information is passed as argument in the data array.
	{

		$this->insert($data);	// Data is finaly inserted.
	}



}

