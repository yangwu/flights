<?php
include_once dirname ( '__FILE__' ) . './db/DBHelper.php';
class BLine {
	private $dbhelper;
	public function __construct() {
		$this->dbhelper = new DBHelper ();
	}
	public function addLine($line) {
		if (! isset ( $line->accountid )) {
			$line->accountid = 0;
		}
		return $this->dbhelper->addLine ( $line );
	}
	public function updatelineAccountid($line) {
		echo "<br/> accountid of line:" . $line->accountid;
		if (isset ( $line->accountid )) {
			return $this->dbhelper->updateLineAccount ( $line );
		}
		echo "<br/> line accountid not set";
		return false;
	}
}