<?php

class NavigationView
{
	public static $actionList = 'list';
	public static $actionMember = 'member';
	public static $actionAddMember = 'addmember';
	public static $actionDeleteMember = 'deletemember';
	public static $actionBoat = 'boat';
	public static $actionAddBoat = 'addboat';
	public static $actionDeleteBoat = 'deleteboat';
	
	public static function getAction()
	{
		if(isset($_REQUEST[self::$actionMember]) && !isset($_REQUEST[self::$actionBoat]) && !isset($_REQUEST[self::$actionAddBoat]) && !isset($_REQUEST[self::$actionDeleteMember]))
		{
			return self::$actionMember;
		}
		
		if(isset($_REQUEST[self::$actionMember]) && isset($_REQUEST[self::$actionBoat]) && !isset($_REQUEST[self::$actionDeleteBoat]))
		{
			return self::$actionBoat;
		}
		
		if(isset($_REQUEST[self::$actionAddMember]))
		{
			return self::$actionAddMember;
		}
		
		if(isset($_REQUEST[self::$actionMember]) && isset($_REQUEST[self::$actionAddBoat]))
		{
			return self::$actionAddBoat;
		}
		
		if(isset($_REQUEST[self::$actionMember]) && isset($_REQUEST[self::$actionDeleteMember])) {
			return self::$actionDeleteMember;
		}
		
		if(isset($_REQUEST[self::$actionMember]) && isset($_REQUEST[self::$actionBoat]) && isset($_REQUEST[self::$actionDeleteBoat])) {
			return self::$actionDeleteBoat;
		}
		
		return self::$actionList;
	}
}

?>