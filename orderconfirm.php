<?php
include_once dirname ( '__FILE__' ) . '/model/PurchaseInfo.php';
include_once dirname ( '__FILE__' ) . '/business/BPurchaseInfo.php';
include_once dirname ( '__FILE__' ) . '/business/BProduct.php';
header ( "Content-Type: text/html;charset=utf-8" );

session_start ();
$currentusername =$_SESSION ['username'];
$type = $_SESSION['type'];
$accountid = $_SESSION['id'];
session_commit();

if ($currentusername == null) { // 未登录
	header ( "Location:./login.php?errorMsg=您尚未登录" );
	exit ();
}

$productid = $_POST['productid'];
$productdate = $_POST['productdate'];

$adultcount = $_POST['adultcount'];
$childcount = $_POST['childcount'];

$addresses = array();
for($a=1;$a<$adultcount+1;$a++){
	$temppurchaseinfo = new PurchaseInfo();
	$temppurchaseinfo->accountid = $accountid;
	$temppurchaseinfo->productdate = $productdate;
	$temppurchaseinfo->productid = $productid;
	
	$temppurchaseinfo->realname = $_POST['realname'.$a];
	$temppurchaseinfo->isadult = '1';
	$temppurchaseinfo->birthday = $_POST['adatetimepickerb'.$a];
	$temppurchaseinfo->cardtype = $_POST['cardtype'.$a];
	$temppurchaseinfo->cardnumber = $_POST['cardnumber'.$a];
	$temppurchaseinfo->cardvalidate = $_POST['adatetimepickerv'.$a];
	$addresses[] = $temppurchaseinfo;	
}

for($c=1;$c<$childcount+1;$c++){
	$cpurchaseinfo = new PurchaseInfo();
	$cpurchaseinfo->accountid = $accountid;
	$cpurchaseinfo->productdate = $productdate;
	$cpurchaseinfo->productid = $productid;

	$cpurchaseinfo->realname = $_POST['crealname'.$c];
	$cpurchaseinfo->isadult = '0';
	$cpurchaseinfo->birthday = $_POST['cdatetimepickerb'.$c];
	$cpurchaseinfo->cardtype = 0;
	$addresses[] = $cpurchaseinfo;
}

$bpi = new BPurchaseInfo();
$bp = new BProduct();
$count = count($addresses);
for($i=0;$i<$count;$i++){
	$purchaseinfo = $addresses[$i];
	if($bp->purchaseProductDate($purchaseinfo)){
		$bpi->addPurchaseInfo($purchaseinfo);
		echo "<br/>订购操作成功:".$purchaseinfo->productid."  ".$purchaseinfo->realname.$purchaseinfo->productdate;
	}else{
		echo "<br/>订购操作失败:".$purchaseinfo->productid."  ".$purchaseinfo->realname.$purchaseinfo->productdate;
	}
}


echo "<ul align=\"center\" style=\"color:#F00\"><a href=\"./productdetail.php?id=".$productid."\">返回</a></ul>";

