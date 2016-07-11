<?php
include_once dirname ( '__FILE__' ) . '/./db/DBHelper.php';
include_once dirname ( '__FILE__' ) . '/./model/Product.php';
class BProduct {
	private $dbhelper;
	public function __construct() {
		$this->dbhelper = new DBHelper ();
	}
	public function addProduct($product) {
		return $this->dbhelper->addProduct ( $product );
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
			$product->title = $temp['title'];
			$product->description = $temp['description'];
			$product->photourl = $temp['photourl'];
			$product->price = $temp['price'];
		    $product->childprice = $temp['childprice'];
		    $products[] = $product;
		}
		return $products;
	}
}