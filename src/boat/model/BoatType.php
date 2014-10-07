<?php

class BoatType {
	private $id;
	private $boatType;
	
	public function __construct($id, $boatType) {
		$this->id = $id;
		$this->boatType = $boatType;
	}
	
	public function getID() {
		return $this->id;
	}
	
	public function getBoatType() {
		return $this->boatType;
	}
}

?>