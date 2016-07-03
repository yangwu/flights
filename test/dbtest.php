<?php

include_once dirname ( '__FILE__' ).'./db/dbhelper.php';

$dbhelper = new dbhelper ();
echo "*************DBTEST************";
$dbhelper->queryAccounts();