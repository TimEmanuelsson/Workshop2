<?php

Class ListView {
	private $memberRepository;
	private $boatRepository;
	
	public function __construct(MemberRepository $memberRepository, BoatRepository $boatRepository){
		$this->memberRepository = $memberRepository;
		$this->boatRepository = $boatRepository;
	}
	
	public function didUserPressDetailedList(){
		if(isset($_GET['DetailedList']) == TRUE){
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
			<li><a href='?member=" . $memberAndBoats->getID() . "'>" . utf8_encode($memberAndBoats->getFirstName()) . "
			" . utf8_encode($memberAndBoats->getLastName()) . "</a> Medlemsnummer: " . $memberAndBoats->getID() . "</li>
			";
		}
		
		$ret = "
				<h1>Compact List</h1>
				<a href='?DetailedList'>Show Detailed List</a>
				<ul>$contentString</ul>
				
		
		";
		
		return $ret;
	}
	
	public function showDetailedList(){
		$members = $this->getList();
		$contentString = "";
		
		foreach ($members as $member) {
			$contentString .="
			<li>Medlemsnummer: " . $member->getID() . "<br><a href='?member=" . $member->getID() . "'>" . utf8_encode($member->getFirstName()) . "
			" . utf8_encode($member->getLastName()) . "</a><br> Personal identity number: " . $member->getIdentityNumber() . " </li>
			";
			if(count($member->getBoats()) > 0) {
				$contentString .= '<ul>';

				foreach ($member->getBoats() as $boat) {
					$contentString .= "<li>Boat type: " . utf8_encode($boat->getBoatType()) . ". Boat length: " . $boat->getLength() . "
					<a href='?boat=" . $boat->getID() . "'>Edit</a></li>";
				}
				$contentString .= '</ul><br>';
			} else {
				$contentString .= '<li>Member do not have any boat(s).</li><br>';
			}
		}

		$ret = "
				<h1>Detailed List</h1>
				<a href='?CompactList'>Show Compact List</a>
				<ul>$contentString</ul>
		";

		return $ret;
	}
}
