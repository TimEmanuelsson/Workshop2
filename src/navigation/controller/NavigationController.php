<?php

require_once('./src/navigation/view/NavigationView.php');
require_once('./src/member/controller/MemberController.php');
require_once('./src/boat/controller/BoatController.php');
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
					$result = $controller->memberControl();
					if($result === self::$operationSuccess) {
						return $controller->memberControl(self::$operationSuccess);
					}
					return $result;
					break;
				
				case NavigationView::$actionAddMember:
					
					$controller = new MemberController();
					$result = $controller->memberControl();
					return $result;
					break;
					
				case NavigationView::$actionDeleteMember:
					
					$controller = new MemberController();
					$result = $controller->memberControl();
					if($result === self::$operationSuccess) {
						$controller = new ListController();
						$result = $controller->listControl(self::$operationSuccess); 
					}
					return $result;
					break;
					
				case NavigationView::$actionBoat:
					
					$controller = new BoatController();
					$result = $controller->boatControl();
					if($result === self::$operationSuccess) {
						$controller = new MemberController();
						return $controller->memberControl(self::$operationSuccess);
					}
					return $result;
					break;
					
				case NavigationView::$actionAddBoat:
					
					$controller = new BoatController();
					$result = $controller->boatControl();
					if($result === self::$operationSuccess) {
						$controller = new MemberController();
						return $controller->memberControl(self::$operationSuccess);
					}
					return $result;
					break;
					
				case NavigationView::$actionDeleteBoat:
					
					$controller = new BoatController();
					$result = $controller->boatControl();
					if($result === self::$operationSuccess) {
						$controller = new MemberController();
						return $controller->memberControl(self::$operationSuccess);
					}
					$controller = new MemberController();
					return $controller->memberControl();
					break;
					
				case NavigationView::$actionList:
				default:
					
					$controller = new ListController();
					$result = $controller->listControl(); 
					return $result;
					
					break;
				
			}	
		}
		catch (Exception $e)
		{
			$controller = new ListController();
			$result = $controller->listControl(false, true);
			return $result;
		}
	}
}
?>