<?php

require_once ('./src/member/view/MemberView.php');
require_once('./src/boat/model/BoatRepository.php');
require_once('./src/member/model/MemberRepository.php');

Class MemberController {

	private $memberView;
	private $memberRepository;
	private $boatRepository;

	public function __construct()
	{
		$this->memberRepository = new MemberRepository();
		$this->boatRepository = new BoatRepository();
		$this->memberView = new MemberView($this->memberRepository, $this->boatRepository);
	}
	
	public function showMember($operationSuccess = false)
	{
		if($operationSuccess) {
			$this->memberView->setSuccessMessage();
		}
		
		if($this->memberView->didUserSubmitAddForm())
		{
			try
			{
				$newMember = new Member(0, $this->memberView->getFirstName(), $this->memberView->getLastName(), $this->memberView->getIdentityNumber());
				$member = $this->memberRepository->add($newMember);
				$this->memberView->setSuccessMessage();
				return $this->memberView->showMember($member);
			}
			catch(Exception $e)
			{
				$this->memberView->addMessage($e->getMessage());
				return $this->memberView->addMember();
			}
		 	
		}
		
		if($this->memberView->didUserPressAdd()) {
			return $this->memberView->addMember();
		}
		
		if($this->memberView->didUserPressDelete())
		{
			try
			{
				$this->memberRepository->delete($this->memberView->getMemberID());
				return true;
			}
			catch(Exception $e)
			{
				return false;
			}
		}
		
		$memberID = $this->memberView->getMemberID();
		$member = $this->memberRepository->getMemberAndBoats($memberID);
		
		if($this->memberView->didUserSubmitEditForm())
		{
			try
			{
				$newMember = new Member($this->memberView->getMemberID(), $this->memberView->getFirstName(), $this->memberView->getLastName(), $this->memberView->getIdentityNumber());
				$this->memberRepository->update($newMember);
				$this->memberView->setSuccessMessage();
				$member = $this->memberRepository->getMemberAndBoats($newMember->getID());
				return $this->memberView->showMember($member);
			}
			catch(Exception $e)
			{
				$this->memberView->addMessage($e->getMessage());
				return $this->memberView->editMember($member);
			}
		 	
		}
		
		if($this->memberView->didUserPressEdit())
		{
			return $this->memberView->editMember($member);
		}
		
		return $this->memberView->showMember($member);
	}
}