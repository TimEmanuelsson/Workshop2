<?php
require_once('./src/boat/model/BoatType.php');

class Boat {
	private $id;
	private $boatTypeID;
	private $memberID;
	private $length;
	private $boatType;
	
	public function __construct($id, $boatTypeID, $memberID, $length, $boatType = NULL)
	{
		$this->validateId($id);
		$this->validateId($boatTypeID);
		$this->validateId($memberID);
		$this->validateLength($length);
		
		$this->id = $id;
		$this->boatTypeID = $boatTypeID;
		$this->memberID = $memberID;
		$this->length = $length;
		
		if($boatType != NULL)
		{
			$this->boatType = $boatType;
		}
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
	
	public function getBoatType() {
		return $this->boatType->getBoatType();
	}

	private function validateId($id) {
		if(!isset($id) || !is_numeric($id) || $id < 0 || $id > 99999999999) {
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