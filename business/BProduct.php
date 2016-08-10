<?php
include_once dirname ( '__FILE__' ) . '/./db/DBHelper.php';
include_once dirname ( '__FILE__' ) . '/./model/Product.php';
include_once dirname ( '__FILE__' ) . '/./model/ProductDate.php';
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
		while ($tempdate = mysql_fetch_array($pdates)){
			$productDate = new ProductDate();
			$productDate->productdate = $tempdate['productdate'];
			$productDate->productid = $tempdate['productid'];
			$productDate->inventory = $tempdate['inventory'];
			$productDate->total = $tempdate['total'];
			$dates[] = $productDate;
		}
		
		$product->productdates = $dates;
		return $product;
	}
}