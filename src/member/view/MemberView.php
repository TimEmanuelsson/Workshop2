<?php

Class MemberView
{

	private $memberRepository;
	private $boatRepository;
	private $messages;
	
	// Istället för strängberoenden.
	private $memberIDLocation = "member";	// Finns även i boatView.php. Om ändringar sker här, ändra där med.
	private $memberFirstNameLocation = "memberFirstName";
	private $memberLastNameLocation = "memberLastName";
	private $memberIdentityNumberLocation = "memberIdentityNumber";
	private $editMemberLocation = "editmember";
	private $addMemberLocation = "addmember";
	private $deleteMemberLocation = "deletemember";
	private $submitEditMemberLocation = "confirmEditMember";
	private $submitAddMemberLocation = "confirmAddMember";
	private $editBoatLocation = "editboat";		// Finns även i boatView.php. Om ändringar sker här, ändra där med.
	private $addBoatLocation = "addboat";		// Finns även i boatView.php. Om ändringar sker här, ändra där med.
	private $deleteBoatLocation = "deleteboat";	// Finns även i boatView.php. Om ändringar sker här, ändra där med.
	

	public function __construct(MemberRepository $memberRepository, BoatRepository $boatRepository)
	{
		$this->memberRepository = $memberRepository;
		$this->boatRepository = $boatRepository;
		$this->messages = array();
	}
	
	// Hämtar medlemsID:t.
	public function getMemberID()
	{
		return $_REQUEST[$this->memberIDLocation];
	}
	
	// Hämtar medlemmens förnamn.
	public function getFirstName()
	{
		return $_POST[$this->memberFirstNameLocation];
	}
	
	// Hämtar medlemmens förnamn.
	public function getLastName()
	{
		return $_POST[$this->memberLastNameLocation];
	}
	
	// Hämtar medlemmens personnummer.
	public function getIdentityNumber()
	{
		return $_POST[$this->memberIdentityNumberLocation];
	}
	
	// Kontrollerar om användaren klickat på "Edit"-länken.
	public function didUserPressEdit()
	{
		return isset($_REQUEST[$this->editMemberLocation]);
	}
	
	// Kontrollerar om användaren klickat på "Add"-länken.
	public function didUserPressAdd()
	{
		return isset($_REQUEST[$this->addMemberLocation]);
	}
	
	// Kontrollerar om användaren klickat på "Delete"-länken.
	public function didUserPressDelete()
	{
		return isset($_GET[$this->deleteMemberLocation]);
	}
	
	// Kontrollerar om användaren skickat in "Edit"-formuläret.
	public function didUserSubmitEditForm()
	{
		return isset($_POST[$this->submitEditMemberLocation]);
	}
	
	// Kontrollerar om användaren skickat in "Add"-formuläret.
	public function didUserSubmitAddForm()
	{
		return isset($_POST[$this->submitAddMemberLocation]);
	}
	
	// Visar specifik medlem.
	public function showMember($member)
	{
		// HTML-sträng för medlemssidan.
		$contentString = "
			<h4>Member Information <a href='?$this->memberIDLocation=" . $member->getID() . "&$this->editMemberLocation'>Edit</a> <a href='?$this->memberIDLocation=" . $member->getID() . "&$this->deleteMemberLocation'>Delete</a></h4>
			<ul>
				<li>MemberID: " . $member->getID() . "</li>
				<li>Personal Identity Number: " . $member->getIdentityNumber() . "</li>
			</ul>
			<h4>" . utf8_encode($member->getFirstName()) . "'s boats <a href='?$this->memberIDLocation=" . $member->getID() . "&$this->addBoatLocation'>Add boat</a></h4>
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
				<a href='?$this->memberIDLocation=" . $member->getID() . "&boat=" . $boat->getID() . "&$this->editBoatLocation'>Edit</a> <a href='?$this->memberIDLocation=" . $member->getID() . "&boat=" . $boat->getID() . "&$this->deleteBoatLocation'>Delete</a></li>";
			}
		}
		
		// Stänger punktlistan i HTML-strängen.
		$contentString .= "</ul>";
		
		// Strängen som skall returneras till HTMLView-klassen.
		$ret = "
				<h1>Specific Member - " . utf8_encode($member->getFirstName()) . " " . utf8_encode($member->getLastName()) . "</h1>
				" . $this->showMessages() . "
				<a href='?compactlist'>Show Compact List</a>
				<a href='?detailedlist'>Show Detailed List</a>
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
			$firstName = $this->checkPost($this->memberFirstNameLocation);
			$lastName = $this->checkPost($this->memberLastNameLocation);
			$identityNumber = $this->checkPost($this->memberIdentityNumberLocation);
		}
		
		// HTML-strängen som skall returneras till HTMLView-klassen.	
		$ret = "
			<h1>Edit member - " . utf8_encode($member->getFirstName()) . " " . utf8_encode($member->getLastName()) . "</h1>
			<form METHOD='post' action='?$this->memberIDLocation=" . $_REQUEST[$this->memberIDLocation] . "'>
				<fieldset>
					<legend>Edit member information</legend>";
					
		// Loopar igenom messages-arrayen och skriver ut meddelanden.
		$ret .= $this->showMessages();
		
		$ret .= "
					<input type='hidden' name='$this->memberIDLocation' value='" . $_REQUEST[$this->memberIDLocation] . "'>
					<input type='hidden' name='$this->editMemberLocation'>
					<div>
						<label for='$this->memberFirstNameLocation'>First name: </label>
						<input type='text' name='$this->memberFirstNameLocation' id='$this->memberFirstNameLocation' value='" . $firstName . "'/>
					</div>
					<div>
						<label for='$this->memberLastNameLocation'>Last name: </label>
						<input type='text' name='$this->memberLastNameLocation' id='$this->memberLastNameLocation' value='" . $lastName . "'/>
					</div>
					<div>
						<label for='$this->memberIdentityNumberLocation'>Personal identity number: </label>
						<input type='text' name='$this->memberIdentityNumberLocation' id='$this->memberIdentityNumberLocation' value='" . $identityNumber . "'/>
					</div>
					<div>
						<input type='submit' id='confirmEdit' name='$this->submitEditMemberLocation' value='Confirm'/>
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
		$firstName = $this->checkPost($this->memberFirstNameLocation);
		$lastName = $this->checkPost($this->memberLastNameLocation);
		$identityNumber = $this->checkPost($this->memberIdentityNumberLocation);
			
		$ret = "
			<h1>Add member</h1>
			<form METHOD='post' action=''>
				<fieldset>
					<legend>Add new member</legend>";
					
		// Loopar igenom messages-arrayen och skriver ut meddelanden.
		$ret .= $this->showMessages();
		
		$ret .= "
					<input type='hidden' name='$this->addMemberLocation'>
					<div>
						<label for='$this->memberFirstNameLocation'>First name: </label>
						<input type='text' name='$this->memberFirstNameLocation' id='$this->memberFirstNameLocation' value='" . $firstName . "'/>
					</div>
					<div>
						<label for='$this->memberLastNameLocation'>Last name: </label>
						<input type='text' name='$this->memberLastNameLocation' id='$this->memberLastNameLocation' value='" . $lastName . "'/>
					</div>
					<div>
						<label for='$this->memberIdentityNumberLocation'>Personal identity number: </label>
						<input type='text' name='$this->memberIdentityNumberLocation' id='$this->memberIdentityNumberLocation' value='" . $identityNumber . "'/>
					</div>
					<div>
						<input type='submit' id='confirmAdd' name='$this->submitAddMemberLocation' value='Confirm'/>
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