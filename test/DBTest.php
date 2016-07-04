<?php
include_once dirname ( '__FILE__' ) . './db/DBHelper.php';
include_once dirname ( '__FILE__' ) . './model/Account.php';
include_once dirname ( '__FILE__' ) . './model/User.php';
include_once dirname ( '__FILE__' ) . './business/BAccount.php';
include_once dirname ( '__FILE__' ) . './business/BUser.php';

header ( "Content-Type: text/html;charset=utf-8" );

$dbhelper = new DBHelper ();
echo "*************DBTEST************";

$account1 = new Account();
$account1->name = "test name";
echo "<br/>account:".$account1->name;

$account1->psd = md5('123');
$account1->email = 'test1@g.cn';
$account1->status = 1;
$account1->type = 2;

$baccount = new BAccount();
$result = $baccount->addAccount($account1);


if($result){
	echo "<br/> add account successful";	
}else {
	echo "<br/> add account failed";
}

$account2 = $account1;
$account2->email = 'tes"fds/".@gmail.com';
$result2 = $baccount->addAccount($account2);
if($result2){
	echo "<br/> add account2 successful";
}else {
	echo "<br/> add account2 failed";
}


$account1->email = 'test1@g.cn';
if($baccount->isAccountExisted($account1)){
	echo "<br/>check account1 existed";	
}else{
	echo "<br/>check account1 no existed";
}

$account3 = $account1;
$account3->name = 'newname3';
$account3->email = 'newemail3';

if($baccount->isAccountExisted($account3)){
	echo "<br/>check account3 existed";
}else{
	echo "<br/>check account3 no existed";
}

$result = $baccount->addAccount($account3);
if($result){
	echo "<br/>add account 3 success";
}else{
	echo "<br/>add account 3 failed";
}

$buser = new BUser();
$user1 = new User();
$user1->accountid = $result;
$user1->address = 'testaddress';
$user1->businesslicenseurl = '/image/12dj.jpg';
$user1->qq = '4324381732';
$user1->tel = '0872-843627418';
$user1->realname = 'testuser';
$insertUserid = $buser->addUser($user1);
if($insertUserid){
	echo "<br/>insert userid:".$insertUserid;
}else{
	echo "<br/>insert failed";	
}
