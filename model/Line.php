<?php
class Line {
	public $id, $accountid, $name, $createtime,$isactive;
	function __get($property_name) {
		if (isset ( $this->$property_name )) {
			return $this->$property_name;
		}
		return null;
	}
	function __set($property_name, $value) {
		$this->$property_name = $value;
	}
	public function __isset($name) {
		return isset ( $this->$name );
	}
}