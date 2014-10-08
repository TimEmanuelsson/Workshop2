<?php
require_once('./src/boat/model/BoatTypeRepository.php');

Class BoatView {
	
	private $boatTypeRepository;
	private $errorMessage;
	
	public function __construct() {
		$this->boatTypeRepository = new BoatTypeRepository();
	}

	public function getBoatID() {
		return $_REQUEST['boat'];
	}
	
	public function getMemberID()
	{
		return $_REQUEST['member'];
	}
	
	public function getBoatType()
	{
		if(isset($_POST['boatType']) && $_POST['boatType'] != '')
		{
			return $_POST['boatType'];
		}
	}
	
	public function getLength()
	{
		if(isset($_POST['boatLength']) && $_POST['boatLength'] != '')
		{
			return $_POST['boatLength'];
		}
	}
	
	public function didUserPressEdit() {
		return isset($_REQUEST['edit']);
	}
	
	public function didUserPressSubmit()
	{
		return isset($_POST['submitButton']);
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
	
	public function editBoat($boat)
	{
		$errorMessage = '';
		$boatTypes = $this->boatTypeRepository->getAllBoatTypes();
		
		$boatTypeSelect = "<select name='boatType' id='boatType'>";
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
			<form action='?member=" . $_REQUEST['member'] . "' method='post'>
			<fieldset>
				<legend>Edit boat</legend>
				$errorMessage
				<input type='hidden' name='member' value='" . $_REQUEST['member'] . "'>
				<input type='hidden' name='boat' value='" . $boat->getID() . "'>
				<input type='hidden' name='edit'>
				<div>
					<label for='boatType'>Boat type: </label>
					$boatTypeSelect
				</div>
				<div>
					<label for='boatLength'>Boat length: </label>
					<input type='text' name='boatLength' id='boatLength' value='" . $boat->getLength() . "'><br />
				</div>
				<div>
					<input type='submit' name='submitButton' value='Confirm'>
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