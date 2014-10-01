<?php

require_once('./model/MemberRepository.php');
require_once('./model/BoatRepository.php');
require_once('./view/listView.php');

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
		// Visar den detaljerade listan.
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