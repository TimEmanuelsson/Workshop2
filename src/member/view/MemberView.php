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
	
	public function didUserSubmitForm()
	{
		return isset($_POST['confirmButton']);
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
			<form METHOD='post' action=''>
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
						<input type='submit' id='confirmButton' name='confirmButton' value='Confirm'/>
					</div>
				</fieldset>
			</form>";
			
		return $ret;
	}
	
	public function validateUserInput($member)
	{
		$regexString = '/^[A-Za-z][A-Za-z0-9]{2,31}$/';
		$identityNumberRegex = '/^[0-9]{6}-[0-9]{4}$/';
		$firstNameValidated = FALSE;
		$lastNameValidated = FALSE;
		$identityNumberValidated = FALSE;
		
		// Kontrollerar förnamnet.
		if(isset($_POST['memberFirstName']) == FALSE || $_POST['memberFirstName'] == '' || strlen($_POST['memberFirstName']) < 3)
		{
			// Visar felmeddelande.
			array_push($this->messages, "Firstname has to few characters. Minimum of 3 characters.");
		}
		else
		{
			// Kontrollerar om förnamnet innehåller otillåtna tecken.
			if(!preg_match($regexString, $_POST['memberFirstName']))
			{
				// Tar bort de otillåtna tecknen.
				$_POST['memberFirstName'] = strip_tags($_POST['memberFirstName']);
				
				// Visar felmeddelande.
				array_push($this->messages, "Firstname contains illegal characters.");
				
				// Visa editsidan.
				$this->editMember($member);
				return FALSE;
			}
			else
			{
				// Förnamnet är validerat.
				$firstNameValidated = TRUE;
			}
		}
		
		// Kontrollerar efternamnet.
		if(isset($_POST['memberLastName']) == FALSE || $_POST['memberLastName'] == '' || strlen($_POST['memberLastName']) < 3)
		{
			// Visar felmeddelande.
			array_push($this->messages, "Lastname has to few characters. Minimum of 3 characters.");
		}
		else
		{
			// Kontrollerar om användarnamnet innehåller otillåtna tecken.
			if(!preg_match($regexString, $_POST['memberLastName']))
			{
				// Tar bort de otillåtna tecknen.
				$_POST['memberLastName'] = strip_tags($_POST['memberLastName']);
				
				// Visar felmeddelande.
				array_push($this->messages, "Lastname contains illegal characters.");
				
				// Visa editsidan.
				$this->editMember($member);
				return FALSE;
			}
			else
			{
				// Efternamnet är validerat.
				$lastNameValidated = TRUE;
			}
		}
		
		// Kontrollerar personnumret.
		if(isset($_POST['memberIdentityNumber']) == FALSE || $_POST['memberIdentityNumber'] == '' || !preg_match($identityNumberRegex, $_POST['memberIdentityNumber']))
		{
			// Visar felmeddelande.
			array_push($this->messages, "Identity number need to be of format YYMMDD-XXXX.");
			
			// Visa editsidan.
			$this->editMember($member);
			return FALSE;
		}
		else
		{
			// Personnumret är validerat.
			$identityNumberValidated = TRUE;
		}
		
		if($firstNameValidated === TRUE && $lastNameValidated === TRUE &&	$identityNumberValidated === TRUE)
		{
			return TRUE;
		}
	}
}