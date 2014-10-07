<?php
require_once()
require_once ('./src/navigation/model/Repository.php');

class BoatTypeRepository extends Repository {
	
	public static $id = 'ID';
	public static $boatType = 'boatType';
	
	public static $dbTable = 'boattype';
	
	public function getBoatTypeByID($boatTypeID) {
		$db = $this -> connection();
		
			$sql = "SELECT * FROM " . self::$dbTable . " WHERE " . self::$id . " = ?";
			$params = array($boatTypeID);

			$query = $db -> prepare($sql);
			$query -> execute($params);

			$result = $query -> fetch();
			
			$boatType = new BoatType($result[self::$id], $result[self::$boatType]);
			
			return $boatType;
	}
}