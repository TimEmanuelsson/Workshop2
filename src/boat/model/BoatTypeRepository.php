<?php
require_once('./src/boat/model/BoatType.php');
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
	
	public function getAllBoatTypes() {
		$db = $this -> connection();
		
			$sql = "SELECT * FROM " . self::$dbTable;
			$params = array();

			$query = $db -> prepare($sql);
			$query -> execute($params);

			$result = $query -> fetchAll();
			
			$boatTypes = array();
			
			foreach($result as $row) {
				$boatType = new BoatType($row[self::$id], $row[self::$boatType]);
				$boatTypes[] = $boatType;
			}
			
			return $boatTypes;
	}
}