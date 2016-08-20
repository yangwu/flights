<?php
include_once dirname ( '__FILE__' ) . '/config.php';
include_once dirname ( '__FILE__' ) . '/./business/BAccount.php';
header ( "Content-Type: text/html;charset=utf-8" );
session_start ();
$username =$_SESSION ['username'];
$type = $_SESSION['type'];
session_commit();

if ($username == null) { // 未登录
	header ( "Location:./login.php?errorMsg=您尚未登录" );
	exit ();
}

$baccount = new BAccount();
$suppliers = $baccount->getSuppliersInfo();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title><?php echo WEBSITETITLE?></title>
			<meta name="keywords" content="">
				<link rel="stylesheet" type="text/css"
					href="./css/new_signup_page.css">
					<link href="./css/bootstrap.min.css" rel="stylesheet"/>

</head>
<body>
	<!-- HEADER -->
	<div id="header" class="navbar navbar-fixed-top">
		<div class="container-fluid">
			<a class="brand" href="./index.php"> <span
				class="merchant-header-text"><?php echo WEBSITETITLE?></span>
			</a>
			<div class="pull-right">
							<ul class="nav">
								<li>
			<?php echo $username?>
			</li>
								<li><button>
										<a href="./login.php?command=exit">注销</a>
									</button></li>
			
							</ul>
			
						</div>
		</div>
	</div>
	<!-- END HEADER -->
	<!-- SUB HEADER NAV-->
	<!-- splash page subheader-->

        <div class="col-md-10">
        <?php 
        	if(strcmp($type,TYPE_SUPPLIER) == 0 || strcmp($type,TYPE_HEADQUARTER) == 0){
        		echo "<div class=\"pull-right\">";
        		echo "<ul class=\"nav\">";

        		echo "<li class=\"dropdown\">";
        		echo "<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">&nbsp;&nbsp;管&nbsp;&nbsp;理&nbsp;&nbsp; <b class=\"caret\"></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>";
        		echo "<ul class=\"dropdown-menu\">";
        		echo "<li><a href=\"./index.php\">发布产品</a></li>";
        		echo "<li><a href=\"./index.php\">发布促销信息</a></li>";
				if(strcmp($type,TYPE_HEADQUARTER) == 0){
					echo "<li><a href=\"./index.php\">审核门店信息</a></li>";
					echo "<li><a href=\"./index.php\">添加专线</a></li>";
					echo "<li><a href=\"./addsupplier.php\">添加批发商</a></li>";
				}        		
        		echo "</li>";
        		echo "</ul></div>";
        	}
        ?>
        	<h3>批发商列表 &nbsp;&nbsp;&nbsp;&nbsp;<a href="addsupplier.php">添加批发商</a></h3>
        	<ul class="nav nav-tabs nav-stacked">
            <?php 
            if(count($suppliers)>0)
	            foreach ($suppliers as $supplier){
	            	echo "<li>".$supplier->user->realname."</li>";
	            }
            ?> 
            </ul>
        </div>

	<!-- FOOTER -->
	<div id="footer" class="navbar navbar-fixed-bottom" style="left: 0px;">
		<div class="navbar-inner">
			<div class="footer-container">
				<span><a href="https://wishconsole.com/">关于我们</a></span> <span><a>2016
						wishconsole版权所有 京ICP备16000367号</a>
				</span>
			</div>
		</div>
	</div>
	<!-- END FOOTER -->
<script type="text/javascript" src="./js/jquery-2.2.0.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="./js/bootstrap.min.js"></script>
<script type="text/javascript" src="./js/jquery.ajaxfileupload.js"></script>
</body>
</html>