<?php
require_once('../model/MemberRepository');
require_once('../model/BoatRepository');
require_once('../view/listView.php');

class listController
{
	private $listView;
	private $memberRepository;
	private $boatRepository;
	
	private function __construct()
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
			$this->listView->showDetailedList();
		}
		else
		{
			$this->listView->showCompactList();
		}
	}
}

?>