<?php

class NavigationView
{
	public static $actionList = 'list';
	public static $actionMember = 'member';
	public static $actionBoat = 'boat';
	
	public static function getAction()
	{
		if(isset($_GET[self::$actionMember]) && !isset($_GET[self::$actionBoat]))
		{
			return self::$actionMember;
		}
		
		if(isset($_GET[self::$actionMember]) && isset($_GET[self::$actionBoat]))
		{
			return self::$actionBoat;
		}
		
		return self::$actionList;
	}
}

?>