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
		
		if($this->boatView->didUserSubmitAddForm())
		{
			try
			{
				$newBoat = new Boat(0, $this->boatView->getBoatType(), $this->boatView->getMemberID(), $this->boatView->getLength());
				$boat = $this->boatRepository->add($newBoat);
				return true;
			}
			catch(Exception $e)
			{
				$this->boatView->setError($e->getMessage());
				return $this->boatView->addBoat();
			}
		 	
		}
		
		if($this->boatView->didUserPressAdd()) {
			return $this->boatView->addBoat();
		}
		
		if($this->boatView->didUserPressDelete())
		{
			try
			{
				$this->boatRepository->delete($this->boatView->getBoatID());
				return true;
			}
			catch(Exception $e)
			{
				return false;
			}
		}
		
		$boatID = $this->boatView->getBoatID();
		$boat = $this->boatRepository->getBoatByID($boatID);
		
		if($this->boatView->didUserPressEdit())
		{
			if($this->boatView->didUserSubmitEditForm())
			{
				try
				{
					$newBoat = new Boat($this->boatView->getBoatID(), $this->boatView->getBoatType(), $this->boatView->getMemberID(), $this->boatView->getLength());
					$this->boatRepository->update($newBoat);
					return true;
				}
				catch(Exception $e)
				{
					$this->boatView->setError($e->getMessage());
					return $this->boatView->editBoat($boat);
				}
			}
			return $this->boatView->editBoat($boat);
		}
		
		return $this->boatView->showBoat($boat);
	}
}