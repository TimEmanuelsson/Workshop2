<?php

Class MemberView
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
	
	// Hämtar medlemsID:t.
	public function getMemberID()
	{
		return $_REQUEST['member'];
	}
	
	// Hämtar medlemmens förnamn.
	public function getFirstName()
	{
		return $_POST['memberFirstName'];
	}
	
	// Hämtar medlemmens förnamn.
	public function getLastName()
	{
		return $_POST['memberLastName'];
	}
	
	// Hämtar medlemmens personnummer.
	public function getIdentityNumber()
	{
		return $_POST['memberIdentityNumber'];
	}
	
	// Kontrollerar om användaren klickat på "Edit"-länken.
	public function didUserPressEdit()
	{
		return isset($_REQUEST['edit']);
	}
	
	// Kontrollerar om användaren klickat på "Add"-länken.
	public function didUserPressAdd()
	{
		return isset($_REQUEST['addmember']);
	}
	
	// Kontrollerar om användaren klickat på "Delete"-länken.
	public function didUserPressDelete()
	{
		return isset($_GET['deletemember']);
	}
	
	// Kontrollerar om användaren skickat in "Edit"-formuläret.
	public function didUserSubmitEditForm()
	{
		return isset($_POST['confirmEditMember']);
	}
	
	// Kontrollerar om användaren skickat in "Add"-formuläret.
	public function didUserSubmitAddForm()
	{
		return isset($_POST['confirmAddMember']);
	}
	
	// Visar specifik medlem.
	public function showMember($member)
	{
		// HTML-sträng för medlemssidan.
		$contentString = "
			<h4>Member Information <a href='?member=" . $member->getID() . "&edit'>Edit</a> <a href='?member=" . $member->getID() . "&deletemember'>Delete</a></h4>
			<ul>
				<li>MemberID: " . $member->getID() . "</li>
				<li>Personal Identity Number: " . $member->getIdentityNumber() . "</li>
			</ul>
			<h4>" . utf8_encode($member->getFirstName()) . "'s boats <a href='?member=" . $member->getID() . "&addboat'>Add boat</a></h4>
			<ul>
				";
		
		// Finns det inga båtar registrerade på medlemmen visas ett särskilt meddelande.
		if(count($member->getBoats()) <= 0 || $member->getBoats() == NULL)
		{
			$contentString .= "<li>" . utf8_encode($member->getFirstName()) . " does not have any registered boats</li>";
		}
		else // Annars läggs alla medlemmens båtar till i HTML-strängen.
		{
			foreach ($member->getBoats() as $boat)
			{
				$contentString .= "<li>Boat type: " . utf8_encode($boat->getBoatType()) . ". Boat length: " . $boat->getLength() . " 
				<a href='?member=" . $member->getID() . "&boat=" . $boat->getID() . "&edit'>Edit</a> <a href='?member=" . $member->getID() . "&boat=" . $boat->getID() . "&deleteboat'>Delete</a></li>";
			}
		}
		
		// Stänger punktlistan i HTML-strängen.
		$contentString .= "</ul>";
		
		// Strängen som skall returneras till HTMLView-klassen.
		$ret = "
				<h1>Specific Member - " . utf8_encode($member->getFirstName()) . " " . utf8_encode($member->getLastName()) . "</h1>
				" . $this->showMessages() . "
				<a href='?CompactList'>Show Compact List</a>
				<a href='?DetailedList'>Show Detailed List</a>
				" . $contentString;
		
		return $ret;
	}
	
	// Visar redigeringsformuläret för en specifik medlem.
	public function editMember($member)
	{
		$firstName = utf8_encode($member->getFirstName());
		$lastName = utf8_encode($member->getLastName());
		$identityNumber = $member->getIdentityNumber();
		
		// Har användaren skickat in formuläret tidigare får variablerna inputvärdet, ifall det gått igenom valideringen.
		if($this->didUserSubmitEditForm())
		{
			$firstName = $this->checkPost('memberFirstName');
			$lastName = $this->checkPost('memberLastName');
			$identityNumber = $this->checkPost('memberIdentityNumber');
		}
		
		// HTML-strängen som skall returneras till HTMLView-klassen.	
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
						<input type='submit' id='confirmEdit' name='confirmEditMember' value='Confirm'/>
					</div>
				</fieldset>
			</form>";
			
		return $ret;
	}
	
	// Visar formulär för att lägga till en ny medlem.
	public function addMember()
	{
		$firstName = "";
		$lastName = "";
		$identityNumber = "";
		
		// Kontrollerar ifall formuläret redan skickats in.
		$firstName = $this->checkPost('memberFirstName');
		$lastName = $this->checkPost('memberLastName');
		$identityNumber = $this->checkPost('memberIdentityNumber');
			
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
						<input type='submit' id='confirmAdd' name='confirmAddMember' value='Confirm'/>
					</div>
				</fieldset>
			</form>";
			
		return $ret;
	}
	
	// Returnerar värdet i $_POST[] om input klarat validering.
	private function checkPost($stringName)
	{
		if(isset($_POST[$stringName]) && $_POST[$stringName] != '')
		{
			return $_POST[$stringName];
		}
	}
	
	// Lägger till felmeddelanden i $message-arrayen.
	public function addMessage($message)
	{
		array_push($this->messages, $message);
	}
	
	// Lägger till rättmeddelande i $message-arrayen.
	public function setSuccessMessage()
	{
		$this->addMessage("Operation was successful.");
	}
	
	// Visar meddelanden.
	private function showMessages()
	{
		$ret = "";
		
		// Loopar igenom messages-arrayen och skriver ut meddelanden.
		foreach ($this->messages as $message)
		{
			$ret .= '<p>' . $message . '</p>';
		}
		
		return $ret;
	}
}