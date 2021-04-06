<?php
/* 
	given this StoreProduct class.....
*/
class StoreProduct 
{ 
	private $name; 
	private $model; 
	private $price; 

	public function __construct($name, $model, $price) 
	{ 
		$this->name = $name; 
		$this->model = $model; 
		$this->price = $price; 
	}

	public function getName()
	{ 
		return $this->name; 
	}

	public function getModel()
	{ 
		return $this->model; 
	}

	public function getPrice()
	{ 
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

/**
 * Dell.com web scraper
 */
class NewClass extends StoreProduct 
{
	// given a store's url
	private $url;

	/**
     * NewClass constructor.
     *
     * @param string $url String with the URL of a product page at Dell.com
	 * 
     */
	public function __construct($url)
	{

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

$dellURLArray = [
    'https://www.dell.com/en-us/shop/alienware-34-curved-gaming-monitor-aw3420dw/apd/210-atzq/monitors-monitor-accessories',
   'https://www.dell.com/en-us/shop/accessories/apd/341-2939?c=us&l=en&s=dhs&cs=19&sku=341-2939',
   'https://www.dell.com/en-us/shop/alienware-wireless-gaming-headset-aw988/apd/520-aanp/audio',
   'https://www.dell.com/en-us/shop/corsair-ml-series-ml120-pro-led-premium-magnetic-levitation-case-fan-120-mm-blue/apd/a9856981/pc-accessories?ref=p13n_ena_pdp_vv&c=us&cs=19&l=en&s=dhs',
   'https://www.dell.com/en-us/shop/dell-laptop-replacement-keyboard-english-refurbished/apd/7t425/pc-accessories?ref=p13n_ena_pdp_vv&c=us&cs=19&l=en&s=dhs',
   'https://www.dell.com/en-us/shop/alienware-25-gaming-monitor-aw2521hfl/apd/210-awdy/monitors-monitor-accessories?ref=p13n_ena_pdp_mv&c=us&cs=19&l=en&s=dhs',
   'https://www.dell.com/en-us/shop/dell-b2360d-b2360dn-s2830dn-b3460dn-b3465dn-b3465dnf-drum-u-r-60000-pg-yield-part-kvk63-sku-331-9811/apd/331-9811/printers-ink-toner?ref=p13n_ena_pdp_mv&c=us&cs=19&l=en&s=dhs',
   'https://www.dell.com/en-us/shop/enhance-voltaic-pro-headset-71-channel-full-size-wired-usb/apd/ab174786/audio',
   'https://www.dell.com/en-us/shop/dell-laptops/xps-13-laptop/spd/xps-13-9305-laptop/xn9305epfls', // laptops don't work with my scraper logic
   /*'https://deals.dell.com/en-us/productdetail/86wg',// can't scrape this subdomain with my code, the http request fails
   'https://deals.dell.com/en-us/productdetail/86ww',
   'https://deals.dell.com/en-us/productdetail/86yk',
   'https://deals.dell.com/en-us/productdetail/87cy',
   'https://deals.dell.com/en-us/productdetail/87cs',
   'https://deals.dell.com/en-us/productdetail/86y0',
   'https://deals.dell.com/en-us/productdetail/86y6',
   'https://deals.dell.com/en-us/productdetail/8704', 
   'https://deals.dell.com/en-us/productdetail/871c',*/
   'https://www.dell.com/en-us/shop/download-microsoft-win-home-10/apd/a8497306/software',
   'https://www.dell.com/en-us/shop/avg-tuneup-2020-5-devices-1-year-download/apd/aa791283/software'
];


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
 */

?>