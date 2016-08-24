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
$pendingid = $_GET['i'];
$pendingflag = $_GET['f'];

$baccount = new BAccount();
if($pendingid != null && $pendingflag != null){
	if(strcmp($pendingflag,'0')){
		$result = $baccount->updateAccountStatus($pendingid, STATUS_DELETED);
	}else if(strcmp($pendingflag,'1')){
		$result = $baccount->updateAccountStatus($pendingid,STATUS_APPROVED);
	}	
}

$pendingAccounts = $baccount->getPendingAccountInfo();

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
        <div class="col-md-10">
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
        	  <div>
      <?php $count = count($pendingAccounts);
      		$k=0;
        if($count>0){
        	echo "<div class=\"widget-body\"><table class=\"table table-condensed table-striped table-bordered table-hover no-margin\"><thead><tr>";
        	echo "<th style=\"width:10%\">账号</th><th style=\"width:10%\" class=\"hidden-phone\">姓名</th>";
        	echo "<th style=\"width:20%\" class=\"hidden-phone\">地址</th><th style=\"width:20%\" class=\"hidden-phone\">联系方式</th><th style=\"width:30%\" class=\"hidden-phone\">营业执照</th><th style=\"width:10%\" class=\"hidden-phone\">审核操作</th></tr></thead>";
        	echo "<tbody>";
        	echo "<br/>等待审核的门店信息列表";
        	if(isset($result)){
        		echo "<div class=\"alert alert-block alert-success fade in\">";
        		echo "<h4 class=\"alert-heading\">";
        		if($result){
        			echo "门店审核完成";
        		}else{
        			echo "门店审核失败，请联系管理员 admin@wishconsole.com，";
        		}
        		echo "</h4>";
        		echo "</div>";
        		$result = null;
        	}
        	foreach ($pendingAccounts as $pendingAccount){
        		if ($k % 2 == 0) {
        			echo "<tr>";
        		} else {
        			echo "<tr class=\"gradeA success\">";
        		}
        		echo "<td style=\"width:10%;vertical-align:middle;\">".$pendingAccount->name."</td>";
        		echo "<td style=\"width:10%;vertical-align:middle;\">".$pendingAccount->user->realname."</td>";
        		echo "<td style=\"width:20%;vertical-align:middle;\">".$pendingAccount->user->address."</td>";
        		echo "<td style=\"width:20%;vertical-align:middle;\">".$pendingAccount->user->tel." QQ:".$pendingAccount->user->qq."</td>";
        		echo "<td style=\"width:30%;vertical-align:middle;\"><img src=\"".$pendingAccount->user->businesslicenseurl."\" width=200 height=200 /> </td>";
        		echo "<td style=\"width:10%;vertical-align:middle;\" class=\"hidden-phone\"><button type=\"button\" onclick=\"approve('".$pendingAccount->id."',1,'".$pendingAccount->name."')\" class=\"btn btn-mini\"><span class=\"label label-info\">通过</span></button><button type=\"button\" onclick=\"approve('".$pendingAccount->id."',0,'".$pendingAccount->name."')\" class=\"btn btn-mini\"><span class=\"label label-error\">不通过</span></button></td>";
        		echo "</tr>";
        		$k++;
        	}
        	echo "</tbody></table></div>";
        }else{
        	echo "<h3>暂时没有待审批的门店用户信息</h3>";
        }
      ?>
   </div>
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
function approve(id,flag,name){
	if(flag == 1){
		if(confirm("确认审核通过账号"+name)){
			window.location.href="./pendingaccounts.php?i=" + id + "&f=" + flag;
			}else{
			return;}
	}else{
		if(confirm("确认拒绝通过账号"+name)){
		window.location.href="./pendingaccounts.php?i=" + id + "&f=" + flag;
			}else{
			return;}
	}
}
</script>
</body>
</html>