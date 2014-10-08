<?php

require_once ('Member.php');
require_once ('./src/navigation/model/Repository.php');
require_once('./src/boat/model/BoatRepository.php');

class MemberRepository extends Repository {

	public static $id = 'ID';
	public static $firstName = 'firstName';
	public static $lastName = 'lastName';
	public static $identityNumber = 'identityNumber';
	
	public static $dbTable = 'member';
	
	private $boatRepository;

	public function __construct() {
		$this->boatRepository = new BoatRepository();
	}

	public function add(Member $member) {
		try {
			$db = $this -> connection();

			$sql = "INSERT INTO " . self::$dbTable . " (" . self::$firstName . ", " . self::$lastName . ", " . self::$identityNumber . ") VALUES (?, ?, ?)";
			$params = array($member -> getFirstName(), $member -> getLastName(), $member -> getIdentityNumber());

			$query = $db -> prepare($sql);
			$query -> execute($params);
			
		} catch (PDOException $e) {
			die('Nåt gick åt helvete med databasen yo!');
		}
	}

	public function getMemberAndBoats($id) {
		try {
			$db = $this -> connection();

			$sql = "SELECT * FROM " . self::$dbTable . " WHERE " . self::$id . " = ?";
			$params = array($id);

			$query = $db -> prepare($sql);
			$query -> execute($params);

			$result = $query -> fetch();

			if ($result) {
				$member = new Member($result[self::$id], $result[self::$firstName], $result[self::$lastName], $result[self::$identityNumber]);
				
				$this->boatRepository->getBoatsByMember($member->getID());
				// Ersätt detta med ett anrop till getBoatsByMember i BoatRepository.php
				/*
				$sql = "SELECT * FROM " . BoatRepository::$dbTable . " WHERE " . BoatRepository::$memberID . " = ?";
				$query = $db->prepare($sql);
				$query->execute (array($result[self::$id]));
				$boats = $query->fetchAll();
				foreach($boats as $boat) {
					$bt = new Boat($boat[BoatRepository::$id], $boat[BoatRepository::$boatTypeID], $boat[BoatRepository::$memberID], $boat[BoatRepository::$length]);
					$member->addBoat($bt);
				}
				 * */
				return $member;
			}

			return NULL;
		} catch (PDOException $e) {
			die('Kunde inte hämta ut medlemmen ur databasen.');
		}
	}
/*
	public function find($unique) {
		try {
			$db = $this -> connection();

			$sql = "SELECT * FROM $this->dbTable WHERE " . self::$key . " LIKE '%:unique%'";
			$params = array($unique);

			$query = $db -> prepare($sql);
			$query -> execute(array(':unique' => $unique));

			$memberList = new \model\memberList();

			foreach ($query->fetchAll() as $result) {
				$memberList -> add(new \model\member($result[self::$name], $result[self::$key]));
			}

			return $memberList;
		} catch (\PDOException $e) {
			die('An unknown error have occured.');
		}
	}
*/
	public function delete(Member $member) {
		try {
			$db = $this -> connection();

			$sql = "DELETE FROM " . self::$dbTable . " WHERE " . self::$id . " = ?";
			$params = array($member -> getId());

			$query = $db -> prepare($sql);
			$query -> execute($params);

		} catch (PDOException $e) {
			die('Fel när medlemmen skulle raderas.');
		}
	}
/*
	public function query($sql, $params = NULL) {
		try {
			$db = $this -> connection();

			$query = $db -> prepare($sql);
			$result;
			if ($params != NULL) {
				if (!is_array($params)) {
					$params = array($params);
				}

				$result = $query -> execute($params);
			} else {
				$result = $query -> execute();
			}

			if ($result) {
				return $result -> fetchAll();
			}

			return NULL;
		} catch (\PDOException $e) {
			die('An unknown error have occured.');
		}
	}
*/

	public function getAllMembersAndBoats() {
		try {
			$db = $this -> connection();
			
			$allMembersAndBoats = array();
			
			$sql = "SELECT " . self::$id . " FROM " . self::$dbTable;
			$query = $db -> prepare($sql);
			$query -> execute();
			$result = $query->fetchAll();
			
			foreach($result as $id) {
				$memberAndBoats = $this->getMemberAndBoats($id['ID']);
				$allMembersAndBoats[] = $memberAndBoats;
			}
			
			return $allMembersAndBoats;
			
		} catch (PDOException $e) {
			die('Fel när flera medlemmar och båtar skulle hämtas från databasen.');
		}
	}

}