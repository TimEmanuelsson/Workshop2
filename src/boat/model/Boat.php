<?php
require_once('./src/boat/model/BoatType.php');

class Boat
{
	private $id;
	private $boatTypeID;
	private $length;
	private $boatType;
	
	public function __construct($id, $boatTypeID, $length, BoatType $boatType = NULL)
	{
		// Validerar indata.
		$this->validateId($id);
		$this->validateId($boatTypeID);
		$this->validateLength($length);
		
		// Sätter värdet på de privata variablerna.
		$this->id = $id;
		$this->boatTypeID = $boatTypeID;
		$this->length = $length;
		
		if($boatType != NULL)
		{
			$this->boatType = $boatType;
		}
	}
	
	// Hämtar båtens ID.
	public function getID()
	{
		return $this->id;
	}
	
	// Hämtar båttypID:t.
	public function getBoatTypeID()
	{
		return $this->boatTypeID;
	}
	
	// Hämtar båtens längd.
	public function getLength()
	{
		return $this->length;
	}
	
	// Hämtar båttypen.
	public function getBoatType()
	{
		return $this->boatType->getBoatType();
	}
	
	// Validerar ID:t.
	private function validateId($id)
	{
		if(!isset($id) || !is_numeric($id) || $id < 0 || $id > 99999999999)
		{
			throw new ValidationException("Bad ID.");
		}
	}
	
	// Validerar båtlängden.
	private function validateLength($length)
	{
		if(!isset($length) || !is_numeric($length) || $length < 1 || $length > 99999999999)
		{
			throw new ValidationException("Invalid boat length.");
		}
	}
}

?>