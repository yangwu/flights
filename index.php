<?php
include_once dirname ( '__FILE__' ) . '/config.php';
include_once dirname ( '__FILE__' ) . '/./business/BLine.php';
include_once dirname ( '__FILE__' ) . '/./business/BProduct.php';
header ( "Content-Type: text/html;charset=utf-8" );
session_start ();
$username =$_SESSION ['username'];
$type = $_SESSION['type'];
session_commit();

if ($username == null) { // 未登录
	header ( "Location:./login.php?errorMsg=您尚未登录" );
	exit ();
}

$bline = new BLine();
$lines = $bline->getAllLines();
if(count($lines)>0){
	$activelineid = $lines[0]->id;	
}

$bproduct = new BProduct();
if(isset($activelineid)){
	$products = $bproduct->getLinePrducts($activelineid);
}
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
			<a class="brand" href="https://wishconsole.com/"> <span
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

        <div class="col-md-3">
            <h2>Line list</h2>
            <ul class="nav nav-tabs nav-stacked">
            <?php
            
            foreach ($lines as $templine){
            	$isactive = $templine->isactive;
            	if(strcmp($isactive,LINE_ACTIVE) == 0){
            		echo "<li class=\"active\"><a href='#'>".$templine->name."</a></li>";
            	}else{
            		echo "<li><a href='#'>".$templine->name."</a></li>";
            	}
            }
            ?>
    </ul>
        </div>
        <div class="col-md-9">
        <?php 
        	if(strcmp($type,TYPE_SUPPLIER) == 0 || strcmp($type,TYPE_HEADQUARTER) == 0){
        		echo "<div class=\"pull-right\">";
        		echo "<ul class=\"nav\">";

        		echo "<li class=\"dropdown\">";
        		echo "<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">&nbsp;&nbsp;管&nbsp;&nbsp;理&nbsp;&nbsp; <b class=\"caret\"></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>";
        		echo "<ul class=\"dropdown-menu\">";
        		echo "<li><a href=\"./addproduct.php\">发布产品</a></li>";
        		echo "<li><a href=\"./index.php\">发布促销信息</a></li>";
				if(strcmp($type,TYPE_HEADQUARTER) == 0){
					echo "<li><a href=\"./pendingaccounts.php\">审核门店信息</a></li>";
					echo "<li><a href=\"./lines.php\">专线管理</a></li>";
					echo "<li><a href=\"./suppliers.php\">批发商管理</a></li>";
				}        		
        		echo "</li>";
        		echo "</ul></div>";
        	}
        ?>
        	<h2>Product list</h2>
        	<ul class="nav nav-tabs nav-stacked">
            <?php 
            if(count($products)>0)
	            foreach ($products as $product){
	            	echo "<li><a href='#'>".$product->title."</a></li>";
	            }
            ?> 
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
<script type="text/javascript">
	$(document).ready(function(){
	    $('#officelicense').bind('input propertychange',function(){
	    	licenseChange();
	    });
	});
</script>					
</body>
</html>