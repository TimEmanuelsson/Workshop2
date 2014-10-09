<?php

require_once('./src/navigation/view/NavigationView.php');
require_once('./src/member/controller/MemberController.php');
require_once('src/boat/controller/BoatController.php');
require_once('./src/list/controller/ListController.php');

class NavigationController
{
	private static $operationSuccess = true;
	
	public function doNavigation()
	{
		$controller;
		
		
		try
		{
			switch (NavigationView::getAction())
			{
				case NavigationView::$actionMember:
					
					$controller = new MemberController();
					$result = $controller->showMember();
					if($result === self::$operationSuccess) {
						return $controller->showMember(self::$operationSuccess);
					}
					return $result;
					break;
				
				case NavigationView::$actionAddMember:
					
					$controller = new MemberController();
					$result = $controller->showMember();
					return $result;
					break;
					
				case NavigationView::$actionBoat:
					
					$controller = new BoatController();
					$result = $controller->showBoat();
					if($result === self::$operationSuccess) {
						$controller = new MemberController();
						return $controller->showMember(self::$operationSuccess);
					}
					return $result;
					break;
					
				case NavigationView::$actionAddBoat:
					
					$controller = new BoatController();
					$result = $controller->showBoat();
					return $result;
					break;
					
				case NavigationView::$actionList:
				default:
					
					$controller = new ListController();
					$result = $controller->showList(); 
					return $result;
					
					break;
				
			}	
		}
		catch (Exception $e)
		{
			echo $e;
		}
	}
}
?>