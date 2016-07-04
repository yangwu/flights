<?php
include_once dirname ( '__FILE__' ) . './db/DBHelper.php';
include_once dirname ( '__FILE__' ) . './model/Account.php';
include_once dirname ( '__FILE__' ) . './business/BAccount.php';

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
$account3->name = 'newname';
$account3->email = 'newemail';

if($baccount->isAccountExisted($account3)){
	echo "<br/>check account3 existed";
}else{
	echo "<br/>check account3 no existed";
}
