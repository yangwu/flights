<?php
class Account {
	public $id, $name, $email, $psd, $createtime, $type, $status;
	public $user;
	public $lines;
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