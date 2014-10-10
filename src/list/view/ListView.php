<?php

Class ListView
{
	private $memberRepository;
	private $boatRepository;
	private $messages;
	
	public function __construct(MemberRepository $memberRepository, BoatRepository $boatRepository)
	{
		$this->memberRepository = $memberRepository;
		$this->boatRepository = $boatRepository;
		$this->messages = array();
	}
	
	// Kontrollerar ifall användaren klickat på "Show Detailed List"-knappen.
	public function didUserPressDetailedList()
	{
		if(isset($_GET['DetailedList']) == TRUE)
		{
			return TRUE;
		}
		
		return FALSE;
	}
	
	// Hämtar ut alla medlemmar och båtar.
	public function getList()
	{
		return $this->memberRepository->getAllMembersAndBoats();
	}
	
	// Visar den kompakta listan. Returnerar HTML-sträng.
	public function showCompactList()
	{
		$allMembersAndBoats = $this->getList();
		$contentString = "";
		
		foreach($allMembersAndBoats as $memberAndBoats)
		{
			$contentString .="
			<li>Member number: " . $memberAndBoats->getID() . "<br><a href='?member=" . $memberAndBoats->getID() . "'>" . utf8_encode($memberAndBoats->getFirstName()) . "
			" . utf8_encode($memberAndBoats->getLastName()) . "</a><br>Boat(s): " . count($memberAndBoats->getBoats()) . "</li><br>
			";
		}
		
		$ret = "
				<h1>Compact List</h1>
				" . $this->showMessages() . "
				<a href='?DetailedList'>Show Detailed List</a><br />
				<a href='?addmember'>Add member</a>
				<ul>$contentString</ul>
		";
		
		return $ret;
	}
	
	// Visar den detaljerade listan. Returnerar HTML-sträng.
	public function showDetailedList()
	{
		$members = $this->getList();
		$contentString = "";
		
		foreach($members as $member)
		{
			$contentString .="
			<li>Member number: " . $member->getID() . "<br><a href='?member=" . $member->getID() . "'>" . utf8_encode($member->getFirstName()) . "
			" . utf8_encode($member->getLastName()) . "</a><br> Personal identity number: " . $member->getIdentityNumber() . " </li>
			";
			if(count($member->getBoats()) > 0)
			{
				$contentString .= '<ul>';

				foreach($member->getBoats() as $boat)
				{
					$contentString .= "<li>Boat type: " . utf8_encode($boat->getBoatType()) . ". Boat length: " . $boat->getLength() . "</li>";
				}
				
				$contentString .= '</ul><br>';
			}
			else
			{
				$contentString .= '<li>Member do not have any boat(s).</li><br>';
			}
		}

		$ret = "
				<h1>Detailed List</h1>
				" . $this->showMessages() . "
				<a href='?CompactList'>Show Compact List</a><br />
				<a href='?addmember'>Add member</a>
				<ul>$contentString</ul>
		";

		return $ret;
	}
	
	// Lägger till ett meddelande i $message-arrayen.
	public function addMessage($message)
	{
		array_push($this->messages, $message);
	}
	
	// Läger till rättmeddelande i $message-arrayen.
	public function setSuccessMessage()
	{
		$this->addMessage("Operation was successful.");
	}
	
	// Lägger till felmeddelande i $message-arrayen.
	public function setErrorMessage()
	{
		$this->addMessage("An unknown error has occured!");
	}
	
	// Visar meddelanden.
	private function showMessages()
	{
		$ret = "";
		// Loopar igenom messages-arrayen och skriver ut meddelanden.
		foreach($this->messages as $message)
		{
			$ret .= '<p>' . $message . '</p>';
		}
		
		return $ret;
	}
}
