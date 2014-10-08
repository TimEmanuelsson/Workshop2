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
		$memberID = $this->memberView->getMemberID();
		$member = $this->memberRepository->getMemberAndBoats($memberID);
		
		if($operationSuccess) {
			$this->memberView->addMessage("Operation was successful.");
		}
		
		if($this->memberView->didUserPressEdit())
		{
			if($this->memberView->didUserSubmitForm())
			{
				try
				{
					$this->memberView->validateUserInput($member);
					// SPARA ANVÄNDAREN.
					return "pop";
				}
				catch(Exception $e)
				{
					
				}
			 	return $this->memberView->editMember($member);
			}
			else
			{
				return $this->memberView->editMember($member);
			}
		}
		
		return $this->memberView->showMember($member);
	}
}