<?php
require_once('./src/exceptions/ValidationException.php');

class Member {
	private $id;
	private $firstName;
	private $lastName;
	private $identityNumber;
	private $boats;
	
	public function __construct($id, $firstName, $lastName, $identityNumber, $boats) {
		self::validateId($id);
		self::validateName($firstName);
		self::validateName($lastName);
		self::validateIdentityNumber($identityNumber);
		
		$this->id = $id;
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->identityNumber = $identityNumber;
		$this->boats = $boats;
	}
	
	public function addBoat(Boat $boat) {
		$this->boat[] = $boat;
	}
	
	public function getID() {
		return $this->id;
	}
	
	public function getFirstName() {
		return $this->firstName;
	}
	
	public function getLastName() {
		return $this->lastName;
	}
	
	public function getIdentityNumber() {
		return $this->identityNumber;
	}
	
	public function getBoats() {
		return $this->boats;
	}

	static public function validateId($id) {
		if(!isset($id) || !is_numeric($id) || $id < 1 || $id > 99999999999) {
			throw new ValidationException("Bad memberID.");
		}
	}
	
	static public function validateName($name) {
		if(!isset($name) || $name = "" || strlen($name) < 2 || strlen($name) > 30) {
			throw new ValidationException("Bad member name.");
		}
	}
	
	static public function validateIdentityNumber($iNumber) {
		if(!preg_match("/^\d{6}\-\d{4}$/", $iNumber)) {
			throw new ValidationException("Bad member identity number.");
		}
	}


}

?>

