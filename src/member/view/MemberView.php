<?php

Class MemberView {

	private $memberRepository;
	private $boatRepository;

	public function __construct(MemberRepository $memberRepository, BoatRepository $boatRepository)
	{
		$this->memberRepository = $memberRepository;
		$this->boatRepository = $boatRepository;
	}
	
	public function getMemberID()
	{
		return $_GET['member'];
	}
	
	public function showMember($member)
	{
		$contentString = "
			<h4>Member Information</h4>
			<ul>
				<li>MemberID: " . $member->getID() . "</li>
				<li>Personal Identity Number: " . $member->getIdentityNumber() . "</li>
			</ul>
			<h4>" . utf8_encode($member->getFirstName()) . "'s boats</h4>
			<ul>
				";
		
		if(count($member->getBoats()) <= 0 || $member->getBoats() == NULL)
		{
			$contentString .= "<li>" . utf8_encode($member->getFirstName()) . " does not have any registered boats</li>";
		}
		else
		{
			foreach ($member->getBoats() as $boat)
			{
				$contentString .= "<li>Boat type: " . utf8_encode($boat->getBoatType()) . ". Boat length: " . $boat->getLength() . "</li>";
			}
		}
		
		$contentString .= "</ul>";
		
		$ret = "
				<h1>Specific Member - " . utf8_encode($member->getFirstName()) . " " . utf8_encode($member->getLastName()) . "</h1>
				<a href='?CompactList'>Show Compact List</a>
				<a href='?DetailedList'>Show Detailed List</a>
				" . $contentString;
		
		return $ret;
	}
}