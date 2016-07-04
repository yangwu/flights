<?php
include_once dirname ( '__FILE__' ) . './db/DBHelper.php';
class BAccount {
	private $dbhelper;
	public function __construct() {
		$this->dbhelper = new DBHelper ();
	}
	public function addAccount($account) {
		if ($this->isAccountExisted ( $account )) {
			return false;
		}
		return $this->dbhelper->addAccount ( $account );
	}
	public function isAccountExisted($account) {
		$result = $this->dbhelper->checkAccount ( $account );
		if ($result) {
			if ($a = mysql_fetch_array ( $result )) {
				return true;
			}
		}
		return false;
	}
}