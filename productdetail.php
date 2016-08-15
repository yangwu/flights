<?php
include_once dirname ( '__FILE__' ) . '/config.php';
include_once dirname ( '__FILE__' ) . '/business/BProduct.php';

header ( "Content-Type: text/html;charset=utf-8" );

session_start ();
$currentusername =$_SESSION ['username'];
$type = $_SESSION['type'];
session_commit();

if ($currentusername == null) { // 未登录
	header ( "Location:./login.php?errorMsg=您尚未登录" );
	exit ();
}


$pid = $_GET['id'];
if(isset($pid)){
	$bp = new BProduct();
	$product = $bp->getProductById($pid);
	$productdates = $product->productdates;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title><?php echo WEBSITETITLE?></title>
			<link rel="stylesheet" type="text/css"
					href="./css/new_signup_page.css">
			<link href="./css/bootstrap.min.css" rel="stylesheet">
				<script src="./js/jquery-2.2.0.min.js"></script>
				<script src="./js/bootstrap.min.js"></script>

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
	<div class="container">
<form class="form form-horizontal" id="registerform" method="post"
						action="orderdetail.php">
		<input type="hidden" name="productid" id="productid" value="<?php echo $pid;?>"/>
		<input type="hidden" name="productname" id="productname" value="<?php echo $product->title?>"/>
		<h1><?php echo $product->title?></h1>

		<div class="row">

			<div class="col-md-6"
				style="background-color: #dedef8; box-shadow: inset 1px -1px 1px #444, inset -1px 1px 1px #444;">
				<img src="<?php echo $product->photourl?>" alt="" />
			</div>
			<div class="col-md-6"
				style="background-color: #dedef8; box-shadow: inset 1px -1px 1px #444, inset -1px 1px 1px #444;">
				<h4>成人票价:<?php echo $product->price?></h4>
				<h4>儿童票价:<?php echo $product->childprice?></h4>
				<label class="control-label" for="line"><font color="#F00">* </font>出游日期:</label>
							 <div class="controls">
							 <?php 
							 echo " <select id=\"pdate\" name=\"pdate\" class=\"span6\">";
							 echo "<option value=\"\" selected=\"selected\">";
                             echo "请选择出游日期";
                             echo "</option>";
                             $count = count($productdates);
							 if($count>0){
							 	for($i=0;$i<$count;$i++){
							 		$tempdate = $productdates[$i];
							 		echo "<li>".$tempdate->productdate."</li>";
							 		echo "<option value=\"".$tempdate->productdate."\">".$tempdate->productdate."(剩余票数:".$tempdate->inventory.")"."</option>";
							 	}
							 }
							 echo "</select>";
							 ?>
                            </div>
				<label class="control-label" for="officetel"><font color="#F00">* </font>出游人数:</label>
				<div>成人:<input id="adultcount" name="adultcount" type="number" min="0" max="10"/>
				<br/>儿童:<input id="childcount" name="childcount" type="number" min="0" max="10"/>
				</div>
				<div id="create-store-container">
							<input type="button" id="signup-button"
								class="input-block-level flat-signup-btn"
								value="立即预订">
						</div>
			</div>
		</div>

		<dir class="row-fluid widget">
			<div class="widget-header">
			<div class="title"><h4>产品描述</h4></div></div>
			<div class="widget-body"><?php echo $product->description?></div>
		</dir>
		</form>
	</div>
	<script type="text/javascript">
	$("#signup-button").click(function(){

		var datechoosed = $("#pdate option:selected").val();
		if($.trim(datechoosed).length<1){
			alert("请选择出游日期");
			return;
		}

		if($.trim($('#adultcount').val()) == 0){
			alert("至少需要一位成人出游");
			return;
		}

		$('#registerform').submit();
		});
	</script>
</body>
</html>