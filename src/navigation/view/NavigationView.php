<?php

class NavigationView
{
	private static $actionList = 'list';
	private static $actionMember = 'member';
	private static $actionBoat = 'boat';
	
	public static function getAction()
	{
		if(isset($_GET[self::$actionMember]))
		{
			return self::$actionMember;
		}
		
		if(isset($_GET[self::$actionBoat]))
		{
			return self::$actionBoat;
		}
		
		return self::$actionList;
	}
}

?>