<?php
class DBHelper {
	private $db;
	public function __construct() {
		$dbhost = "localhost";
		$dbuser = "root";
		$dbpsd = "yangwu";
		$dbname = "flights";
		
		$db = mysql_connect ( $dbhost, $dbuser, $dbpsd, true );
		if (! $db) {
			echo "connection failed";
		} else {
			mysql_select_db ( $dbname );
			mysql_query ( "set names 'UTF8'" );
			echo "connection successful";
		}
	}
	function __destruct() {
		if (! empty ( $db ))
			mysql_close ( $db );
	}

	public function addAccount($account) {
		$insertsql = 'INSERT INTO account (name,psd,email,createtime,status,type) ' 
					. 'VALUES("' . $account->name . '","' . $account->psd . '","' . $account->email . '","' . date ( 'Ymd' ) . '",' . $account->status . ',' . $account->type . ')';
		echo "<br/>insertsql:".$insertsql;
		$result = mysql_query($insertsql);
		echo "<br/>insert result:".$result;
		return mysql_insert_id ();
	}
	
	public function checkAccount($account) {
		$querySql = 'select id,name,email from account where email = "' . $account->email . '" or name = "' . $account->name . '"';
		echo "<br/>check sql:".$querySql;
		$result = mysql_query($querySql);
		return $result;
	}
	
	public function addUser($user){
		$insertuser = 'INSERT INTO user (accountid,realname,address,qq,tel,businesslicenseurl) '
				. 'VALUES(' . $user->accountid . ',"' . $user->realname . '","' . $user->address . '","' . $user->qq . '",' . $user->tel . ',"' . $user->businesslicenseurl . '")';
		echo "<br/>insertsql:".$insertuser;
		$result = mysql_query($insertuser);
		echo "<br/>insert result:".$result;
		return mysql_insert_id();
	}
}