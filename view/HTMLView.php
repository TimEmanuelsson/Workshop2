<?php


class HTMLView {
	public function echoHTML($body) {
		if($body == NULL){
			throw new \Exception("Body dose not allow to be null!");
			
		}
			echo "
					<!DOCTYPE html>
					<html>
					<head>
						<meta charset=UTF-8>
						<title>Tims login</title>
					</head>
					<body>
						$body
					</body>
					</html>
			";
	}
}