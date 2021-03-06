<?php
include_once dirname ( '__FILE__' ) . '/config.php';
include_once dirname ( '__FILE__' ) . '/./business/BLine.php';
include_once dirname ( '__FILE__' ) . '/./business/BProduct.php';
header ( "Content-Type: text/html;charset=utf-8" );
session_start ();
$username =$_SESSION ['username'];
$type = $_SESSION['type'];
$accountid = $_SESSION['id'];
session_commit();

if ($username == null) { // 未登录
	header ( "Location:./login.php?errorMsg=您尚未登录" );
	exit ();
}
$bproduct = new BProduct();

$activelineid = $_GET['lineid'];

$bline = new BLine();
$lines = $bline->getAllLines();
if(count($lines)>0){
	if($activelineid == null)
		$activelineid = $lines[0]->id;	
}


if(isset($activelineid)){
	$products = $bproduct->getLinePrducts($activelineid);
	$contactinfo = $bproduct->getLineContactInfo($activelineid);
}

$updatable = false;
if(strcmp($type,TYPE_HEADQUARTER) == 0){
	$updatable = true;
}else if(strcmp($type,TYPE_SUPPLIER) == 0){
	$activeline = $bline->getLineById($activelineid);
	if(strcmp($activeline->accountid,$accountid) == 0){
		$updatable = true;
	}
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
<div class="col-md-1">
        </div>
        <div class="col-md-3">
            <h2>专线</h2>
            <ul class="nav nav-tabs nav-stacked">
            <?php
            
            foreach ($lines as $templine){
            	$templineid = $templine->id;
            	if($templineid == $activelineid){
            		echo "<li class=\"active\"><a href='#'>".$templine->name."</a></li>";
            		$activelinename = $templine->name;
            	}else{
            		echo "<li><a href='./index.php?lineid=".$templine->id."'>".$templine->name."</a></li>";
            	}
            }
            ?>
            <li>&nbsp;&nbsp;&nbsp;&nbsp;</li>
            <li>&nbsp;&nbsp;&nbsp;&nbsp;</li>
            <li>&nbsp;&nbsp;&nbsp;&nbsp;</li>
            <li>&nbsp;&nbsp;&nbsp;&nbsp;</li>
            <li>&nbsp;&nbsp;&nbsp;&nbsp;</li>
            <li>&nbsp;&nbsp;&nbsp;&nbsp;</li>
    </ul>
        </div>
        <div class="col-md-7">
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
        	<h2>产品</h2>
            <div class="widget">
            	<div class="widget-header">
                    <div class="title">
                      	<?php echo $activelinename;
                      		if(isset($contactinfo) && $contactinfo != null){
                      			$linetel = $contactinfo['tel'];
                      			$lineqq = $contactinfo['qq'];
                      			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"tencent://message/?uin=".$lineqq."&Site=l.com&Menu=yes\"><img border=\"5\" src=\"http://wpa.qq.com/pa?p=1:".$lineqq.":3\" alt=\"QQ联系\"/></a>";
                      			echo "&nbsp;&nbsp;&nbsp;&nbsp;联系电话:".$linetel;
                      		}
                      	?>
                      	
                    </div>
                  </div>
                  <div class="widget-body">
                  <?php 
                  if(count($products)>0){
                  	foreach ($products as $product){
                  		echo "<table class=\"table table-condensed table-hover no-margin\">";
                  		echo "<tbody>";
                  		echo "<tr>";
                  		echo "<td width=30%>";
                  		echo "<img src=\"".$product->photourl."\" width=200 height=200/>";
                  		echo "</td>";
                  		echo "<td width=50%>";
                  		echo "<ul><li>";
                  		echo "<span  class=\"label label label-info\">";
                  		echo "<a target=\"_blank\" href=\"./productdetail.php?id=".$product->id."\">".$product->title."</a>";
                  		echo "</span>";
                  		echo "</li><br/><li>";
                  		echo "<span  class=\"label label label-info\">";
                  		echo "成人票价:".$product->price."元";
                  		echo "</span>";
                  		echo "</li>";
                  		echo "<li>";
                  		echo "<span  class=\"label label label-info\">";
                  		echo "儿童票价:".$product->childprice."元";
                  		echo "</span>";
                  		echo "</li></ul>";
                  		echo "</td>";
                  		echo "<td width=20% valign=\"bottom\">";
                  		if($updatable){
                  			echo " <a href=\"./updateproduct.php?pid=".$product->id ."&lid=".$activelineid."\">修改</a>";
                  		}else{
                  			echo "";
                  		}
                  		
                  		echo "</td></tr></tbody></table>";
                 	}
                  }else{
                  	echo "<h4>该专线下目前无产品</h4>";
                  }
                  ?>
                  </div>
                </div>
            </ul>
        </div>
<div class="col-md-1">
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
</script>					
</body>
</html>