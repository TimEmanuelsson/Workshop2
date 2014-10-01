<?php

Class ListView {
	private $memberRepository;
	private $boatRepository;
	
	public function __contruct(MemberRepository $memberRepository, BoatRepository $boatRepository){
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
		return $list = $this->memberRepository->getAllMembersAndBoats();
	}
	
	public function showCompactList(){
		$allMembersAndBoats = $this->getList();
		
		foreach ($allMembersAndBoats as $memberAndBoats) {
			$contentString ="
			<li><a href=''>" . $memberAndBoats[1] + " " + $memberAndBoats[2] . "</a> Medlemmsnummer: $memberAndBoats[0]<li>
			";
		}
		
		$ret = '';
		
		$ret = "
				<h1>Compact List</h1>
				<ul>$contentString</ul>
		
		";
	}
	
	public function showDetailedList(){
		
	}
}
