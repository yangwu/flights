<?php
include_once dirname ( '__FILE__' ) . '/./db/DBHelper.php';
include_once dirname ( '__FILE__' ) . '/./model/Product.php';
include_once dirname ( '__FILE__' ) . '/./model/ProductDate.php';
include_once dirname ( '__FILE__' ) . '/./model/PurchaseInfo.php';
class BProduct {
	private $dbhelper;
	public function __construct() {
		$this->dbhelper = new DBHelper ();
	}
	public function addProduct($product) {
		$productid = $this->dbhelper->addProduct ( $product );
		
		$productdates = $product->productdates;
		$count = count($productdates);
		for($i=0;$i<$count;$i++){
			$tempdate = $productdates[$i];
			echo "<br/>tempdate:".$tempdate->productdate;
			$tempdate->productid = $productid;
			$this->addProductDate($productdates[$i]);
		}
		
		return $productid;
	}
	public function delProduct($productid){
		
	}
	
	public function updateProduct($product){
		$updateresult = $this->dbhelper->updateProduct($product);
		
		$this->dbhelper->delProductDate($product->id);
		$productdates = $product->productdates;
		$count = count($productdates);
		for($i=0;$i<$count;$i++){
			$tempdate = $productdates[$i];
			echo "<br/>tempdate:".$tempdate->productdate;
			$this->addProductDate($productdates[$i]);
		}
		return $updateresult;
	}
	
	public function addProductDate($productdate) {
		$result = $this->dbhelper->addProductDate ( $productdate );
		if ($result)
			return true;
		return false;
	}
	
	public function getLinePrducts($lineid){
		$result = $this->dbhelper->getLineProducts($lineid);
		$products = array();
		while($temp = mysql_fetch_array($result)){
			$product = new Product();
			$product->id = $temp['id'];
			$product->title = $temp['title'];
			$product->description = $temp['description'];
			$product->photourl = $temp['photourl'];
			$product->price = $temp['price'];
		    $product->childprice = $temp['childprice'];
		    $products[] = $product;
		}
		return $products;
	}
	
	public function getLineContactInfo($lineid){
		$result = $this->dbhelper->getLineContactInfo($lineid);
		if($result){
			if($contactinfo = mysql_fetch_array($result)){
				return $contactinfo;
			}	
		}
		return null;
	}
	
	public function getProductById($pid){
		$product = new Product();
		$presult = $this->dbhelper->getProduct($pid);
		if($temp = mysql_fetch_array($presult)){
			$product->id = $temp['id'];
			$product->title = $temp['title'];
			$product->description = $temp['description'];
			$product->photourl = $temp['photourl'];
			$product->price = $temp['price'];
			$product->childprice = $temp['childprice'];
		}
		
		$pdates = $this->dbhelper->getProductDate($pid);
		$dates = array();
		$datesvaluesmap = array();
		while ($tempdate = mysql_fetch_array($pdates)){
			$productDate = new ProductDate();
			$productDate->productdate = $tempdate['productdate'];
			$productDate->productid = $tempdate['productid'];
			$productDate->inventory = $tempdate['inventory'];
			$productDate->total = $tempdate['total'];
			$dates[] = $productDate;
			$datesvaluesmap[$tempdate['productdate']] = $tempdate['inventory']; 
		}
		
		$product->productdates = $dates;
		$product->productdatesvaluesmap = $datesvaluesmap;
		
		
		return $product;
	}
	
	public function isInventoryAvailable($productid,$productdate,$countpersons){
		$result = $this->dbhelper->getInventory($productid, $productdate, $countpersons);
		if($temp = mysql_fetch_array($result)){
			$inventory = $temp['inventory'];
			if($inventory >= $countpersons){
				return true;
			}
		}
		return false;
	}
	
	public function getProductOwnerId($productid){
		$result = $this->dbhelper->getProductOwnerId($productid);
		if($result){
			if($temp = mysql_fetch_array($result))
				return $temp['accountid'];
		}
		return null;
	}
	
	public function getorders($productid){
		$orders = array();
		$result = $this->dbhelper->getorders($productid);
		while($temporder = mysql_fetch_array($result)){
			$purchase = new PurchaseInfo();
			$purchase->accountid = $temporder['accountid'];
			$purchase->birthday = $temporder['birthday'];
			$purchase->cardnumber = $temporder['cardnumber'];
			$purchase->cardtype = $temporder['cardtype'];
			$purchase->cardvalidate = $temporder['cardvalidate'];
			$purchase->isadult = $temporder['isadult'];
			$purchase->productdate = $temporder['productdate'];
			$purchase->productid = $temporder['productid'];
			$purchase->realname = $temporder['realname'];
			$purchase->createtime = $temporder['createtime'];
			$orders[] = $purchase;
		}
		return $orders;
	}
}