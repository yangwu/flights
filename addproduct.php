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
$accountid = $_SESSION['id'];
session_commit();

if ($currentusername == null) { // 未登录
	header ( "Location:./login.php?errorMsg=您尚未登录" );
	exit ();
}

$bline = new BLine();
$lines = $bline->getAccountLines($accountid, $type);

$dates = array();
$firstDate = date('Y-m-d');
$dates[0] = $firstDate;
$tempDate = $firstDate;
for($k=1;$k<30;$k++){
	$nextDate = getNextDate($tempDate);
	$dates[$k] = $nextDate;
	$tempDate = $nextDate;
}

$command = $_GET['command'];
$msg = null;
if(strcmp ( $command, "addproduct" ) == 0){
	
	$title = $_POST['title'];
	$thumburl = $_POST['productthumb'];
	$line = $_POST['line'];
	$adultprice = $_POST['adultprice'];
	$childprice = $_POST['childprice'];
	$availabledates = $_POST['availabledate'];
	$totalticket = $_POST['totalticket'];
	$description = $_POST['editor'];
	
	$mapdates = array();
	foreach ( $_POST as $key => $value ) {
		if (preg_match ( "/^dateticket/", $key )) {
			$choosedate = explode ( "_", $key )[1];
			$mapdates[$choosedate] = $value;
		}
	}
	
	
	$bproduct = new BProduct();
	$product = new Product();
	$product->childprice = $childprice;
	$product->description = $description;
	$product->lineid = $line;
	$product->photourl = $thumburl;
	$product->price = $adultprice;
	$product->title = $title;
	
	$datecount = count($availabledates);
	$productdates = array();
	for($i=0;$i<$datecount;$i++){
		$curproductdate = new ProductDate();
		$curproductdate->productdate = $availabledates[$i];
		$curproductdate->total = $mapdates[$availabledates[$i]];
		$curproductdate->inventory = $mapdates[$availabledates[$i]];
		$productdates[] = $curproductdate;
	}
	
	$product->productdates = $productdates;
	
	$newproduct = $bproduct->addProduct($product);
	if($newproduct>0){
		$msg = "添加产品成功";
	}else{
		$msg = "添加产品失败";
	}
}

function getNextDate($curdate){
	return date('Y-m-d',strtotime('+1 day',strtotime($curdate)));
}

function getWeekofDate($curdate){
	$weekArr=array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");
	return $weekArr[date('w',strtotime($curdate))];
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
				<div class="signup-page-title">添加产品信息</div>
				<div class="signup-page-content">
					<form class="form form-horizontal" id="registerform" method="post"
						action="addproduct.php?command=addproduct">
						<?php if($msg != null)
							echo "<ul align=\"center\"  style=\"color:#F00\">".$msg."</ul>";?>
						<div class="control-group">
							<label class="control-label" for="title"><font color="#F00">* </font>产品标题</label>
							<div class="controls input-append">
								<input type="text" id="title" name="title" class="input-block-level" value="<?php echo $title?>"
									placeholder="产品标题"> <span class="add-on"><i class="icon-pencil"></i></span>
							
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="productthumb"><font color="#F00">* </font>产品图片</label>
							<div class="controls input-append">
								<input class="input-block-level required" name="productthumb"
										id="productthumb" type="text" value="<?php echo $thumburl?>"
										placeholder="产品图片" />
										<p/>
								<input type="file" name="file1" id="product_image" />
							</div>
						</div>
						<div class="control-group" style="display: none;" id="productview">
								<label class="control-label" data-col-index="1"><span
									class="col-name">预览</span></label>
								<div class="controls input-append">
									<img id="product_img_view" width=100 height=100 class="img-thumbnail" src="" alt="photos" />
								</div>
							</div>
						<div class="control-group">
							<label class="control-label" for="line"><font color="#F00">* </font>所属专线</label>
							 <div class="controls">
							 <?php 
							 echo " <select id=\"line\" name=\"line\" class=\"span6\">";
							 echo "<option value=\"\" selected=\"selected\">";
                             echo " 	选择专线";
                             echo "</option>";
							 if(count($lines)>0){
							 	foreach ($lines as $line){
							 		echo "<li>".$line->name."</li>";
							 		echo "<option value=\"".$line->id."\">".$line->name."</option>";
							 	}
							 }
							 echo "</select>";
							 ?>
                            </div>
						</div>
						<div class="control-group">
							<label class="control-label" for="password"><font color="#F00">* </font>成人票价</label>
							<div class="controls input-append">
								<input type="text" id="adultprice" name="adultprice" class="input-block-level"
									placeholder=" " value="<?php echo $adultprice?>"> <span class="add-on"><i class="icon-pencil"></i></span>
							
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="confirm_password"><font color="#F00">* </font>儿童票价</label>
							<div class="controls input-append">
								<input type="text" id="childprice" name="childprice"
									class="input-block-level" placeholder=" " value="<?php echo $childprice?>"> <span
									class="add-on"><i class="icon-pencil"></i></span>
							
							</div>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="officetel"><font color="#F00">* </font>机票总数</label>
							<div class="controls input-append">
								<input type="text" id="totalticket" name="totalticket" class="input-block-level" value="<?php echo $totalticket?>"
									placeholder="每天可售机票总数"> <span class="add-on"><i
										class="icon-pencil"></i></span>
							
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="availabledate"><font color="#F00">* </font>出行日期</label>
							<div id="choosedate" class="controls input-append">
							<?php 
							$count = count($dates);
							for($i=0;$i<$count;$i++){
								echo "<label class=\"checkbox\">";
								echo "<input id=\"availabledate\" name=\"availabledate[]\" type=\"checkbox\" value=\"".$dates[$i]."\">";
								echo $dates[$i]."&nbsp;&nbsp;".getWeekofDate($dates[$i]);
								echo "&nbsp;&nbsp;&nbsp;&nbsp;机票总数:";
								echo "<input type=\"text\" id=\"dateticket_".$dates[$i]."\"  name=\"dateticket_".$dates[$i]."\"  class=\"input-block-level\" value=\"\" placeholder=\"每天可售机票总数\">";
								echo "</label>";
							}
							?>
							
							</div>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="realname"><font color="#F00">* </font>行程描述</label>
							<h6>&nbsp;&nbsp;&nbsp;&nbsp;</h6>
							<script id="editor" name="editor" type="text/plain" style="width:800px;height:500px;" ></script>
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
<script type="text/javascript" charset="utf-8" src="ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="lang/zh-cn/zh-cn.js"></script>
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

	function setticketsvalue(ticketvalue){
		var a=$('input[id^="dateticket"]').map(function(){return {value:this.value,id:this.id}}).get();
		for(var i=0;i<a.length;i++){
			$('#'+ a[i].id).val(ticketvalue);
		}
	}

	$(document).ready(function(){

	    $('#productthumb').bind('input propertychange',function(){
	    	thumbChange();
	    });

	    $('#totalticket').bind('input propertychange',function(){
	    	setticketsvalue(this.value);
		});

	   $("#product_image").AjaxFileUpload({
			onComplete: function(filename, response) {
				switch(response['error']){
				case 0:
					$('#productthumb').val("http://www.wishconsole.com/images/" + response['name']);
					thumbChange();
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