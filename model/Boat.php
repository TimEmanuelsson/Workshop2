<?php

class Boat {
	private $id;
	private $boatTypeID;
	private $memberID;
	private $length;
	
	public function __construct($id, $boatTypeID, $memberID, $length) {
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




}

?>