<?php
include_once dirname ( '__FILE__' ) . '/config.php';
include_once dirname ( '__FILE__' ) . '/business/BAccount.php';
include_once dirname ( '__FILE__' ) . '/business/BUser.php';
include_once dirname ( '__FILE__' ) . '/model/Account.php';
include_once dirname ( '__FILE__' ) . '/model/User.php';
header ( "Content-Type: text/html;charset=utf-8" );

$type = $_GET['type'];
$msg = null;
if(strcmp ( $type, "register" ) == 0){
	$username  = $_POST['username'];
	$email = $_POST ["email"];
	$password = $_POST ["password"];
	$realname = $_POST ["realname"];
	$officeaddress = $_POST ["officeaddress"];
	$officetel = $_POST ["officetel"];
	$officelicense = $_POST ["officelicense"];
	$qq = $_POST ["qq"];

	$account = new Account();
	$account->name = $username;
	$account->email = $email;
	$account->psd = md5($password);
	$account->createtime = date('Ymd');

	$account->status = STATUS_APPROVED;
	$account->type = TYPE_HEADQUARTER;

	$baccount = new BAccount();
	$newaccountid = $baccount->addAccount($account);

	if($newaccountid>0){
		$msg = "注册成功";
	}else{
		$msg = "注册失败，添加账户信息失败";
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
			<a class="brand" href="https://wishconsole.com/"> <span
				class="merchant-header-text"><?php echo WEBSITETITLE?></span>
			</a>

		</div>
	</div>
	<!-- END HEADER -->
	<!-- SUB HEADER NAV-->
	<!-- splash page subheader-->

	<div id="page-content" class="container-fluid fixed-width ">

		<div id="signup-page-content">
			<div class="signup-page-container">
				<div class="signup-page-title">网站初始化，请设置超级管理员信息</div>
				<div class="signup-page-content">
					<form class="form form-horizontal" id="registerform" method="post"
						action="init.php?<?php echo "type=register"?>">
							<ul align="center"  style="color:#F00">***提交该页面，则会清空网站所有数据，恢复到最初始的状态，请谨慎操作***</ul>
						<div class="control-group">
							<label class="control-label" for="username"><font color="#F00">* </font>管理员用户名</label>
							<div class="controls input-append">
								<input type="text" id="username" name="username" class="input-block-level"
									placeholder="用户名由字母、数字、下划线组成，字母开头，4-16位"> <span class="add-on"><i class="icon-pencil"></i></span>
							
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="email_address"><font color="#F00">* </font>管理员邮箱地址</label>
							<div class="controls input-append">
								<input type="text" id="email" name="email" class="input-block-level"
									placeholder="示例：hello@example.com"> <span class="add-on"><i
										class="icon-pencil"></i></span>
							
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="password"><font color="#F00">* </font>管理员密码</label>
							<div class="controls input-append">
								<input type="password" id="password" name="password" class="input-block-level"
									placeholder="输入密码"> <span class="add-on"><i class="icon-pencil"></i></span>
							
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="confirm_password"><font color="#F00">* </font>确认密码</label>
							<div class="controls input-append">
								<input type="password" id="confirm_password" name="confirm_password"
									class="input-block-level" placeholder="请再次输入您的密码"> <span
									class="add-on"><i class="icon-pencil"></i></span>
							
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
			if($.trim($('#username').val()).length<1){
				alert("用户名不可为空");
				return;
			}

			if($.trim($('#email').val()).length<1){
				alert("邮箱地址不能为空");
				return;
			}

			if($.trim($('#password').val()).length<1){
				alert("密码不能为空");
				return;
			}

			if($.trim($('#confirm_password').val()).length<1){
				alert("请再次输入密码");
				return;
			}

			var namepattern = /^[a-zA-z]\w{3,15}$/;
			if(!namepattern.test($('#username').val())){
			    alert("用户名格式不正确，用户名由字母、数字、下划线组成，字母开头，4-16位");
				return;
			}    
			
			var emailpattern = /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;
			if(!emailpattern.test($('#email').val())){
		    	alert("邮箱格式不正确");
		    	return;
		    }

			if($('#password').val() != $('#confirm_password').val()){
				alert("两次输入的密码不一致，请重新输入");
				return;
			}

			if(window.confirm('你确定要初始化网站，清空所有数据吗？')){
            	$('#registerform').submit();
             }
			   
		
		});
			

		
	});
</script>					
</body>
</html>