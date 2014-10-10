<?php
require_once('./src/boat/model/BoatTypeRepository.php');

Class BoatView {
	
	private $boatTypeRepository;
	private $errorMessage;
	
	// string dependencies
	private $boatIDLocation = "boat";
	private $memberIDLocation = "member";
	private $boatTypeLocation = "boatType";
	private $boatLengthLocation = "boatLength";
	private $editBoatLocation = "editboat";				// Also exists in memberView.php. If changed here, change there too.
	private $addBoatLocation = "addboat";		// Also exists in memberView.php. If changed here, change there too.
	private $deleteBoatLocation = "deleteboat";	// Also exists in memberView.php. If changed here, change there too.
	private $submitEditBoatLocation = "confirmEditBoat";
	private $submitAddBoatLocation = "confirmAddBoat";
	
	public function __construct() {
		$this->boatTypeRepository = new BoatTypeRepository();
	}

	public function getBoatID() {
		return $_REQUEST[$this->boatIDLocation];
	}
	
	public function getMemberID()
	{
		return $_REQUEST[$this->memberIDLocation];
	}
	
	public function getBoatType()
	{
		return $_POST[$this->boatTypeLocation];
	}
	
	public function getLength()
	{
		return $_POST[$this->boatLengthLocation];
	}
	
	public function didUserPressEdit() {
		return isset($_REQUEST[$this->editBoatLocation]);
	}
	
	public function didUserPressAdd() {
		return isset($_REQUEST[$this->addBoatLocation]);
	}
	
	public function didUserPressDelete()
	{
		return isset($_GET[$this->deleteBoatLocation]);
	}
	
	public function didUserSubmitEditForm()
	{
		return isset($_POST[$this->submitEditBoatLocation]);
	}
	
	public function didUserSubmitAddForm()
	{
		return isset($_POST[$this->submitAddBoatLocation]);
	}

	public function showBoat($boat) {
		$contentString = "
			<h4>Boat Information</h4>
			<ul>
				<li>Boat type: " . $boat->getBoatType() . "</li>
				<li>Boat length: " . $boat->getLength() . "</li>
			</ul>
				";
		
		return $contentString;
	}
	
	public function addBoat()
	{
		$errorMessage = '';
		$boatTypes = $this->boatTypeRepository->getAllBoatTypes();
		
		$boatTypeSelect = "<select name='$this->boatTypeLocation' id='$this->boatTypeLocation'>";
		foreach($boatTypes as $boatType){
			$boatTypeSelect .= "<option value='" . $boatType->getID() . "'>" . utf8_encode($boatType->getBoatType()) . "</option>";
		}
		
		$boatTypeSelect .= "</select>";
		
		if(isset($this->errorMessage))
		{
			$errorMessage = "<p>$this->errorMessage</p>";
		}
		
		$ret = "
			<h1>Add boat</h1>
			<form action='?$this->memberIDLocation=" . $_REQUEST[$this->memberIDLocation] . "' method='post'>
			<fieldset>
				<legend>Add new boat</legend>
				$errorMessage
				<input type='hidden' name='$this->memberIDLocation' value='" . $_REQUEST[$this->memberIDLocation] . "'>
				<input type='hidden' name='$this->addBoatLocation'>
				<div>
					<label for='$this->boatTypeLocation'>Boat type: </label>
					$boatTypeSelect
				</div>
				<div>
					<label for='$this->boatLengthLocation'>Boat length: </label>
					<input type='text' name='$this->boatLengthLocation' id='$this->boatLengthLocation' value=''><br />
				</div>
				<div>
					<input type='submit' name='$this->submitAddBoatLocation' value='Confirm'>
				</div>
			</fieldset>
		";
		
		return $ret;
	}
	
	public function editBoat($boat)
	{
		$errorMessage = '';
		$boatTypes = $this->boatTypeRepository->getAllBoatTypes();
		
		$boatTypeSelect = "<select name='$this->boatTypeLocation' id='$this->boatTypeLocation'>";
		foreach($boatTypes as $boatType){
			$selected = "";
			if($boat->getBoatTypeID() == $boatType->getID()) {
				$selected = " selected";
			}
			$boatTypeSelect .= "<option value='" . $boatType->getID() . "'$selected>" . utf8_encode($boatType->getBoatType()) . "</option>";
		}
		
		$boatTypeSelect .= "</select>";
		
		if(isset($this->errorMessage))
		{
			$errorMessage = "<p>$this->errorMessage</p>";
		}
		
		$ret = "
			<h1>Edit boat - " . $boat->getID() . "</h1>
			<h4>Edit Boat information</h4>
			<form action='?$this->memberIDLocation=" . $_REQUEST[$this->memberIDLocation] . "' method='post'>
			<fieldset>
				<legend>Edit boat</legend>
				$errorMessage
				<input type='hidden' name='$this->memberIDLocation' value='" . $_REQUEST[$this->memberIDLocation] . "'>
				<input type='hidden' name=$this->boatIDLocation value='" . $boat->getID() . "'>
				<input type='hidden' name='$this->editBoatLocation'>
				<div>
					<label for='$this->boatTypeLocation'>Boat type: </label>
					$boatTypeSelect
				</div>
				<div>
					<label for='$this->boatLengthLocation'>Boat length: </label>
					<input type='text' name='$this->boatLengthLocation' id='$this->boatLengthLocation' value='" . $boat->getLength() . "'><br />
				</div>
				<div>
					<input type='submit' name='$this->submitEditBoatLocation' value='Confirm'>
				</div>
			</fieldset>
		";
		
		return $ret;
	}
	
	public function setError($errorMessage)
	{
		$this->errorMessage = $errorMessage;
	}
	
	
	
	
	
	
}