<?php


class HTMLView {
	public function echoHTML($body) {
		if($body == NULL){
			throw new Exception("Body does not allow null!");
			
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