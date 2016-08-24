<?php
include_once dirname ( '__FILE__' ) . '/./db/DBHelper.php';
include_once dirname ( '__FILE__' ) . '/./model/Account.php';
include_once dirname ( '__FILE__' ) . '/./model/User.php';
include_once dirname ( '__FILE__' ) . '/./model/Line.php';
class BAccount {
	private $dbhelper;
	public function __construct() {
		$this->dbhelper = new DBHelper ();
	}
	public function addAccount($account) {
		if ($this->isAccountExisted ( $account )) {
			return false;
		}
		return $this->dbhelper->addAccount ( $account );
	}
	
	public function isAdminExist(){
		$result = $this->dbhelper->isAdminExist();
		if ($result){
			if($temp = mysql_fetch_array($result))
				return true;
		}
		return false;
	}
	
	public function addAccountInfo($account,$user,$lines){
		return $this->dbhelper->addAccountInfo($account, $user, $lines);
	}
	
	public function updateAccountInfo($account,$lines){
		$oldlinesarray = $account->lines;
		$oldlines = array();
		foreach ($oldlinesarray as $oldline){
			$oldlines[] = $oldline->id;
		}
		return $this->dbhelper->updateAccountInfo($account, $account->user, $oldlines, $lines);
	}
	
	public function isAccountExisted($account) {
		$result = $this->dbhelper->checkAccount ( $account );
		if ($result) {
			if ($a = mysql_fetch_array ( $result )) {
				return true;
			}
		}
		return false;
	}
	public function getAccount($username, $psd) {
		$result = $this->dbhelper->getAccount ( $username, $psd );
		if ($result) {
			if ($account = mysql_fetch_array ( $result )) {
				$currentAccount = new Account ();
				$currentAccount->id = $account ['id'];
				$currentAccount->name = $account ['name'];
				$currentAccount->email = $account ['email'];
				$currentAccount->createtime = $account ['createtime'];
				$currentAccount->type = $account ['type'];
				$currentAccount->status = $account ['status'];
				return $currentAccount;
			}
		}
		return null;
	}
	
	public function getSuppliersInfo(){
		$suppliers = array();
		$suppliersResult = $this->dbhelper->getUsersInfo(TYPE_SUPPLIER);
		if($suppliersResult){
			while ($supplier = mysql_fetch_array($suppliersResult)){
				$curAccount = new Account();
				$curUser = new User();
				
				$curAccount->name = $supplier['name'];
				$curAccount->id = $supplier['id'];
				$curUser->address = $supplier['address'];
				$curUser->businesslicenseurl = $supplier['businesslicenseurl'];
				$curUser->qq = $supplier['qq'];
				$curUser->realname = $supplier['realname'];
				$curUser->tel = $supplier['tel'];
				
				$curAccount->user = $curUser;
				$curAccount->lines = $this->getUserLines($supplier['id']);
				
				$suppliers[] = $curAccount;
			}
		}
		
		return $suppliers;
	}
	
	public function getSupplier($sid){
		$supplierResult = $this->dbhelper->getUserById($sid);
		if($supplierResult){
			if($supplier = mysql_fetch_array($supplierResult)){
				$curAccount = new Account();
				$curUser = new User();
				
				$curAccount->name = $supplier['name'];
				$curAccount->id = $supplier['accountid'];
				$curUser->address = $supplier['address'];
				$curUser->businesslicenseurl = $supplier['businesslicenseurl'];
				$curUser->qq = $supplier['qq'];
				$curUser->realname = $supplier['realname'];
				$curUser->tel = $supplier['tel'];
				$curUser->id = $supplier['userid'];
				
				$curAccount->user = $curUser;
				$curAccount->lines = $this->getUserLines($sid);
				
				return $curAccount;
			}
		}
		return null;
	}
	
	public function getUserLines($sid){
		$lines = array();
		$linesresult = $this->dbhelper->getUserLines($sid);
		if($linesresult){
			while($line = mysql_fetch_array($linesresult)){
				$curLine = new Line();
				$curLine->id = $line['id'];
				$curLine->accountid = $line['accountid'];
				$curLine->createtime = $line['createtime'];
				$curLine->name = $line['name'];
				
				$lines[] = $curLine;
			}
		}
		return $lines;
	}
	
	public function getPendingAccountInfo(){
		$pendingaccounts = array();
		$pendingResult = $this->dbhelper->getUsersInfo(TYPE_FRONTSTORE);
		if($pendingResult){
			while($pendingaccount = mysql_fetch_array($pendingResult)){
				$status = $pendingaccount['status'];
				if(strcmp($status,STATUS_PENDING) == 0){
					$curAccount = new Account();
					$curUser = new User();
					
					$curAccount->id = $pendingaccount['id'];
					$curAccount->name = $pendingaccount['name'];
					$curUser->address = $pendingaccount['address'];
					$curUser->businesslicenseurl = $pendingaccount['businesslicenseurl'];
					$curUser->qq = $pendingaccount['qq'];
					$curUser->realname = $pendingaccount['realname'];
					$curUser->tel = $pendingaccount['tel'];
					
					$curAccount->user = $curUser;
					
					$pendingaccounts[] = $curAccount;
				}
			}
		}
		return $pendingaccounts;
	}
	
	public function updateAccountStatus($accountid,$status){
		return $this->dbhelper->updateAccountStatus($accountid, $status);
	}
}