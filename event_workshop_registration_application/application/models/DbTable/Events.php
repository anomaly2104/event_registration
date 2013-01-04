<?php

// This class deals with the operation which are associated with the events table of the database. 
// It defines the various routines to facilitate the insertion, deletion and modification of the event data.
class Application_Model_DbTable_Events extends Zend_Db_Table_Abstract
{
	protected $_name = 'events'; // Table name events is initialized

	public function getEvent($id)		// This function fetches the event details for the event whose id is provided as argument
	{
		$id = (int)$id;
		$row = $this->fetchRow('id = ' . $id);	// Fetch the correct row.
		if (!$row) {		// Check for the valid data.
			throw new Exception("Could not find row $id");	// Throw exception in case of invalid data
		}
		return $row->toArray(); // Return data in case of valid row.
	}

	public function insertEvent($name, $type, $about, $organizer, $dt, $tym, $venue, $contactno, $contactemail)	// This funcion insetrs event details in the database. It takes as input the event information.
	{
		$ts = 'December 04 2013 17:50'; // Generate the timestamp.
		$data = array(				// Create the data array for inserting the event details.
				'name' => $name,
				'type' => $type,
				'about' => $about,
				'organizer' => $organizer,
				'dt' => $dt,
				'tym' => $tym,
				'venue' => $venue,
				'contactno' => $contactno,
				'contactemail' => $contactemail,
				'ts' => $ts
			     );
		$this->insert($data);	// Finally insert the data.
	}

	public function updateEvent($id, $name, $type, $about, $organizer, $dt, $tym, $venue, $contactno, $contactemail)     // This function updates the event details for the event whose id is provided as argument
	{
		$data = array(			// New data is stored here for updation.
				'name' => $name,
				'type' => $type,
				'about' => $about,
				'organizer' => $organizer,
				'dt' => $dt,
				'tym' => $tym,
				'venue' => $venue,
				'contactno' => $contactno,
				'contactemail' => $contactemail
			     );
		$this->update($data, 'id = '. (int)$id); // Updation is done based on the id.
	}

	public function removeEvent($id)	// This function deletes the event details for the event whose id is provided as argument
	{
		$this->delete('id =' . (int)$id);	// Delete function is called with appropriate event id.
	}
}
