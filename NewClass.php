<?php
/*
Please create an additional class that, 
given a store's url, will do the following: 
1.  Get the content for the page 
2.  Pull out the name, model, and price 
3.  Create a new StoreProduct object using that data 
4.  Return the StoreProduct Object 
*/
class NewClass extends StoreProduct {
	private $url;

	public function __construct($url){
		//$this->url = $url;

		$html = file_get_contents($url);
		$dell_doc = new DOMDocument();
		libxml_use_internal_errors(TRUE);
	
		if(!empty($html)){
	
			$dell_doc->loadHTML($html);
			libxml_clear_errors();        
			$dell_xpath = new DOMXPath($dell_doc);
	
			// product name
			$dell_row = $dell_xpath->query('//*[@id="page-title"]/div[1]/div/h1/span');        
			if($dell_row->length > 0){
				foreach($dell_row as $row){
					//$scrapeResultArray[$item]['ProductName'] = trim($row->nodeValue);
					$productName = trim($row->nodeValue);
					// (string)
				}
			}    
	
			// part number (model)
			$dell_row = $dell_xpath->query("//*[contains(concat(' ', @class, ' '), ' ps-product-info ')]");
			if($dell_row->length > 0){
				foreach($dell_row as $row){
					preg_match('/Manufacturer part (.*?) \|/', $row->nodeValue, $matches);
					// $scrapeResultArray[$item]['PartNumber'] = $matches[1];
					$productPartNumber = $matches[1];
					// (string)
				}
			}    
	
			// price (float)
			$dell_row = $dell_xpath->query("//*[contains(concat(' ', @class, ' '), ' ps-dell-price ')]");        
			if($dell_row->length > 0){
				foreach($dell_row as $row){
					// TODO: make it work for any currency format
					$removeDollarSign = str_replace('$','',trim($row->nodeValue));
					$removeComma = str_replace(',','', $removeDollarSign);
					//echo (float) $removeComma;
					//$scrapeResultArray[$item]['Price'] = $removeComma;
					$productPrice = $removeComma;
				}
			}

			$StoreProduct = new StoreProduct($productName,$productPartNumber,$productPrice);
			echo 'from NewClass.php: ' . $StoreProduct->getName() . '<br />';
			echo 'from NewClass.php: ' . $StoreProduct->getModel() . '<br />';
			echo 'from NewClass.php: ' . $StoreProduct->getPrice() . '<br />';            
			
			return $StoreProduct;
			
		} else {
			// no page retrieved
		}
		
	}
}
/*
create an additional class that, given a store's url, will do the following: 
1.  Get the content for the page 
2.  Pull out the name, model, and price 
3.  Create a new StoreProduct object using that data 
4.  Return the StoreProduct Object 
*/ 
?>