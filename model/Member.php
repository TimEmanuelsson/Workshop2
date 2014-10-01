<?php

class Member {
	private $id;
	private $firstName;
	private $lastName;
	private $identityNumber;
	
	public function __construct($id, $firstName, $lastName, $identityNumber) {
		$this->id = $id;
		$this->firstName = $firstName;
		$this->lastname = $lastName;
		$this->identityNumber = $identityNumber;
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




}

?>