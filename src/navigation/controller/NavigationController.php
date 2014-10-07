<?php

require_once('src/navigation/view/NavigationView.php');
require_once('src/list/view/MemberController.php');
//require_once('src/list/view/BoatController.php');
require_once('src/list/view/ListController.php');

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
						
						break;
						
					case NavigationView::$actionBoat:
						
						$controller = new BoatController();
						
						break;
						
					case NavigationView::$actionList:
					default:
						
						$controller = new ListController();
						
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