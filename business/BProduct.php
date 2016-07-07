<?php
include_once dirname ( '__FILE__' ) . '/./db/DBHelper.php';
class BProduct {
	private $dbhelper;
	public function __construct() {
		$this->dbhelper = new DBHelper ();
	}
	public function addProduct($product) {
		return $this->dbhelper->addProduct ( $product );
	}
	public function addProductDate($productdate) {
		$result = $this->dbhelper->addProductDate ( $productdate );
		if ($result)
			return true;
		return false;
	}
}