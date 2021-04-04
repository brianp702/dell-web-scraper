<?php
/* 
	given this StoreProduct class.....
*/
class StoreProduct { 
	private $name; 
	private $model; 
	private $price; 

	public function __construct($name, $model, $price) { 
		$this->name = $name; 
		$this->model = $model; 
		$this->price = $price; 
	}

	public function getName(){ 
		return $this->name; 
	}

	public function getModel(){ 
		return $this->model; 
	}

	public function getPrice(){ 
		return $this->price; 
	}
}


/*
goal:
create an additional class that, 
given a store's url, will do the following: 
1.  Get the content for the page 
2.  Pull out the name, model, and price 
3.  Create a new StoreProduct object using that data 
4.  Return the StoreProduct Object 
*/
class NewClass extends StoreProduct {
	// given a store's url
	private $url;

	public function __construct($url){

		// do web scraping to pull out the name, model, price....
		// results
		$productName = "Acer Ultrawide Monitor";
		$productPartNumber = "AUM 558";
		$productPrice = "699.95";

		// Create a new StoreProduct object using that data 
		//$StoreProduct = new StoreProduct($productName,$productPartNumber,$productPrice); 
		parent::__construct($productName,$productPartNumber,$productPrice);
	   
		// Return the StoreProduct Object 
		return $this;	
	}
}




$productURL = 'https://www.dell.com/en-us/shop/alienware-34-curved-gaming-monitor-aw3420dw/apd/210-atzq/monitors-monitor-accessories';

// NewClass returns StoreProduct object
$instanceStoreProduct = new NewClass($productURL);
echo "<pre>";
print_r($instanceStoreProduct);
echo "</pre>";
/* 
NewClass Object
(
	[url:NewClass:private] => 
	[name:StoreProduct:private] => Acer Ultrawide Monitor
	[model:StoreProduct:private] => AUM 558
	[price:StoreProduct:private] => 699.95
)
 */


$test = new StoreProduct('acer','bigfatwide monitor','1399.35');
echo "<pre>";
print_r($test);
echo "</pre>";
/* 
StoreProduct Object
(
	[name:StoreProduct:private] => acer
	[model:StoreProduct:private] => bigfatwide monitor
	[price:StoreProduct:private] => 1399.35
)
) 
 */

?>