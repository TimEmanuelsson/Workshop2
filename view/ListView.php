<?php

Class ListView {
	private $memberRepository;
	private $boatRepository;
	
	public function __construct(MemberRepository $memberRepository, BoatRepository $boatRepository){
		$this->memberRepository = $memberRepository;
		$this->boatRepository = $boatRepository;
	}
	
	public function didUserPressDetailedList(){
		if(isset($_POST['detailedButton']) && $_POST['detailedButton'] == TRUE){
			return TRUE;
		}
		
		return FALSE;
	}
	
	public function getList(){
		return $this->memberRepository->getAllMembersAndBoats();
	}
	
	public function showCompactList(){
		$allMembersAndBoats = $this->getList();
		$contentString = "";
		
		foreach ($allMembersAndBoats as $memberAndBoats) {
			$contentString .="
			<li><a href=''>" . utf8_encode($memberAndBoats->getFirstName()) . " " . utf8_encode($memberAndBoats->getLastName()) . "</a> Medlemsnummer: " . $memberAndBoats->getID() . "</li>
			";
		}
		
		$ret = "
				<h1>Compact List</h1>
				<ul>$contentString</ul>
		
		";
		
		return $ret;
	}
	
	public function showDetailedList(){
		
	}
}
