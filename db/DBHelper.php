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
		}
	}
	function __destruct() {
		if (! empty ( $db ))
			mysql_close ( $db );
	}
	
	public function queryUser($username, $email) {
		$querySql = 'select id,name,email from account where email = "' . $email . '" or name = "' . $username . '"';
		return mysql_query ( $querySql );
	}
	
	public function addAccount($account) {
		$insertsql = 'INSERT INTO account (name,psd,email,createtime,status,type) ' . 'VALUES("' . mysql_real_escape_string ( $account->name ) . '","' . mysql_real_escape_string ( $account->psd ) . '","' . mysql_real_escape_string ( $account->email ) . '","' . date ( 'Ymd' ) . '",' . $account->status . ',' . $account->type . ')';
		$result = mysql_query ( $insertsql );
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
		return mysql_query($loginSql);
	}
	
	public function addUser($user) {
		$insertuser = 'INSERT INTO user (accountid,realname,address,qq,tel,businesslicenseurl) ' . 'VALUES(' . $user->accountid . ',"' . mysql_real_escape_string ( $user->realname ) . '","' . mysql_real_escape_string ( $user->address ) . '","' . $user->qq . '","' . $user->tel . '","' . $user->businesslicenseurl . '")';
		$result = mysql_query ( $insertuser );
		return mysql_insert_id ();
	}
	
	public function getUsersInfo($type){
		$usersinfosql = "SELECT * from (SELECT * FROM `account` WHERE type = '".$type."'".
						" ) a left outer join user on a.id = user.accountid	";
		return mysql_query($usersinfosql);
	}
	
	public function addLine($line) {
		$insertline = 'INSERT INTO line (accountid,name,createtime) ' . 'VALUES(' . $line->accountid . ',"' . mysql_real_escape_string ( $line->name ) . '","' . date ( 'Ymd' ) . '")';
		$result = mysql_query ( $insertline );
		return mysql_insert_id ();
	}
	public function updateLineAccount($line) {
		$updateline = 'UPDATE line set accountid = ' . $line->accountid . ' where id = ' . $line->id;
		echo "<br/>updateline:" . $updateline;
		$result = mysql_query ( $updateline );
		echo "update result:" . $result;
		return $result;
	}
	
	public function getAllLines(){
		$sql = 'SELECT * FROM line order by createtime,id';
		return mysql_query($sql);
	}
	public function addProduct($product) {
		$insertproduct = 'INSERT INTO product (lineid,title,description,price,childprice,photourl,promotephotourl,createtime) ' . 'VALUES(' . $product->lineid . ',"' . mysql_real_escape_string ( $product->title ) . '","' . mysql_real_escape_string ( $product->description ) . '","' . $product->price . '","' . $product->childprice . '","' . $product->photourl . '","' . $product->promotephotourl . '","' . date ( 'Ymd' ) . '")';
		$result = mysql_query ( $insertproduct );
		return mysql_insert_id ();
	}
	
	public function getLineProducts($lineid){
		$lineproductsql = 'select * from product where lineid = '.$lineid;
		return mysql_query($lineproductsql);
	}
	
	public function getProduct($id){
		$productsql = 'select * from product where id='.$id;
		return mysql_query($productsql);
	}
	
	public function addProductDate($productdate) {
		$insertproductdate = 'INSERT INTO productdate (productid,productdate,inventory,total) ' . 'VALUES(' . $productdate->productid . ',"' . $productdate->productdate . '",' . $productdate->inventory . ',' . $productdate->total . ')';
		return mysql_query ( $insertproductdate );
	}
	
	public function purchaseProductDate($productid,$productdate){
		$purchasesql = 'update productdate set inventory = inventory -1 where productid = '.$productid.' and  productdate = "'.$productdate.'"';
		return mysql_query($purchasesql);
	}
	
	public function getProductDate($pid){
		$pdatesql = "select * from productdate where productid = ".$pid." order by productdate";
		return mysql_query($pdatesql);
	}
	
	public function addPurchaseInfo($purchaseInfo) {
		$result = true;
		$insertpurchaseinfo = 'INSERT INTO purchaseinfo (productid,realname,birthday,isadult,productdate,cardtype,cardnumber,cardvalidate,accountid,createtime) ' . 'VALUES(' . $purchaseInfo->productid . ',"' . mysql_real_escape_string ( $purchaseInfo->realname ) . '","' . $purchaseInfo->birthday . '",' . $purchaseInfo->isadult . ',"' . $purchaseInfo->productdate . '",' . $purchaseInfo->cardtype . ',"' . mysql_real_escape_string ( $purchaseInfo->cardnumber ) . '","' . $purchaseInfo->cardvalidate . '",' . $purchaseInfo->accountid . ',"'.date ( 'Ymd H:i:s' ).'")';
		$updateInventorysql = 'update productdate set inventory = inventory -1 where productid = '. $purchaseInfo->productid.' and  productdate = "'.$purchaseInfo->productdate.'"';
		
		mysql_query("BEGIN");
		$insertResult = mysql_query ( $insertpurchaseinfo );
		$updateInventoryResult =  mysql_query($updateInventorysql);
		
		if($insertResult && $updateInventoryResult){
			mysql_query("COMMIT");
		}else{
			mysql_query("ROLLBACK");
			$result = false;
		}
		mysql_query("END");
		
		return $result;
	}
	
	public function getorders($productid){
		$ordersql = "select * from purchaseinfo where productid = ".$productid." order by createtime desc";
		return mysql_query($ordersql);
	}
	
	public function getInventory($productid,$productdate,$countpersons){
		$getInventory = 'select * from productdate where productid ='.$productid.'  and productdate = "'.$productdate.'"';
		return mysql_query($getInventory);
	}
	
	public function insertResetToken($userid,$token){
		$tokensql = "insert into resetpassword(userid,token) values(".$userid.",'".$token."')";
		return mysql_query ( $tokensql );
	}
	
	public function removeResetToken($userid){
		$delfirst = "delete from resetpassword where userid = ".$userid;
		return mysql_query ( $delfirst );
	}
	
	public function queryResetpsdUser($token){
		$queryToken = "select userid from resetpassword where token = '".$token."'";
		$result = mysql_query($queryToken);
		while( $useridarray = mysql_fetch_array ( $result )){
			return $useridarray['userid'];
		}
		return null;
	}
	
	public function updatepsd($userid,$newpassword){
		$psdupdate = "update account set psd = '".$newpassword."' where id = ".$userid;
		return mysql_query($psdupdate);
	}
}