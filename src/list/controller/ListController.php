<?php

require_once('./src/member/model/MemberRepository.php');
require_once('./src/list/view/ListView.php');

class ListController
{
	private $listView;
	private $memberRepository;
	
	public function __construct()
	{
		$this->memberRepository = new MemberRepository();
		$this->listView = new ListView($this->memberRepository);
	}
	
	// Visar en vald lista.
	public function listControl($operationSuccess = FALSE, $fatalError = FALSE)
	{
		// Sätter ett rättmeddelande ifall en handling lyckats.
		if($operationSuccess)
		{
			$this->listView->setSuccessMessage();
		}
		
		if($fatalError)
		{
			$this->listView->setErrorMessage();
		}
			
		// Visar den detaljerade listan. Annars visar den kompakta listan.
		if($this->listView->didUserPressDetailedList() == TRUE)
		{
			return $this->listView->showDetailedList();
		}
		else
		{
			return $this->listView->showCompactList();
		}
	}
}

?>