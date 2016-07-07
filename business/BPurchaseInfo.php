<?php
include_once dirname ( '__FILE__' ) . '/./db/DBHelper.php';
class BPurchaseInfo {
	private $dbhelper;
	public function __construct() {
		$this->dbhelper = new DBHelper ();
	}
	public function addPurchaseInfo($purchaseinfo) {
		return $this->dbhelper->addPurchaseInfo ( $purchaseinfo );
	}
}