<?php
require_once('./src/exceptions/ValidationException.php');

class Member {
	private $id;
	private $firstName;
	private $lastName;
	private $identityNumber;
	private $boats;
	
	public function __construct($id, $firstName, $lastName, $identityNumber, $boats) {
		$this->validateId($id);
		$this->validateName($firstName);
		$this->validateName($lastName);
		$this->validateIdentityNumber($identityNumber);
		
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

	private function validateId($id) {
		if(!isset($id) || !is_numeric($id) || $id < 1 || $id > 99999999999) {
			throw new ValidationException("Bad memberID.");
		}
	}
	
	private function validateName($name) {
		if(!isset($name) || $name = "" || strlen($name) < 2 || strlen($name) > 30) {
			throw new ValidationException("Bad member name.");
		}
	}
	
	private function validateIdentityNumber($iNumber) {
		if(!preg_match("/^\d{6}\-\d{4}$/", $iNumber)) {
			throw new ValidationException("Bad member identity number.");
		}
	}


}

?>

