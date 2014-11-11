<?php
require_once('./src/exceptions/ValidationException.php');

class Member
{
	private $id;
	private $firstName;
	private $lastName;
	private $identityNumber;
	private $boats;
	
	public function __construct($id, $firstName, $lastName, $identityNumber, $boats = NULL)
	{
		// Validerar indata.
		$this->validateId($id);
		$this->validateName($firstName);
		$this->validateName($lastName);
		$this->validateIdentityNumber($identityNumber);
		
		// Sätter värdet på de privata variablerna.
		$this->id = $id;
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->identityNumber = $identityNumber;
		$this->boats = $boats;
	}
	
	// Lägger till en båt till medelmmens båt-array.
	public function addBoat(Boat $boat)
	{
		$this->boats[] = $boat;
	}
	
	// Hämtar medlemmens ID.
	public function getID()
	{
		return $this->id;
	}
	
	// Hämtar medlemmens förnamn.
	public function getFirstName()
	{
		return $this->firstName;
	}
	
	// Hämtar medlemmens efternamn.
	public function getLastName()
	{
		return $this->lastName;
	}
	
	// Hämtar medlemmens personnummer.
	public function getIdentityNumber()
	{
		return $this->identityNumber;
	}
	
	// Hämtar medlemmens båtar.
	public function getBoats() 
	{
		return $this->boats;
	}
	
	// Validerar ID:t.
	private function validateId($id)
	{
		if(!isset($id) || !is_numeric($id) || $id < 0 || $id > 99999999999)
		{
			throw new ValidationException("Bad memberID.");
		}
	}
	
	// Validerar namn-strängar.
	private function validateName($name)
	{
		if(!isset($name) || $name = "" || strlen($name) < 2 || strlen($name) > 30)
		{
			throw new ValidationException("Bad member name.");
		}
	}
	
	// Validerar personnummer.
	private function validateIdentityNumber($iNumber)
	{
		if(!preg_match("/^\d{6}\-\d{4}$/", $iNumber))
		{
			throw new ValidationException("Bad member identity number.");
		}
	}
}

?>

