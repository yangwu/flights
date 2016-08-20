<?php 
include_once dirname ( '__FILE__' ) . '/config.php';
include_once dirname ( '__FILE__' ) . '/./business/BAccount.php';
include_once dirname ( '__FILE__' ) . '/./model/Account.php';
header ( "Content-Type: text/html;charset=utf-8" );

session_start ();
$command=$_GET['command'];
if(strcmp($command,"exit") == 0){
	$_SESSION['username'] = null;
}

$username =$_SESSION ['username'];
$type = $_SESSION['type'];
session_commit();

if ($username != null) { // 登录
	header ( "Location:./index.php" );
	exit ();
}

if(strcmp($command,"login") == 0 ){
	$username = $_POST['username'];
	$psd = $_POST['password'];
	$baccount = new BAccount();
	$account = $baccount->getAccount($username, md5($psd));
	if($account != null){
		echo "<br/>login success";
		if(strcmp($account->type,TYPE_FRONTSTORE) == 0 && strcmp($account->status,STATUS_PENDING) == 0 ){
			echo "<br/> your account is still pending";
			$errorMsg = "您的账户还在审核中，请等待管理员审核完毕后再继续使用。";
		}else {
			echo "<br/> go to index";
			session_start ();
			$_SESSION ['username'] = $account->name;
			$_SESSION['type'] = $account->type;
			$_SESSION['id'] = $account->id;
			session_commit();
			header ( "Location:./index.php" );
			exit ();
		}
	}else{
		$errorMsg = "登录失败，用户名或密码错误.";
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
				<link rel="stylesheet" type="text/css" href="./css/login_page.css">

</head>
<script type="text/javascript">
	function login(){
		var name = document.getElementById("username-box").value;
		var psd = document.getElementById("password-box").value;
		if(name == null || name == ''){
			alert("请输入用户名或者邮箱地址");
			return;
		}
		if(psd == null || psd == ''){
			alert("请输入密码");
			return;
		}
		var loginform = document.getElementById("loginform");
		loginform.submit();
	}
</script>
<body>
	<!-- HEADER -->
	<div id="header" class="navbar navbar-fixed-top">
		<div class="container-fluid ">
			<a class="brand" href="./index.php"> <span
				class="merchant-header-text"><?php echo WEBSITETITLE?></span>
			</a>
		</div>
	</div>
	<!-- END HEADER -->
	<!-- SUB HEADER NAV-->
	<!-- splash page subheader-->
	<form id="loginform" method="post" action="login.php?command=login">
		<div id="page-content" class="container-fluid  ">

			<div id="login-page-content" class="center">

				<div class="clearfix box">
					<div id="login-form">
						<div class="header">登录</div>
						<div class="inputs">
							<?php if($errorMsg != null)
							echo "<ul align=\"center\">".$errorMsg."</ul>";?>
							<div>
								<input value="" id="username-box" type="text" name="username"
									class="login-input input-block-level" required="true"
									placeholder="用户名/邮箱地址">
							
							</div>
							<div>
								<input id="password-box" type="password" name="password"
									class="login-input input-block-level" required="true"
									placeholder="密码">
							
							</div>
							<div class="clearfix control-group lst-elem">
								<div class="pull-left remember-me">
									<label class="checkbox"> <input checked="" id="remember-me"
										type="checkbox"> 记住我 </label>
								</div>
								<div class="pull-right">
									<a class="btn btn-link issue-link pull-right"
										href="reset.php">忘记密码了？</a>
								</div>
							</div>
							<button id="submit-button" type="button"
									 class="btn btn-large btn-primary btn-block btn-login" onclick="login()">登录</button>
						</div>
					</div>
					<div class="clearfix no-acct-footer">
						<div class="pull-left">还没有帐户？</div>
						<div class="pull-right">
							<a class="btn btn-link issue-link"
								href="register.php">注册</a>

						</div>
					</div>
				</div>
			</div>



		</div>
	</form>
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
</body>
</html>