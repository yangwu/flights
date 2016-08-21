<?php
include_once dirname ( '__FILE__' ) . '/./db/DBHelper.php';
include_once dirname ( '__FILE__' ) . '/./model/Log.php';
class BLog{
	
	private $dbhelper;
	public function __construct() {
		$this->dbhelper = new DBHelper ();
	}
	
	public function addLog($log){
		return ($this->dbhelper->addlog($log)>0);
	}
}