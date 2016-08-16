<?php
include_once dirname ( '__FILE__' ) . '/config.php';
include_once dirname ( '__FILE__' ) . '/business/BAccount.php';
include_once dirname ( '__FILE__' ) . '/business/BUser.php';
include_once dirname ( '__FILE__' ) . '/business/BLine.php';
include_once dirname ( '__FILE__' ) . '/business/BProduct.php';
include_once dirname ( '__FILE__' ) . '/model/Product.php';
include_once dirname ( '__FILE__' ) . '/model/ProductDate.php';
include_once dirname ( '__FILE__' ) . '/model/Line.php';
include_once dirname ( '__FILE__' ) . '/model/Account.php';
include_once dirname ( '__FILE__' ) . '/model/User.php';
header ( "Content-Type: text/html;charset=utf-8" );

session_start ();
$currentusername =$_SESSION ['username'];
$type = $_SESSION['type'];
session_commit();

if ($currentusername == null) { // 未登录
	header ( "Location:./login.php?errorMsg=您尚未登录" );
	exit ();
}


$productid = $_POST['productid'];
$productname = $_POST['productname'];
$pdate = $_POST['pdate'];
$adultcount = $_POST['adultcount'];
$childcount = $_POST['childcount'];
if($childcount == null)
	$childcount = 0;
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
				<link href="./css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">

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
				<ul align="left"><?php echo $productname?></ul>
				<ul align="left">出游日期:<?php echo $pdate?></ul>
				<ul align="left">出游人数:成人 <?php echo $adultcount?>人;   儿童<?php echo $childcount?>人.</ul>
				<div class="signup-page-title">出游人信息录入</div>
				<div class="signup-page-content">
					<form class="form form-horizontal" id="registerform" method="post"
						action="orderconfirm.php">
						<input type="hidden" id="productid" name="productid" value="<?php echo $productid;?>"/>
						<input type="hidden" id="productdate" name="productdate" value="<?php echo $pdate;?>"/>
						<input type="hidden" id="adultcount" name="adultcount" value="<?php echo $adultcount;?>"/>
						<input type="hidden" id="childcount" name="childcount" value="<?php echo $childcount;?>"/>
						<?php if($msg != null)
							echo "<ul align=\"center\"  style=\"color:#F00\">".$msg."</ul>";?>
						
						
						<?php for($a=1;$a<$adultcount+1;$a++){
							
							echo "<div class=\"signup-page-title\" align=\"left\">第<font color=\"#F00\">&nbsp;&nbsp;".$a."&nbsp;&nbsp;</font>位成人</div>";
							echo "<div class=\"control-group\">";
							echo "<label class=\"control-label\" for=\"title\"><font color=\"#F00\">* </font>姓名</label>";
							echo "<div class=\"controls input-append\">";
							echo "<input type=\"text\" id=\"realname".$a."\" name=\"realname".$a."\" class=\"input-block-level\" value=\"\" placeholder=\"姓名\"> <span class=\"add-on\"><i class=\"icon-pencil\"></i></span>";
							echo "</div></div>";
								
							echo "<div class=\"control-group\">";
							echo "<label class=\"control-label\" for=\"title\"><font color=\"#F00\">* </font>出生日期</label>";
							echo "<div class=\"controls input-append\">";
							echo "<input class=\"input-block-level\" type=\"text\" value=\"1980-01-01\" name=\"adatetimepickerb".$a."\" id=\"adatetimepickerb".$a."\" data-date-format=\"yyyy-mm-dd\" placeholder=\"出生日期,可接受：2015-12-25\">";
							echo "</div></div>";
							
							echo "<div class=\"control-group\">";
							echo "<label class=\"control-label\" for=\"title\"><font color=\"#F00\">* </font>证件类型</label>";
							echo "<div class=\"controls input-append\">";
							echo "<select id=\"cardtype".$a."\" name=\"cardtype".$a."\" class=\"span6\">";
							echo "<option value=\"1\">身份证</option>";
							echo "<option value=\"2\">护照</option>";
							echo "<option value=\"3\">军官证</option>";
							echo "<option value=\"4\">港澳通行证</option>";
							echo "<option value=\"5\">台胞证</option>";
							echo "	</select></div></div>";
							
							echo "<div class=\"control-group\">";
							echo "<label class=\"control-label\" for=\"title\"><font color=\"#F00\">* </font>证件号码</label>";
							echo "<div class=\"controls input-append\">";
							echo "<input type=\"text\" id=\"cardnumber".$a."\" name=\"cardnumber".$a."\" class=\"input-block-level\" value=\"\" placeholder=\"证件号码\"> <span class=\"add-on\"><i class=\"icon-pencil\"></i></span>";
							echo "</div></div>";
							
							echo "<div class=\"control-group\">";
							echo "<label class=\"control-label\" for=\"title\"><font color=\"#F00\">* </font>证件有效期</label>";
							echo "<div class=\"controls input-append\">";
							echo "<input class=\"input-block-level\" type=\"text\" value=\"2016-12-20\" name=\"adatetimepickerv".$a."\" id=\"adatetimepickerv".$a."\" data-date-format=\"yyyy-mm-dd\" placeholder=\"证件有效日期,可接受：2015-12-25\">";
							echo "</div></div><br/>";
							
						}
						
						
						for($c=1;$c<$childcount+1;$c++){
								
							echo "<div class=\"signup-page-title\" align=\"left\">第<font color=\"#F00\">&nbsp;&nbsp;".$c."&nbsp;&nbsp;</font>位儿童</div>";
							echo "<div class=\"control-group\">";
							echo "<label class=\"control-label\" for=\"title\"><font color=\"#F00\">* </font>姓名</label>";
							echo "<div class=\"controls input-append\">";
							echo "<input type=\"text\" id=\"crealname".$c."\" name=\"crealname".$c."\" class=\"input-block-level\" value=\"\" placeholder=\"姓名\"> <span class=\"add-on\"><i class=\"icon-pencil\"></i></span>";
							echo "</div></div>";
						
							echo "<div class=\"control-group\">";
							echo "<label class=\"control-label\" for=\"title\"><font color=\"#F00\">* </font>出生日期</label>";
							echo "<div class=\"controls input-append\">";
							echo "<input class=\"input-block-level\" type=\"text\" value=\"1980-01-01\" name=\"cdatetimepickerb".$c."\" id=\"cdatetimepickerb".$c."\" data-date-format=\"yyyy-mm-dd\" placeholder=\"出生日期,可接受：2015-12-25\">";
							echo "</div></div><br/>";
						}
						
						?>
						
						
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
<script type="text/javascript" charset="utf-8" src="ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" src="./js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="./js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
<script type="text/javascript">

	$(document).ready(function(){

		var ac = "<?php echo $adultcount;?>";
		var cc = "<?php echo $childcount;?>";
		
	    for(var a=1;a<=ac;a++){
			var tempb = "adatetimepickerb" + a; 
	    	$('#' + tempb).datetimepicker({
		    	language: 'zh-CN',
		        weekStart: 1,
		        todayBtn:  1,
				autoclose: 1,
				todayHighlight: 1,
				startView: 2,
				forceParse: 0,
		        showMeridian: 1,
		        startView:"decade",
		        minView:"month"});

	    	var tempv = "adatetimepickerv" + a;
			$('#' + tempv).datetimepicker({
		    	language: 'zh-CN',
		        weekStart: 1,
		        todayBtn:  1,
				autoclose: 1,
				todayHighlight: 1,
				startView: 2,
				forceParse: 0,
		        showMeridian: 1,
		        startView:"decade",
		        minView:"month"});

	    	
		    }

	    for(var c=1;c<=cc;c++){
			var tempc = "cdatetimepickerb" + c; 
	    	$('#' + tempc).datetimepicker({
		    	language: 'zh-CN',
		        weekStart: 1,
		        todayBtn:  1,
				autoclose: 1,
				todayHighlight: 1,
				startView: 2,
				forceParse: 0,
		        showMeridian: 1,
		        startView:"decade",
		        minView:"month"});
		    }
	    
		$("#signup-button").click(function(){

			alert("adult:" + ac + ",child:" + cc);
			for(var s=1;s<=ac;s++){
				var tempname = "realname"+s;
				var tempcardnumber = "cardnumber" + s;
				alert("value of adult " +s + ": " + $('#'+tempname).val());
				if($.trim($('#'+tempname).val()).length<1){
					alert("姓名不可为空");
					return;
				}

				if($.trim($('#'+tempcardnumber).val()).length<1){
					alert("证件号码不可为空");
					return;
				}
			}

			for(var k=1;k<=cc;k++){
				var tempcname = "crealname" + k;
				var tempbdate = "cdatetimepickerb" + k;
				alert("value of child" +k + ": " + $('#'+tempcname).val());
				if($.trim($('#'+tempcname).val()).length<1){
					alert("姓名不可为空");
					return;
				}

				if($.trim($('#'+tempbdate).val()).length<1){
					alert("出生日期不可为空");
					return;
				}
			}
			
			
			
			$('#registerform').submit();
		});
	});
</script>					
</body>
</html>