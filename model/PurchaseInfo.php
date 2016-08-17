<?php
class PurchaseInfo {
	public $id, $accountid, $realname, $birthday, $isadult, $productid, $productdate, $cardtype, $cardnumber, $cardvalidate,$createtime;
	function __get($property_name) {
		if (isset ( $this->$property_name )) {
			return $this->$property_name;
		}
		return null;
	}
	function __set($property_name, $value) {
		$this->$property_name = $value;
	}
}