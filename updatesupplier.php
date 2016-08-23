<?php
include_once dirname ( '__FILE__' ) . '/config.php';
include_once dirname ( '__FILE__' ) . '/business/BAccount.php';
include_once dirname ( '__FILE__' ) . '/business/BUser.php';
include_once dirname ( '__FILE__' ) . '/business/BLine.php';
include_once dirname ( '__FILE__' ) . '/model/Account.php';
include_once dirname ( '__FILE__' ) . '/model/User.php';
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

$baccount = new BAccount();
$bline = new BLine();
$lines = $bline->getUnAllocatedLines();

$supplierid = $_GET['sid'];
$supplier = $baccount->getSupplier($supplierid);

if(strcmp ( $command, "update" ) == 0){
	$username  = $_POST['username'];
	$email = $_POST ["email"];
	$password = $_POST ["password"];
	$realname = $_POST ["realname"];
	$officeaddress = $_POST ["officeaddress"];
	$officetel = $_POST ["officetel"];
	$officelicense = $_POST ["officelicense"];
	$qq = $_POST ["qq"];
	$lineids = $_POST['availablelines'];
	
	$supplierid = $_POST['sid'];
	$supplier = $baccount->getSupplier($supplierid);
	
	$user = $supplier->user;
	$user->accountid = $supplierid;
	$user->realname = $realname;
	$user->address = $officeaddress;
	$user->tel = $officetel;
	$user->businesslicenseurl = $officelicense;
	$user->qq = $qq;

	$addresult = $baccount->updateAccountInfo($supplier, $lineids);
	
	if($addresult){
		$msg = "修改批发商信息成功";
	}else{
		$msg = "修改批发商信息失败";
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
				<div class="signup-page-title">修改批发商信息</div>
				<div class="signup-page-content">
					<form class="form form-horizontal" id="registerform" method="post"
						action="updatesupplier.php?command=update">
						<input type="hidden" id="sid" name="sid" value="<?php echo $supplierid?>"/>
						<?php if($msg != null)
							echo "<ul align=\"center\"  style=\"color:#F00\">".$msg."</ul>";?>
						<div class="control-group">
							<label class="control-label" for="realname"><font color="#F00">* </font>真实姓名</label>
							<div class="controls input-append">
								<input type="text" id="realname" name="realname" class="input-block-level" value="<?php echo $supplier->user->realname?>"
									placeholder="请填写本人真实姓名"> <span class="add-on"><i
										class="icon-pencil"></i></span>
							
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="officeaddress"><font color="#F00">* </font>办公地点</label>
							<div class="controls input-append">
								<input type="text" id="officeaddress" name="officeaddress" class="input-block-level" value="<?php echo $supplier->user->address?>"
									placeholder="具体的门店地址"> <span class="add-on"><i
										class="icon-pencil"></i></span>
							
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="officetel"><font color="#F00">* </font>联系电话</label>
							<div class="controls input-append">
								<input type="text" id="officetel" name="officetel" class="input-block-level" value="<?php echo $supplier->user->tel?>"
									placeholder="联系电话或手机"> <span class="add-on"><i
										class="icon-pencil"></i></span>
							
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="qq"><font color="#F00">* </font>QQ</label>
							<div class="controls input-append">
								<input type="text" id="qq" name="qq" class="input-block-level" value="<?php echo $supplier->user->qq?>"
									placeholder="qq"> <span class="add-on"><i
										class="icon-pencil"></i></span>
							
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="officelicense"><font color="#F00">* </font>营业执照</label>
							<div class="controls input-append">
								<input class="input-block-level required" name="officelicense"
										id="officelicense" type="text" value="<?php echo $supplier->user->businesslicenseurl?>" 
										placeholder="上传营业执照图片" />
										<p/>
								<input type="file" name="file1" id="local_license_image"/>
							</div>
						</div>
						<div class="control-group" id="licenseview">
								<label class="control-label" data-col-index="1"><span
									class="col-name">预览</span></label>
								<div class="controls input-append">
									<img id="license_img_view" width=100 height=100 class="img-thumbnail" src="<?php echo $supplier->user->businesslicenseurl?>" alt="photos" />
								</div>
							</div>
							
						<div class="control-group">
							<label class="control-label"><font color="#F00">* </font>选择负责的专线:</label>
							<div  id="chooseline" class="controls input-append">
							
							<?php 
							
							if(count($lines)>0){
								foreach ($lines as $line){
									echo "<label class=\"checkbox\">";
									echo "<input id=\"availablelines\" name=\"availablelines[]\" type=\"checkbox\" value=\"".$line->id."\">";
									echo $line->name;
									echo "</label>";
								}
							}
							$currentLines = $supplier->lines;
							if(count($currentLines)>0){
								foreach ($currentLines as $curline){
									echo "<label class=\"checkbox\">";
									echo "<input id=\"availablelines\" name=\"availablelines[]\" type=\"checkbox\" checked value=\"".$curline->id."\">";
									echo $curline->name;
									echo "</label>";
								}
							}
							
							?>
							
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
	function licenseChange (){
		if($('#officelicense').val() != null && $('#officelicense').val() != ""){
			$('#licenseview').show();
			$('#license_img_view').attr("src",$('#officelicense').val());
	    }else{
	        $('#licenseview').hide();
	    }
	}

	$(document).ready(function(){
	    $('#officelicense').bind('input propertychange',function(){
	    	licenseChange();
	    });


	   $("#local_license_image").AjaxFileUpload({
			onComplete: function(filename, response) {
				switch(response['error']){
				case 0:
					$('#officelicense').val("http://www.wishconsole.com/images/" + response['name']);
					licenseChange();
					break;
				case -1:
					alert("不支持上传该类型的文件");
					break;
				case 1:
				case 2:
				case -2:
					alert("图片大小不能大于4M");
					break;
				case 3:
				case 4:
				case 5:
				case 6:	
				case -3:
				case -4:
				case -5:				
					alert("文件上传出错");
					break;
				}
			}
		});

		$("#signup-button").click(function(){
			if($.trim($('#realname').val()).length<1){
				alert("真实姓名不能为空");
				return;
			}

			if($.trim($('#officeaddress').val()).length<1){
				alert("办公地点不能为空");
				return;
			}

			if($.trim($('#qq').val()).length<1){
				alert("qq号码不能为空");
				return;
			}

			if($.trim($('#officetel').val()).length<1){
				alert("联系电话不能为空");
				return;
			}

			if($.trim($('#officelicense').val()).length<1){
				alert("营业执照不能为空");
				return;
			} 

			$('#registerform').submit();
		});
			

		
	});
</script>					
</body>
</html>