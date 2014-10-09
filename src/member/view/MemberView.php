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
		return $_REQUEST['member'];
	}
	
	public function getFirstName() {
		return $_POST['memberFirstName'];
	}
	
	public function getLastName() {
		return $_POST['memberLastName'];
	}
	
	public function getIdentityNumber() {
		return $_POST['memberIdentityNumber'];
	}
	
	public function didUserPressEdit()
	{
		return isset($_REQUEST['edit']);
	}
	
	public function didUserPressAdd() {
		return isset($_REQUEST['addmember']);
	}
	
	public function didUserSubmitEditForm()
	{
		return isset($_POST['confirmEdit']);
	}
	
	public function didUserSubmitAddForm() {
		return isset($_POST['confirmAdd']);
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
				$contentString .= "<li>Boat type: " . utf8_encode($boat->getBoatType()) . ". Boat length: " . $boat->getLength() . " <a href='?member=" . $member->getID() . "&boat=" . $boat->getID() . "&edit'>Edit</a></li>";
			}
		}
		
		$contentString .= "</ul>";
		
		$ret = "
				<h1>Specific Member - " . utf8_encode($member->getFirstName()) . " " . utf8_encode($member->getLastName()) . "</h1>
				" . $this->showMessages() . "
				<a href='?CompactList'>Show Compact List</a>
				<a href='?DetailedList'>Show Detailed List</a>
				" . $contentString;
		
		return $ret;
	}
	
	public function editMember($member)
	{
		$firstName = utf8_encode($member->getFirstName());
		$lastName = utf8_encode($member->getLastName());
		$identityNumber = $member->getIdentityNumber();
		
		if(isset($_POST['memberFirstName']) && $_POST['memberFirstName'] != '')
		{
			$firstName = $_POST['memberFirstName'];
		}
		
		if(isset($_POST['memberLastName']) && $_POST['memberLastName'] != '')
		{
			$lastName = $_POST['memberLastName'];
		}
		
		if(isset($_POST['memberIdentityNumber']) && $_POST['memberIdentityNumber'] != '')
		{
			$identityNumber = $_POST['memberIdentityNumber'];
		}
			
		$ret = "
			<h1>Edit member - " . utf8_encode($member->getFirstName()) . " " . utf8_encode($member->getLastName()) . "</h1>
			<form METHOD='post' action='?member=" . $_REQUEST['member'] . "'>
				<fieldset>
					<legend>Edit member information</legend>";
					
		// Loopar igenom messages-arrayen och skriver ut meddelanden.
		$ret .= $this->showMessages();
		
		$ret .= "
					<input type='hidden' name='member' value='" . $_REQUEST['member'] . "'>
					<input type='hidden' name='edit'>
					<div>
						<label for='memberFirstName'>First name: </label>
						<input type='text' name='memberFirstName' id='memberFirstName' value='" . $firstName . "'/>
					</div>
					<div>
						<label for='memberLastName'>Last name: </label>
						<input type='text' name='memberLastName' id='memberLastName' value='" . $lastName . "'/>
					</div>
					<div>
						<label for='memberIdentityNumber'>Personal identity number: </label>
						<input type='text' name='memberIdentityNumber' id='memberIdentityNumber' value='" . $identityNumber . "'/>
					</div>
					<div>
						<input type='submit' id='confirmEdit' name='confirmEdit' value='Confirm'/>
					</div>
				</fieldset>
			</form>";
			
		return $ret;
	}
	
	public function addMember()
	{
		$firstName = "";
		$lastName = "";
		$identityNumber = "";
		
		if(isset($_POST['memberFirstName']) && $_POST['memberFirstName'] != '')
		{
			$firstName = $_POST['memberFirstName'];
		}
		
		if(isset($_POST['memberLastName']) && $_POST['memberLastName'] != '')
		{
			$lastName = $_POST['memberLastName'];
		}
		
		if(isset($_POST['memberIdentityNumber']) && $_POST['memberIdentityNumber'] != '')
		{
			$identityNumber = $_POST['memberIdentityNumber'];
		}
			
		$ret = "
			<h1>Add member</h1>
			<form METHOD='post' action=''>
				<fieldset>
					<legend>Add new member</legend>";
					
		// Loopar igenom messages-arrayen och skriver ut meddelanden.
		$ret .= $this->showMessages();
		
		$ret .= "
					<input type='hidden' name='addmember'>
					<div>
						<label for='memberFirstName'>First name: </label>
						<input type='text' name='memberFirstName' id='memberFirstName' value='" . $firstName . "'/>
					</div>
					<div>
						<label for='memberLastName'>Last name: </label>
						<input type='text' name='memberLastName' id='memberLastName' value='" . $lastName . "'/>
					</div>
					<div>
						<label for='memberIdentityNumber'>Personal identity number: </label>
						<input type='text' name='memberIdentityNumber' id='memberIdentityNumber' value='" . $identityNumber . "'/>
					</div>
					<div>
						<input type='submit' id='confirmAdd' name='confirmAdd' value='Confirm'/>
					</div>
				</fieldset>
			</form>";
			
		return $ret;
	}

	public function addMessage($message) {
		array_push($this->messages, $message);
	}
	
	public function setSuccessMessage() {
		$this->addMessage("Operation was successful.");
	}
	
	private function showMessages() {
		$ret = "";
		// Loopar igenom messages-arrayen och skriver ut meddelanden.
		foreach ($this->messages as $message)
		{
			$ret .= '<p>' . $message . '</p>';
		}
		
		return $ret;
	}
}