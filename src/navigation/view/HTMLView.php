<?php


class HTMLView {
	public function echoHTML($body) {
		if($body == NULL){
			$body = "An unknown error has occured!<br />
			<a href='?CompactList'>Click here to return to start page</a>";
		}
			echo "
					<!DOCTYPE html>
					<html>
					<head>
						<meta charset='UTF-8'>
						<title>Den Glade Piraten</title>
					</head>
					<body>
						$body
					</body>
					</html>
			";
	}
}