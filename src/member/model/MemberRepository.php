<?php

require_once ('Member.php');
require_once ('./src/navigation/model/Repository.php');
require_once('./src/boat/model/BoatRepository.php');

class MemberRepository extends Repository
{

	public static $id = 'ID';
	public static $firstName = 'firstName';
	public static $lastName = 'lastName';
	public static $identityNumber = 'identityNumber';
	
	public static $dbTable = 'member';
	
	private $boatRepository;

	public function __construct()
	{
		$this->boatRepository = new BoatRepository();
	}
	
	// Lägger till en medlem i databasen.
	public function add(Member $member)
	{
		try
		{
			$db = $this -> connection();

			$sql = "INSERT INTO " . self::$dbTable . " (" . self::$firstName . ", " . self::$lastName . ", " . self::$identityNumber . ") VALUES (?, ?, ?)";
			$params = array($member -> getFirstName(), $member -> getLastName(), $member -> getIdentityNumber());

			$query = $db -> prepare($sql);
			$query -> execute($params);
			
			$memberID = $db->lastInsertId();
			
			// Hämtar den nytillagda medlemmen & returnerar den.
			$member = $this->getMemberAndBoats($memberID);
			return $member;
		}
		catch (PDOException $e)
		{
			throw new Exception('Nåt gick åt helvete med databasen yo!');
		}
	}
	
	// Tar bort medlem med specifikt ID.
	public function delete($id)
	{
		try
		{
			$db = $this -> connection();

			$sql = "DELETE FROM " . self::$dbTable . " WHERE " . self::$id ."=?";
			$params = array($id);

			$query = $db -> prepare($sql);
			$query -> execute($params);
		}
		catch (PDOException $e)
		{
			throw new Exception('Nåt gick åt helvete med databasen yo!');
		}
	}
	
	// Uppdaterar en specifik medlem.
	public function update(Member $member)
	{
		try
		{
			$db = $this -> connection();

			$sql = "UPDATE " . self::$dbTable . " SET " . self::$firstName . "=?, " . self::$lastName . "=?, " . self::$identityNumber . "=? WHERE " . self::$id ."=?";
			$params = array($member -> getFirstName(), $member -> getLastName(), $member -> getIdentityNumber(), $member -> getID());

			$query = $db -> prepare($sql);
			$query -> execute($params);
		}
		catch (PDOException $e)
		{
			throw new Exception('Nåt gick åt helvete med databasen yo!');
		}
	}
	
	// Hämtar en medlem & dennes båtar med specifikt ID.
	public function getMemberAndBoats($id)
	{
		try
		{
			$db = $this -> connection();

			$sql = "SELECT * FROM " . self::$dbTable . " WHERE " . self::$id . " = ?";
			$params = array($id);

			$query = $db -> prepare($sql);
			$query -> execute($params);

			$result = $query -> fetch();

			if($result)
			{
				$boats = $this->boatRepository->getBoatsByMember($id);
				$member = new Member($result[self::$id], $result[self::$firstName], $result[self::$lastName], $result[self::$identityNumber], $boats);

				return $member;
			}

			return NULL;
		}
		catch(PDOException $e)
		{
			throw new Exception('Kunde inte hämta ut medlemmen ur databasen.');
		}
	}
	
	// Hämtar alla medlemmar & deras båtar.
	public function getAllMembersAndBoats()
	{
		try
		{
			$db = $this -> connection();
			
			$allMembersAndBoats = array();
			
			$sql = "SELECT " . self::$id . " FROM " . self::$dbTable;
			$query = $db -> prepare($sql);
			$query -> execute();
			$result = $query->fetchAll();
			
			foreach($result as $id)
			{
				$memberAndBoats = $this->getMemberAndBoats($id['ID']);
				$allMembersAndBoats[] = $memberAndBoats;
			}
			
			return $allMembersAndBoats;
		}
		catch(PDOException $e)
		{
			throw new Exception('Fel när flera medlemmar och båtar skulle hämtas från databasen.');
		}
	}
}