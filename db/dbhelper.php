<?php

class dbhelper {
	
	private $db;
	
	public function __construct() {
		$dbhost = "localhost";
		$dbuser = "root";
		$dbpsd = "yangwu";
		$dbname = "flights";
	
		$db = mysql_connect ( $dbhost, $dbuser, $dbpsd, true );
		if (! $db) {
			echo "connection failed";
		}else{
			mysql_select_db ( $dbname );
			mysql_query ( "set names 'UTF8'" );
			echo "connection successful";
		}
	}
	
	function __destruct() {
		if (! empty ( $db ))
			mysql_close ( $db );
	}
	
	public function queryAccounts() {
		$querySql = 'select * from account';
		$result = mysql_query ( $querySql );
		echo "Query result:".$result;
		return $result;
	}
}