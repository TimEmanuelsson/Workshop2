<?php

require_once('./src/navigation/view/NavigationView.php');
require_once('./src/member/controller/MemberController.php');
//require_once('src/list/view/BoatController.php');
require_once('./src/list/controller/ListController.php');

class NavigationController
	{
		public function doNavigation()
		{
			$controller;
			
			try
			{
				switch (NavigationView::getAction())
				{
					case NavigationView::$actionMember:
						
						$controller = new MemberController();
						return $controller->showMember();
						break;
						
					case NavigationView::$actionBoat:
						
						//$controller = new BoatController();
						
						break;
						
					case NavigationView::$actionList:
					default:
						
						$controller = new ListController();
						return $controller->showList();
						
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