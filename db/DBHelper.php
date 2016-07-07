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
		$insertsql = 'INSERT INTO account (name,psd,email,createtime,status,type) ' . 'VALUES("' . mysql_real_escape_string ( $account->name ) . '","' . mysql_real_escape_string ( $account->psd ) . '","' . mysql_real_escape_string ( $account->email ) . '","' . date ( 'Ymd' ) . '",' . $account->status . ',' . $account->type . ')';
		echo "<br/>insertsql:" . $insertsql;
		$result = mysql_query ( $insertsql );
		echo "<br/>insert result:" . $result;
		return mysql_insert_id ();
	}
	public function checkAccount($account) {
		$querySql = 'select id,name,email from account where email = "' . mysql_real_escape_string ( $account->email ) . '" or name = "' . mysql_real_escape_string ( $account->name ) . '"';
		echo "<br/>check sql:" . $querySql;
		$result = mysql_query ( $querySql );
		return $result;
	}
	public function getAccount($username,$psd){
		$loginSql = 'select * from account where psd = "' . $psd . '" and ';
		if (stripos ( $username, "@" ) != false) {
			$loginSql = $loginSql . ' email = "' . mysql_real_escape_string($username) . '"';
		} else {
			$loginSql = $loginSql . ' name = "' . mysql_real_escape_string($username) . '"';
		}
		echo "<br/>loginSql:".$loginSql;
		return mysql_query($loginSql);
	}
	
	public function addUser($user) {
		$insertuser = 'INSERT INTO user (accountid,realname,address,qq,tel,businesslicenseurl) ' . 'VALUES(' . $user->accountid . ',"' . mysql_real_escape_string ( $user->realname ) . '","' . mysql_real_escape_string ( $user->address ) . '","' . $user->qq . '","' . $user->tel . '","' . $user->businesslicenseurl . '")';
		echo "<br/>insertsql:" . $insertuser;
		$result = mysql_query ( $insertuser );
		echo "<br/>insert result:" . $result;
		return mysql_insert_id ();
	}
	public function addLine($line) {
		$insertline = 'INSERT INTO line (accountid,name,createtime) ' . 'VALUES(' . $line->accountid . ',"' . mysql_real_escape_string ( $line->name ) . '","' . date ( 'Ymd' ) . '")';
		echo "<br/>insertsql:" . $insertline;
		$result = mysql_query ( $insertline );
		echo "<br/>insert line result:" . $result;
		return mysql_insert_id ();
	}
	public function updateLineAccount($line) {
		$updateline = 'UPDATE line set accountid = ' . $line->accountid . ' where id = ' . $line->id;
		echo "<br/>updateline:" . $updateline;
		$result = mysql_query ( $updateline );
		echo "update result:" . $result;
		return $result;
	}
	public function addProduct($product) {
		$insertproduct = 'INSERT INTO product (lineid,title,description,price,childprice,photourl,promotephotourl,createtime) ' . 'VALUES(' . $product->lineid . ',"' . mysql_real_escape_string ( $product->title ) . '","' . mysql_real_escape_string ( $product->description ) . '","' . $product->price . '","' . $product->childprice . '","' . $product->photourl . '","' . $product->promotephotourl . '","' . date ( 'Ymd' ) . '")';
		echo "<br/>insertproduct:" . $insertproduct;
		$result = mysql_query ( $insertproduct );
		echo "<br/>insert product result:" . $result;
		return mysql_insert_id ();
	}
	public function addProductDate($productdate) {
		$insertproductdate = 'INSERT INTO productdate (productid,productdate,inventory,total) ' . 'VALUES(' . $productdate->productid . ',"' . $productdate->productdate . '",' . $productdate->inventory . ',' . $productdate->total . ')';
		echo "<br/>insertproductdate:" . $insertproductdate;
		return mysql_query ( $insertproductdate );
	}
	public function addPurchaseInfo($purchaseInfo) {
		$insertpurchaseinfo = 'INSERT INTO purchaseinfo (productid,realname,birthday,isadult,productdate,cardtype,cardnumber,cardvalidate,accountid) ' . 'VALUES(' . $purchaseInfo->productid . ',"' . mysql_real_escape_string ( $purchaseInfo->realname ) . '","' . $purchaseInfo->birthday . '",' . $purchaseInfo->isadult . ',"' . $purchaseInfo->productdate . '",' . $purchaseInfo->cardtype . ',"' . mysql_real_escape_string ( $purchaseInfo->cardnumber ) . '","' . $purchaseInfo->cardvalidate . '",' . $purchaseInfo->accountid . ')';
		echo "<br/>insertpurchaseinfo:" . $insertpurchaseinfo;
		$result = mysql_query ( $insertpurchaseinfo );
		echo "<br/>insert purchaseinfo result:" . $result;
		return mysql_insert_id ();
	}
}