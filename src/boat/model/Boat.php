<?php

class Boat {
	private $id;
	private $boatTypeID;
	private $memberID;
	private $length;
	
	public function __construct($id, $boatTypeID, $memberID, $length) {
		$this->validateId($id);
		$this->validateId($boatTypeID);
		$this->validateId($memberID);
		$this->validateLength($length);
		
		$this->id = $id;
		$this->boatTypeID = $boatTypeID;
		$this->memberID = $memberID;
		$this->length = $length;
	}
	
	public function getID() {
		return $this->id;
	}
	
	public function getBoatTypeID() {
		return $this->boatTypeID;
	}
	
	public function getMemberID() {
		return $this->memberID;
	}
	
	public function getLength() {
		return $this->length;
	}

	private function validateId($id) {
		if(!isset($id) || !is_numeric($id) || $id < 1 || $id > 99999999999) {
			throw new ValidationException("Bad ID.");
		}
	}
	
	private function validateLength($length) {
		if(!isset($length) || !is_numeric($length) || $length < 1 || $length > 99999999999) {
			throw new ValidationException("Invalid boat length.");
		}
	}

}

?>