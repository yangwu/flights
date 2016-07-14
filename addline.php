<?php
include_once dirname ( '__FILE__' ) . '/config.php';
include_once dirname ( '__FILE__' ) . '/business/BLine.php';
include_once dirname ( '__FILE__' ) . '/model/Line.php';
header ( "Content-Type: text/html;charset=utf-8" );

session_start ();
$currentusername =$_SESSION ['username'];
$type = $_SESSION['type'];
session_commit();

if ($currentusername == null) { // 未登录
	header ( "Location:./login.php?errorMsg=您尚未登录" );
	exit ();
}

$command = $_GET['command'];
$msg = null;
if(strcmp ( $command, "addline" ) == 0){
	$linename  = $_POST['linename'];
	
	$line = new Line();
	$line->name = $linename;

	$bline = new BLine();
	$newlineid = $bline->addLine($line);

	if($newlineid>0){	
		$msg = "添加专线成功";
	}else{
		$msg = "添加专线失败";
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
			<?php echo $currentusername?>
			</li>
								<li><button>
										<a href="./login.php?command=exit">注销</a>
									</button></li>
			
							</ul>
			
						</div>
		</div>
		</div>
	</div>
	<!-- END HEADER -->
	<!-- SUB HEADER NAV-->
	<!-- splash page subheader-->

	<div id="page-content" class="container-fluid fixed-width ">

		<div id="signup-page-content">
			<div class="signup-page-container">
				<div class="signup-page-title">添加专线信息</div>
				<div class="signup-page-content">
					<form class="form form-horizontal" id="registerform" method="post"
						action="addline.php?command=addline">
						<?php if($msg != null)
							echo "<ul align=\"center\"  style=\"color:#F00\">".$msg."</ul>";?>
						<div class="control-group">
							<label class="control-label" for="linename"><font color="#F00">* </font>专线名称</label>
							<div class="controls input-append">
								<input type="text" id="linename" name="linename" class="input-block-level" value="<?php echo $linename?>"
									placeholder="专线名称"> <span class="add-on"><i class="icon-pencil"></i></span>
							
							</div>
						</div>
						
						<div id="create-store-container">
							<input type="button" id="signup-button"
								class="input-block-level flat-signup-btn"
								value="提交">
						
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="signup-page-footer">

			已经有账号了? <a href="login.php">点击这里登入</a>

		</div>



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

		$("#signup-button").click(function(){
			if($.trim($('#linename').val()).length<1){
				alert("专线名称不可为空");
				return;
			}

			$('#registerform').submit();
		});
			

		
	});
</script>					
</body>
</html>