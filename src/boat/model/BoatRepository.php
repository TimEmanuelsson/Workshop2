<?php

require_once('Boat.php');

class BoatRepository extends Repository {
	
	public static $id = 'ID';
	public static $boatTypeID = 'boatTypeID';
	public static $memberID = 'memberID';
	public static $length = 'length';
	
	public static $dbTable = 'boat';
	
	public function getBoatsByMember($memberID) {
		$db = $this -> connection();
			$boats = array();
		
			$sql = "SELECT * FROM " . self::$dbTable . " WHERE " . self::$memberID . " = ?";
			$params = array($memberID);

			$query = $db -> prepare($sql);
			$query -> execute($params);

			$result = $query -> fetchAll();
			
			foreach($result as $boat) {
				$bt = new Boat($boat[self::$id], $boat[self::$boatTypeID], $boat[self::$memberID], $boat[self::$length]);
				$boats[] = $bt;
			}
			
			return $boats;
	}
}