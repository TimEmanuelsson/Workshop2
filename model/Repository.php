<?php

abstract class Repository {
	protected $dbUsername = 'dannberger_com';
	protected $dbPassword = 'BEAtWKgA';
	protected $dbConnstring = 'mysql:host=dannberger.com.mysql;dbname=dannberger_com';
	protected $dbConnection;
	
	protected function connection() {
		if ($this->dbConnection == NULL) {
			$this->dbConnection = new PDO($this->dbConnstring, $this->dbUsername, $this->dbPassword);
		}
		
		$this->dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		return $this->dbConnection;
	}
}