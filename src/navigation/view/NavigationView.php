<?php

class NavigationView
{
	public static $actionList = 'list';
	public static $actionMember = 'member';
	public static $actionAddMember = 'addmember';
	public static $actionBoat = 'boat';
	public static $actionAddBoat = 'addboat';
	
	public static function getAction()
	{
		if(isset($_REQUEST[self::$actionMember]) && !isset($_REQUEST[self::$actionBoat]))
		{
			return self::$actionMember;
		}
		
		if(isset($_REQUEST[self::$actionMember]) && isset($_REQUEST[self::$actionBoat]))
		{
			return self::$actionBoat;
		}
		
		if(isset($_REQUEST[self::$actionAddMember])) {
			return self::$actionAddMember;
		}
		
		if(isset($_REQUEST[self::$actionAddBoat])) {
			return self::$actionAddBoat;
		}
		
		return self::$actionList;
	}
}

?>