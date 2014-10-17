<?php

require_once ('./src/boat/view/BoatView.php');
require_once('./src/boat/model/BoatRepository.php');

Class BoatController
{

	private $boatView;
	private $boatRepository;

	public function __construct()
	{
		$this->boatRepository = new boatRepository();
		$this->boatView = new boatView();
	}

	public function boatControl()
	{
		// Har användaren klickat på submit i "Add"-formuläret...
		if($this->boatView->didUserSubmitAddForm())
		{
			try
			{
				// Skapar ett nytt båtsobjekt med användarinput & lägger till det i databasen.
				$newBoat = new Boat(0, $this->boatView->getBoatType(), $this->boatView->getMemberID(), $this->boatView->getLength());
				$boat = $this->boatRepository->add($newBoat);
				return TRUE;
			}
			catch(Exception $e)
			{
				// Visar felmeddelande och "Add"-sidan.
				$this->boatView->setError($e->getMessage());
				return $this->boatView->addBoat();
			}	
		}
		
		// Kontrollerar om användaren klickat på "Add"-länken.
		if($this->boatView->didUserPressAdd())
		{
			return $this->boatView->addBoat();
		}
		
		// Har användaren klickat på "Delete"-länken...
		if($this->boatView->didUserPressDelete())
		{
			try
			{
				//... tar bort vald båt ur databasen.
				$this->boatRepository->delete($this->boatView->getBoatID());
				return TRUE;
			}
			catch(Exception $e)
			{
				return FALSE;
			}
		}
		
		// Hämtar det aktuella båtsobjektet.
		$boatID = $this->boatView->getBoatID();
		$boat = $this->boatRepository->getBoatByID($boatID);
		
		// Kontrollerar om användaren klickat på "Edit"-länken.
		if($this->boatView->didUserPressEdit())
		{
			// Har användaren klickat på submit i "Add"-formuläret...
			if($this->boatView->didUserSubmitEditForm())
			{
				try
				{
					// Skapar ett nytt båtobjekt med användarinput & uppdaterar befintlig båt i databasen.
					$newBoat = new Boat($this->boatView->getBoatID(), $this->boatView->getBoatType(), $this->boatView->getMemberID(), $this->boatView->getLength());
					$this->boatRepository->update($newBoat);
					return TRUE;
				}
				catch(Exception $e)
				{
					// Visar felmeddelande & "Edit"-sidan.
					$this->boatView->setError($e->getMessage());
					return $this->boatView->editBoat($boat);
				}
			}
			
			// Visar "Edit"-sidan om användaren inte skickat in "Edit"-formuläret.
			return $this->boatView->editBoat($boat);
		}
		
		// Visar "Båt"-sidan om användaren inte klickat på "Edit"-länken.
		return $this->boatView->showBoat($boat);
	}
}