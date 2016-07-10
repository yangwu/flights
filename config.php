<?php
header ( "Content-Type: text/html;charset=utf-8" );
define('WEBSITETITLE','遨游天下机票预订');

//用户类型:account.type
define('TYPE_FRONTSTORE','1');//门店
define('TYPE_SUPPLIER','2');//批发商
define('TYPE_HEADQUARTER','3');//总代

//账户状态:account.status
define('STATUS_APPROVED','1');//正常
define('STATUS_PENDING','2');//待审核
define('STATUS_DELETED','3');//已删除

//Line Active状态:
define('LINE_INACTIVE','0');
define('LINE_ACTIVE','1');