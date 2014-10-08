<?php
require_once('./src/boat/model/BoatTypeRepository.php');

Class BoatView {
	
	private $boatTypeRepository;
	
	public function __construct() {
		$this->boatTypeRepository = new BoatTypeRepository();
	}

	public function getBoatID() {
		return $_GET['boat'];
	}
	
	public function didUserPressEdit() {
		return isset($_GET['edit']);
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
	
	public function editBoat($boat) {
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
		$ret = "
			
			<form METHOD='post'>
				<fieldset>
					<legend>Edit member information</legend>";
		$ret = "
			<h1>Edit boat - " . $boat->getID() . "</h1>
			<h4>Edit Boat information</h4>
			<form action='?boat=" . $this->getBoatID() . "&edit' method='post'>
			<fieldset>
				<legend>Edit boat</legend>
				<div>
					<label for='boatType'>Boat type: </label>
					$boatTypeSelect
				</div>
				<div>
					<label for='boatLength'>Boat length: </label>
					<input type='text' name='boatLength' id='boatLength' value='" . $boat->getLength() . "'><br />
				</div>
				<div>
					<input type='submit' value='Confirm'>
				</div>
			</fieldset>
		";
		
		return $ret;
	}
}