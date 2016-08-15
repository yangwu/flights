<?php
header ( "Content-Type: text/html;charset=utf-8" );

session_start ();
$currentusername =$_SESSION ['username'];
$type = $_SESSION['type'];
session_commit();

if ($currentusername == null) { // 未登录
	header ( "Location:./login.php?errorMsg=您尚未登录" );
	exit ();
}

$productid = $_POST['productid'];
$productdate = $_POST['productdate'];

$adultcount = $_POST['adultcount'];
$childcount = $_POST['childcount'];

for($a=0;$a<$adultcount;$a++){
	
}