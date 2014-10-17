<?php

class BoatType
{
	private $id;
	private $boatType;
	
	public function __construct($id, $boatType)
	{
		$this->id = $id;
		$this->boatType = $boatType;
	}
	
	// Hämtar båttypID:t.
	public function getID()
	{
		return $this->id;
	}
	
	// Hämtar båttypen.
	public function getBoatType()
	{
		return $this->boatType;
	}
}

?>