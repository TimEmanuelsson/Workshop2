<?php

class NavigationView
{
	public static $actionList = 'list';
	public static $actionMember = 'member';
	public static $actionBoat = 'boat';
	
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
		
		return self::$actionList;
	}
}

?>