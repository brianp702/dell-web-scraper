<?php
/*
Using PHP, scrape the following values from this page, if they exist, store them in an array and output the array to the screen: 
	https://www.dell.com/en-us/shop/alienware-34-curved-gaming-monitor-aw3420dw/apd/210-atzq/monitors-monitor-accessories
Values:
	Product name (string)
	Manufacturer part number (string)
	Price (float)
	Cash back in rewards (int)
	Coupon code (string) (ignored because there aren't any coupon codes on the product pages)

/* 
  Dell.com product page scraper   
*/
$dellURLArray = [
	'https://www.dell.com/en-us/shop/alienware-34-curved-gaming-monitor-aw3420dw/apd/210-atzq/monitors-monitor-accessories',
	'https://www.dell.com/en-us/shop/accessories/apd/341-2939?c=us&l=en&s=dhs&cs=19&sku=341-2939',
	'https://www.dell.com/en-us/shop/alienware-wireless-gaming-headset-aw988/apd/520-aanp/audio'
];

$scrapeResultArray = [];

foreach ($dellURLArray as $item){
	$scrapeResultArray[$item] = [];
	$html = file_get_contents($item);
	$dellDOMDoc = new DOMDocument();
	libxml_use_internal_errors(true);

	if(!empty($html)){

		$dellDOMDoc->loadHTML($html);
		libxml_clear_errors();        
		$dellDOMXPath = new DOMXPath($dellDOMDoc);

		// product name
		$dellQuery = $dellDOMXPath->query('//*[@id="page-title"]/div[1]/div/h1/span');
		if($dellQuery->length > 0){
			foreach($dellQuery as $row){              
				$scrapeResultArray[$item]['ProductName'] = (string) trim($row->nodeValue);
			}
		}

		// part number
		$dellQuery = $dellDOMXPath->query("//*[contains(concat(' ', @class, ' '), ' ps-product-info ')]");
		if($dellQuery->length > 0){
			foreach($dellQuery as $row){
				preg_match('/Manufacturer part (.*?) \|/', $row->nodeValue, $matches);
				$scrapeResultArray[$item]['PartNumber'] = (string) $matches[1];	
			}
		}

		// price (float)
		$dellQuery = $dellDOMXPath->query("//*[contains(concat(' ', @class, ' '), ' ps-dell-price ')]");        
		if($dellQuery->length > 0){
			foreach($dellQuery as $row){
				$removeDollarSign = str_replace('$','',trim($row->nodeValue));
				$removeComma = str_replace(',','', $removeDollarSign);				
				$scrapeResultArray[$item]['Price'] = (float) $removeComma;
			}
		}

		// cash back in rewards (int)       
		$dellQuery = $dellDOMXPath->query("//*[contains(concat(' ', @class, ' '), ' ps-rewards-with-trophy-icon ')]");        
		if($dellQuery->length > 0){
			foreach($dellQuery as $row){
				preg_match('/Up to \$(.*?) back/', trim($row->nodeValue), $matches);
				$scrapeResultArray[$item]['CashBack'] = (int) $matches[1];
			}
		}
		
	} else {
		echo 'error connecting to product page';
	}
}

echo '<pre>';
print_r($scrapeResultArray);
echo '</pre>';

?>
