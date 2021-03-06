<?php

require_once('Boat.php');
require_once ('./src/navigation/model/Repository.php');
require_once('./src/boat/model/BoatTypeRepository.php');

class BoatRepository extends Repository
{
	
	public static $id = 'ID';
	public static $boatTypeID = 'boatTypeID';
	public static $memberID = 'memberID';
	public static $length = 'length';
	
	public static $dbTable = 'boat';
	
	private $boatTypeRepository;
	
	public function __construct()
	{
		$this->boatTypeRepository = new BoatTypeRepository();
	}
	
	// Lägger till en ny båt i databasen.
	public function add(Boat $boat, Member $member)
	{
		try
		{
			$db = $this -> connection();

			$sql = "INSERT INTO " . self::$dbTable . " (" . self::$boatTypeID . ", " . self::$memberID . ", " . self::$length . ") VALUES (?, ?, ?)";
			$params = array($boat -> getBoatTypeID(), $member -> getID(), $boat -> getLength());

			$query = $db -> prepare($sql);
			$query -> execute($params);
			
		}
		catch (PDOException $e)
		{
			throw new Exception('Nåt gick åt helvete med databasen yo!');
		}
	}
	
	// Tar bort en båt med specifikt ID ur databasen.
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
	
	// Uppdaterar en specifik båt.
	public function update(Boat $boat, Member $member)
	{
		try
		{
			$db = $this -> connection();

			$sql = "UPDATE " . self::$dbTable . " SET " . self::$boatTypeID . "=?, " . self::$memberID . "=?, " . self::$length . "=? WHERE " . self::$id ."=?";
			$params = array($boat -> getBoatTypeID(), $member -> getID(), $boat -> getLength(), $boat -> getID());

			$query = $db -> prepare($sql);
			$query -> execute($params);
		}
		catch (PDOException $e)
		{
			throw new Exception('Nåt gick åt helvete med databasen yo!');
		}
	}
	
	// Hämtar alla båter som ägs av en specifik medlem.
	public function getBoatsByMember($memberID)
	{
		$db = $this -> connection();
		$boats = array();
	
		$sql = "SELECT * FROM " . self::$dbTable . " WHERE " . self::$memberID . " = ?";
		$params = array($memberID);

		$query = $db -> prepare($sql);
		$query -> execute($params);

		$result = $query -> fetchAll();
		
		foreach($result as $boat)
		{
			$boatType = $this->boatTypeRepository->getBoatTypeByID($boat[self::$boatTypeID]);
			$bt = new Boat($boat[self::$id], $boat[self::$boatTypeID], $boat[self::$length], $boatType);
			$boats[] = $bt;
		}
		
		return $boats;
	}
	
	// Hämtar en båt med specifikt ID.
	public function getBoatByID($boatID)
	{
		$db = $this -> connection();
	
		$sql = "SELECT * FROM " . self::$dbTable . " WHERE " . self::$id . " = ?";
		$params = array($boatID);

		$query = $db -> prepare($sql);
		$query -> execute($params);

		$result = $query -> fetch();
		
		$boatType = $this->boatTypeRepository->getBoatTypeByID($boatID);
		$boat = new Boat($result[self::$id], $result[self::$boatTypeID], $result[self::$length], $boatType);
		
		return $boat;
	}
}