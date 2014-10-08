<?php

require_once('./src/member/model/MemberRepository.php');
require_once('./src/boat/model/BoatRepository.php');
require_once('./src/list/view/ListView.php');

class ListController
{
	private $listView;
	private $memberRepository;
	private $boatRepository;
	
	public function __construct()
	{
		$this->memberRepository = new MemberRepository();
		$this->boatRepository = new BoatRepository();
		$this->listView = new ListView($this->memberRepository, $this->boatRepository);
	}
	
	// Visar en vald lista
	public function showList()
	{	
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