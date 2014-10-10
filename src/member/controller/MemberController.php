<?php

require_once ('./src/member/view/MemberView.php');
require_once('./src/boat/model/BoatRepository.php');
require_once('./src/member/model/MemberRepository.php');

Class MemberController
{

	private $memberView;
	private $memberRepository;
	private $boatRepository;

	public function __construct()
	{
		$this->memberRepository = new MemberRepository();
		$this->boatRepository = new BoatRepository();
		$this->memberView = new MemberView($this->memberRepository, $this->boatRepository);
	}
	
	public function showMember($operationSuccess = FALSE)
	{
		// Sätter ett rättmeddelande ifall en handling lyckats.
		if($operationSuccess)
		{
			$this->memberView->setSuccessMessage();
		}
		
		// Har användaren klickat på submit i "Add"-formuläret...
		if($this->memberView->didUserSubmitAddForm())
		{
			try
			{
				// Skapar ett nytt medlemsobjekt med användarinput & lägger till det i databasen.
				$newMember = new Member(0, $this->memberView->getFirstName(), $this->memberView->getLastName(), $this->memberView->getIdentityNumber());
				$member = $this->memberRepository->add($newMember);
				
				// Sätter rättmeddelande & visar den nya medlemmen.
				$this->memberView->setSuccessMessage();
				return $this->memberView->showMember($member);
			}
			catch(Exception $e)
			{
				// Visar felmeddelande och "Add"-sidan.
				$this->memberView->addMessage($e->getMessage());
				return $this->memberView->addMember();
			}
		 	
		}
		
		// Kontrollerar om användaren klickat på "Add"-länken.
		if($this->memberView->didUserPressAdd())
		{
			return $this->memberView->addMember();
		}
		
		// Har användaren klickat på "Delete"-länken...
		if($this->memberView->didUserPressDelete())
		{
			try
			{
				//... tar bort vald medlem ur databasen.
				$this->memberRepository->delete($this->memberView->getMemberID());
				return TRUE;
			}
			catch(Exception $e)
			{
				return FALSE;
			}
		}
		
		// Hämtar det aktuella medlemsobjektet.
		$memberID = $this->memberView->getMemberID();
		$member = $this->memberRepository->getMemberAndBoats($memberID);
		
		// Har användaren klickat på submit i "Edit"-formuläret...
		if($this->memberView->didUserSubmitEditForm())
		{
			try
			{
				// Skapar ett nytt medlemsobjekt med användarinput & uppdaterar befintlig medlem i databasen.
				$newMember = new Member($this->memberView->getMemberID(), $this->memberView->getFirstName(), $this->memberView->getLastName(), $this->memberView->getIdentityNumber());
				$this->memberRepository->update($newMember);
				
				// Sätter rättmeddelande & visar den uppdaterade medlemmen.
				$this->memberView->setSuccessMessage();
				$member = $this->memberRepository->getMemberAndBoats($newMember->getID());
				return $this->memberView->showMember($member);
			}
			catch(Exception $e)
			{
				// Visar felmeddelande & "Edit"-sidan.
				$this->memberView->addMessage($e->getMessage());
				return $this->memberView->editMember($member);
			}
		 	
		}
		
		// Kontrollerar om användaren klickat på "Edit"-länken.
		if($this->memberView->didUserPressEdit())
		{
			return $this->memberView->editMember($member);
		}
		
		// Har inga knappar tryckts på visas den valda medlemmen per default.
		return $this->memberView->showMember($member);
	}
}