<?php
class Product {
	private $id, $lineid, $description, $price, $childprice, $photourl, $promotephotourl, $title, $createtime;
	private $productdates = array ();
	function __get($property_name) {
		if (isset ( $this->$property_name )) {
			return $this->$property_name;
		}
		return null;
	}
	function __set($property_name, $value) {
		$this->$property_name = $value;
	}
	function addProductDate($productdate) {
		$productdates [] = $productdate;
	}
}