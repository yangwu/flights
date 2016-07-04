<?php
class User {
	private $id, $accountid, $address, $realname, $qq, $tel, $businesslicenseurl;
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