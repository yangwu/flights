<?php
include_once dirname ( '__FILE__' ) . './db/DBHelper.php';
class BUser{
	private $dbhelper;
	public function __construct() {
		$this->dbhelper = new DBHelper ();
	}
	
	public function addUser($user){
		return $this->dbhelper->addUser($user);
	}
}