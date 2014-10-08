<?php

Class MemberView {

	private $memberRepository;
	private $boatRepository;
	private $messages;

	public function __construct(MemberRepository $memberRepository, BoatRepository $boatRepository)
	{
		$this->memberRepository = $memberRepository;
		$this->boatRepository = $boatRepository;
		$this->messages = array();
	}
	
	public function getMemberID()
	{
		return $_GET['member'];
	}
	
	public function didUserPressEdit()
	{
		return isset($_GET['edit']);
	}
	
	public function showMember($member)
	{
		$contentString = "
			<h4>Member Information <a href='?member=" . $member->getID() . "&edit'>Edit</a></h4>
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
				$contentString .= "<li>Boat type: " . utf8_encode($boat->getBoatType()) . ". Boat length: " . $boat->getLength() . " <a href='?boat=" . $boat->getID() . "&edit'>Edit</a></li>";
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
	
	public function editMember($member)
	{
		$ret = "
			<h1>Edit member - " . utf8_encode($member->getFirstName()) . " " . utf8_encode($member->getLastName()) . "</h1>
			<form METHOD='post'>
				<fieldset>
					<legend>Edit member information</legend>";
					
		// Loopar igenom messages-arrayen och skriver ut meddelanden.
		foreach ($this->messages as $message)
		{
			$ret .= '<p>' . $message . '</p>';
		}
		
		$ret .= "
					<div>
						<label for='memberFirstName'>First name: </label>
						<input type='text' name='memberFirstName' id='memberFirstName' value='" . $member->getFirstName() . "'/>
					</div>
					<div>
						<label for='memberLastName'>Last name: </label>
						<input type='text' name='memberLastName' id='memberLastName' value='" . $member->getLastName() . "'/>
					</div>
					<div>
						<label for='memberIdentityNumber'>Personal identity number: </label>
						<input type='text' name='memberIdentityNumber' id='memberIdentityNumber' value='" . $member->getIdentityNumber() . "'/>
					</div>
					<div>
						<input type='submit' id='confirmButton' name='confirmButton' value='Confirm'/>
					</div>
				</fieldset>
			</form>";
			
		return $ret;
	}
}