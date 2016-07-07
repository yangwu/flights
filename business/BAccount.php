<?php
include_once dirname ( '__FILE__' ) . '/./db/DBHelper.php';
include_once dirname ( '__FILE__' ) . '/./model/Account.php';
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
}