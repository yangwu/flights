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
	
	public function updatelinename($line){
		return $this->dbhelper->updateLineName($line);	
	}
	
	public function getLineById($lineid){
		$result = $this->dbhelper->getLineById($lineid);
		if($result){
			if($temp = mysql_fetch_array($result)){
				$line = new Line();
				$line->id = $temp['id'];
				$line->accountid = $temp['accountid'];
				$line->name = $temp['name'];
				$line->createtime = $temp['createtime'];
				return $line;
			}
		}
		return null;
	}
	public function getAllLines(){
		$result = $this->dbhelper->getAllLines();
		$lines = array();
		while($temp = mysql_fetch_array($result)){
			$line = new Line();
			$line->name = $temp['name'];
			$line->id = $temp['id'];
			$lines[] = $line;
		}
		return $lines;
	}
	
	public function getUnAllocatedLines(){
		$result = $this->dbhelper->getUnAllocatedLines();
		$lines = array();
		while($temp = mysql_fetch_array($result)){
			$line = new Line();
			$line->name = $temp['name'];
			$line->id = $temp['id'];
			$line->createtime = $temp['createtime'];
			$line->accountid = $temp['accountid'];
			$lines[] = $line;
		}
		return $lines;
	}
}