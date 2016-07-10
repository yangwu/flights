<?php
include_once dirname ( '__FILE__' ) . '/./db/DBHelper.php';
include_once dirname ( '__FILE__' ) . '/./model/Line.php';
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
	
	public function getAllLines(){
		$result = $this->dbhelper->getAllLines();
		$lines = array();
		$isactive = LINE_INACTIVE;// current active line;
		while($temp = mysql_fetch_array($result)){
			$line = new Line();
			if(strcmp($isactive,LINE_ACTIVE) != 0){
				$isactive = LINE_ACTIVE;
				$line->isactive = $isactive;
			}else{
				$line->isactive = LINE_INACTIVE;
			}
			$line->name = $temp['name'];
			$lines[] = $line;
		}
		return $lines;
	}
}