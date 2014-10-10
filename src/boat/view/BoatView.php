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
	private $editLocation = "edit";
	private $addBoatLocation = "addboat";
	private $deleteBoatLocation = "deleteboat";
	private $submitEditBoatLocation = "confirmEditBoat";
	private $submitAddBoatLocation = "confirmAddBoat";
	
	public function __construct() {
		$this->boatTypeRepository = new BoatTypeRepository();
	}

	public function getBoatID() {
		return $_REQUEST[$boatIDLocation];
	}
	
	public function getMemberID()
	{
		return $_REQUEST[$memberIDLocation];
	}
	
	public function getBoatType()
	{
		return $_POST[$boatTypeLocation];
	}
	
	public function getLength()
	{
		return $_POST[$boatLengthLocation];
	}
	
	public function didUserPressEdit() {
		return isset($_REQUEST[$editLocation]);
	}
	
	public function didUserPressAdd() {
		return isset($_REQUEST[$addBoatLocation]);
	}
	
	public function didUserPressDelete()
	{
		return isset($_GET[$deleteBoatLocation]);
	}
	
	public function didUserSubmitEditForm()
	{
		return isset($_POST[$submitEditBoatLocation]);
	}
	
	public function didUserSubmitAddForm()
	{
		return isset($_POST[$submitAddBoatLocation]);
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
		
		$boatTypeSelect = "<select name='$boatTypeLocation' id='$boatTypeLocation'>";
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
			<form action='?$memberIDLocation=" . $_REQUEST[$memberIDLocation] . "' method='post'>
			<fieldset>
				<legend>Add new boat</legend>
				$errorMessage
				<input type='hidden' name='$memberIDLocation' value='" . $_REQUEST[$memberIDLocation] . "'>
				<input type='hidden' name='$addBoatLocation'>
				<div>
					<label for='$boatTypeLocation'>Boat type: </label>
					$boatTypeSelect
				</div>
				<div>
					<label for='$boatLengthLocation'>Boat length: </label>
					<input type='text' name='$boatLengthLocation' id='$boatLengthLocation' value=''><br />
				</div>
				<div>
					<input type='submit' name='$submitAddBoatLocation' value='Confirm'>
				</div>
			</fieldset>
		";
		
		return $ret;
	}
	
	public function editBoat($boat)
	{
		$errorMessage = '';
		$boatTypes = $this->boatTypeRepository->getAllBoatTypes();
		
		$boatTypeSelect = "<select name='$boatTypeLocation' id='$boatTypeLocation'>";
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
			<form action='?$memberIDLocation=" . $_REQUEST[$memberIDLocation] . "' method='post'>
			<fieldset>
				<legend>Edit boat</legend>
				$errorMessage
				<input type='hidden' name='$memberIDLocation' value='" . $_REQUEST[$memberIDLocation] . "'>
				<input type='hidden' name=$boatIDLocation value='" . $boat->getID() . "'>
				<input type='hidden' name='$editLocation'>
				<div>
					<label for='$boatTypeLocation'>Boat type: </label>
					$boatTypeSelect
				</div>
				<div>
					<label for='$boatLengthLocation'>Boat length: </label>
					<input type='text' name='$boatLengthLocation' id='$boatLengthLocation' value='" . $boat->getLength() . "'><br />
				</div>
				<div>
					<input type='submit' name='$submitEditBoatLocation' value='Confirm'>
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