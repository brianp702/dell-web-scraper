<?php

 /* 
create an additional class that, given a store's url, will do the following: 
1.  Get the content for the page 
2.  Pull out the name, model, and price 
3.  Create a new StoreProduct object using that data 
4.  Return the StoreProduct Object 
*/ 

require 'StoreProduct.php';
require 'DellProduct.php';

$productURL = 'https://www.dell.com/en-us/shop/alienware-34-curved-gaming-monitor-aw3420dw/apd/210-atzq/monitors-monitor-accessories';

// DellProduct returns StoreProduct object
$instanceStoreProduct = new DellProduct($productURL);

echo "<pre>";
print_r($instanceStoreProduct);
echo "</pre>";

echo $instanceStoreProduct->getName() . '<br />';
echo $instanceStoreProduct->getModel() . '<br />';
echo $instanceStoreProduct->getPrice() . '<br />';

/* 
DellProduct Object
(
    [url:DellProduct:private] => https://www.dell.com/en-us/shop/alienware-34-curved-gaming-monitor-aw3420dw/apd/210-atzq/monitors-monitor-accessories
    [name:StoreProduct:private] => Alienware 34 Curved Gaming Monitor - AW3420DW
    [model:StoreProduct:private] => 7TJ7D
    [price:StoreProduct:private] => 1139.99
)
 */



exit;






/*
Using PHP, scrape the following values from this page, if they exist, store them in an array and output the array to the screen: 
	https://www.dell.com/en-us/shop/alienware-34-curved-gaming-monitor-aw3420dw/apd/210-atzq/monitors-monitor-accessories
Values:
	Product name (string)
	Manufacturer part number (string)
	Price (float)
	Cash back in rewards (int)
	Coupon code (string)

/* 
  Dell.com product page scraper   
*/
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

//$html = file_get_contents($dellURL[0]);
//$html = file_get_contents($dellURL[2]);

$scrapeResultArray = [];
foreach ($dellURLArray as $item){
	$scrapeResultArray[$item] = [];

	//pre_r($item);

	$html = file_get_contents($item);
	$dell_doc = new DOMDocument();
	libxml_use_internal_errors(TRUE);

	if(!empty($html)){

		$dell_doc->loadHTML($html);
		libxml_clear_errors();        
		$dell_xpath = new DOMXPath($dell_doc);

		// product name
		$dell_row = $dell_xpath->query('//*[@id="page-title"]/div[1]/div/h1/span');        
		//echo 'product name: <strong>';
		if($dell_row->length > 0){
			foreach($dell_row as $row){
			   // echo trim($row->nodeValue);                
				$scrapeResultArray[$item]['ProductName'] = trim($row->nodeValue);
				// TODO (string)
			}
		} else {
		   // echo 'BUZZER';
		}
	   // echo '</strong><br />';
		// ===============================



		// part number
		$dell_row = $dell_xpath->query("//*[contains(concat(' ', @class, ' '), ' ps-product-info ')]");
		//echo 'part number: <strong>';
		if($dell_row->length > 0){
			foreach($dell_row as $row){
				preg_match('/Manufacturer part (.*?) \|/', $row->nodeValue, $matches);
				//echo trim($matches[1]);
				$scrapeResultArray[$item]['PartNumber'] = $matches[1];
				//TODO (string)
			}
		} else {
		   // echo 'BUZZER';
		}
		//echo '</strong><br />';
		// ===============================



		// price (float)
		$dell_row = $dell_xpath->query("//*[contains(concat(' ', @class, ' '), ' ps-dell-price ')]");        
		//echo 'price: <strong>';
		if($dell_row->length > 0){
			foreach($dell_row as $row){
				// TODO: make it work for any currency format
				$removeDollarSign = str_replace('$','',trim($row->nodeValue));
				$removeComma = str_replace(',','', $removeDollarSign);
				//TODO (float)
				$scrapeResultArray[$item]['Price'] = $removeComma;
			}
		} else {
			//echo 'BUZZER';
		}
		//echo '</strong><br />';
		// ===============================



		// cash back in rewards (int)       
		$dell_row = $dell_xpath->query("//*[contains(concat(' ', @class, ' '), ' ps-rewards-with-trophy-icon ')]");        
		//echo 'cash back: <strong>';
		if($dell_row->length > 0){
			foreach($dell_row as $row){
				//echo trim($row->nodeValue);
				preg_match('/Up to \$(.*?) back/', trim($row->nodeValue), $matches);
				//TODO (int) $matches[1];
				$scrapeResultArray[$item]['CashBack'] = $matches[1];
				// (int)
			}
		} else {
		   // echo 'BUZZER';
		}
		//echo '</strong><br />';
		// ===============================



		// TODO coupon codes (string)
		// can't find any mention of coupon codes on these product pages
		$scrapeResultArray[$item]['CouponCode'] = '';
	   /*  $dell_row = $dell_xpath->query('');
		
		echo 'coupon codes: <strong>';
		if($dell_row->length > 0){
			foreach($dell_row as $row){
				echo trim($row->nodeValue);
				// (string)
			}
		} else {
			echo 'BUZZER';
		}
		echo '</strong><br />'; */
		// ===============================

		
	} else {
		//echo "broke";
	}
	//echo '<hr /><br />';
}
pre_r($scrapeResultArray);
?>