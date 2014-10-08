<?php

require_once ('./src/boat/view/BoatView.php');
require_once('./src/boat/model/BoatRepository.php');

Class BoatController {

	private $boatView;
	private $boatRepository;

	public function __construct() {
		$this->boatRepository = new boatRepository();
		$this->boatView = new boatView();
	}

	public function showBoat() {
		$boatID = $this->boatView->getBoatID();
		$boat = $this->boatRepository->getBoatByID($boatID);
		
		if($this->boatView->didUserPressEdit()) {
			return $this->boatView->editBoat($boat);
		}
		
		return $this->boatView->showBoat($boat);
	}
}