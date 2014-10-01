<?php

abstract class Repository {
	protected $dbUsername = '';
	protected $dbPassword = '';
	protected $dbConnstring = '';
	protected $dbConnection;
	protected $dbTable;
	
	protected function connection() {
		if ($this->dbConnection == NULL) {
			$this->dbConnection = new PDO($this->dbConnstring, $this->dbUsername, $this->dbPassword);
		}
		
		$this->dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		return $this->dbConnection;
	}
}