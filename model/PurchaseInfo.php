<?php
include_once dirname ( '__FILE__' ) . '/config.php';
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
	
	function getUIIsChild(){
		if(!$this->isadult)
			return "(儿童)";
	}
	
	function getUICardInfo(){
		$cards=unserialize(CARDARRAY);
		$result = $cards[$this->cardtype];
		$result .= $this->cardnumber;
		if($this->cardvalidate != null)
			$result .= "   有效期:".$this->cardvalidate;
		
		return $result;
	}
}