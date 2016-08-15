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
							echo "<input class=\"input-block-level\" type=\"text\" value=\"1980-01-01\" id=\"adatetimepickerb".$a."\" data-date-format=\"yyyy-mm-dd\" placeholder=\"出生日期,可接受：2015-12-25\">";
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
							echo "<input class=\"input-block-level\" type=\"text\" value=\"2016-12-20\" id=\"adatetimepickerv".$a."\" data-date-format=\"yyyy-mm-dd\" placeholder=\"证件有效日期,可接受：2015-12-25\">";
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
							echo "<input class=\"input-block-level\" type=\"text\" value=\"1980-01-01\" id=\"cdatetimepickerb".$c."\" data-date-format=\"yyyy-mm-dd\" placeholder=\"出生日期,可接受：2015-12-25\">";
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
			//实例化编辑器
			//建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
			var ue = UE.getEditor('editor');

		    function isFocus(e){
		        alert(UE.getEditor('editor').isFocus());
		        UE.dom.domUtils.preventDefault(e)
		    }
		    function setblur(e){
		        UE.getEditor('editor').blur();
		        UE.dom.domUtils.preventDefault(e)
		    }
		    function insertHtml() {
		        var value = prompt('插入html代码', '');
		        UE.getEditor('editor').execCommand('insertHtml', value)
		    }
		    function createEditor() {
		        enableBtn();
		        UE.getEditor('editor');
		    }
		    function getAllHtml() {
		        alert(UE.getEditor('editor').getAllHtml())
		    }
		    function getContent() {
		        var arr = [];
		        arr.push("使用editor.getContent()方法可以获得编辑器的内容");
		        arr.push("内容为：");
		        arr.push(UE.getEditor('editor').getContent());
		        alert(arr.join("\n"));
		    }
		    function getPlainTxt() {
		        var arr = [];
		        arr.push("使用editor.getPlainTxt()方法可以获得编辑器的带格式的纯文本内容");
		        arr.push("内容为：");
		        arr.push(UE.getEditor('editor').getPlainTxt());
		        alert(arr.join('\n'))
		    }
		    function setContent(isAppendTo) {
		        var arr = [];
		        arr.push("使用editor.setContent('欢迎使用ueditor')方法可以设置编辑器的内容");
		        UE.getEditor('editor').setContent('欢迎使用ueditor', isAppendTo);
		        alert(arr.join("\n"));
		    }
		    function setDisabled() {
		        UE.getEditor('editor').setDisabled('fullscreen');
		        disableBtn("enable");
		    }

		    function setEnabled() {
		        UE.getEditor('editor').setEnabled();
		        enableBtn();
		    }

		    function getText() {
		        //当你点击按钮时编辑区域已经失去了焦点，如果直接用getText将不会得到内容，所以要在选回来，然后取得内容
		        var range = UE.getEditor('editor').selection.getRange();
		        range.select();
		        var txt = UE.getEditor('editor').selection.getText();
		        alert(txt)
		    }

		    function getContentTxt() {
		        var arr = [];
		        arr.push("使用editor.getContentTxt()方法可以获得编辑器的纯文本内容");
		        arr.push("编辑器的纯文本内容为：");
		        arr.push(UE.getEditor('editor').getContentTxt());
		        alert(arr.join("\n"));
		    }
		    function hasContent() {
		        var arr = [];
		        arr.push("使用editor.hasContents()方法判断编辑器里是否有内容");
		        arr.push("判断结果为：");
		        arr.push(UE.getEditor('editor').hasContents());
		        alert(arr.join("\n"));
		    }
		    function setFocus() {
		        UE.getEditor('editor').focus();
		    }
		    function deleteEditor() {
		        disableBtn();
		        UE.getEditor('editor').destroy();
		    }
		    function disableBtn(str) {
		        var div = document.getElementById('btns');
		        var btns = UE.dom.domUtils.getElementsByTagName(div, "button");
		        for (var i = 0, btn; btn = btns[i++];) {
		            if (btn.id == str) {
		                UE.dom.domUtils.removeAttributes(btn, ["disabled"]);
		            } else {
		                btn.setAttribute("disabled", "true");
		            }
		        }
		    }
		    function enableBtn() {
		        var div = document.getElementById('btns');
		        var btns = UE.dom.domUtils.getElementsByTagName(div, "button");
		        for (var i = 0, btn; btn = btns[i++];) {
		            UE.dom.domUtils.removeAttributes(btn, ["disabled"]);
		        }
		    }

		    function getLocalData () {
		        alert(UE.getEditor('editor').execCommand( "getlocaldata" ));
		    }

		    function clearLocalData () {
		        UE.getEditor('editor').execCommand( "clearlocaldata" );
		        alert("已清空草稿箱")
		    }

		    
	function thumbChange (){
		if($('#productthumb').val() != null && $('#productthumb').val() != ""){
			$('#productview').show();
			$('#product_img_view').attr("src",$('#productthumb').val());
	    }else{
	        $('#productview').hide();
	    }
	}

	$(document).ready(function(){

	    $('#productthumb').bind('input propertychange',function(){
	    	thumbChange();
	    });


	    for(var a=1;a<11;a++){
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

	    for(var c=1;c<11;c++){
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
	    
	   $("#product_image").AjaxFileUpload({
			onComplete: function(filename, response) {
				switch(response['error']){
				case 0:
					$('#productthumb').val("http://www.wishconsole.com/images/" + response['name']);
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
			if($.trim($('#title').val()).length<1){
				alert("标题不可为空");
				return;
			}

			if($.trim($('#productthumb').val()).length<1){
				alert("产品图片不可为空");
				return;
			}

			var linechoosed = $("#line option:selected").val();
			if($.trim(linechoosed).length<1){
				alert("请选择产品专线");
				return;
			}

			var adultprice = $('#adultprice').val();
			var childprice = $('#childprice').val();
			
			if($.trim(adultprice).length<1){
				alert("成人票价不可为空");
				return;
			}
			if($.trim(childprice).length<1){
				alert("儿童票价不可为空");
				return;
			}  
			if(isNaN(adultprice) || isNaN(childprice)){
				alert("票价只能是数字");
				return;
			} 

			var chooseddates = "";
			$("div#choosedate :checked").each(function(){
				chooseddates +=$(this).val() + "|";
			})
			if(chooseddates == ""){
				alert("请选择出行日期");
				return;
			} 

			var totalticket = $('#totalticket').val();
			if($.trim(totalticket).length<1){
				alert("机票总数不可为空");
				return;
			}  
			if(isNaN(totalticket)){
				alert("机票总数只能是数字");
				return;
			} 
				
			var description = UE.getEditor('editor').getContent();
			if($.trim(description).length<1){
				alert("行程描述不可为空");
				return;
			}else{
				} 
			$('#registerform').submit();
		});
	});
</script>					
</body>
</html>