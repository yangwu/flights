<?php
header ( "Content-Type: text/html;charset=utf-8" );
define('WEBSITETITLE','遨游天下机票预订');

//用户类型:
define('FRONTSTORE','1');//门店
define('SUPPLIER','2');//批发商
define('HEADQUARTER','3');//总代

//账户状态:
define('APPROVED','1');//正常
define('PENDING','2');//待审核
define('DELETED','3');//已删除