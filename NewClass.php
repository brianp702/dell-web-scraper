<?php

/**
 * Dell.com web scraper
 * known issues: doesn't work for laptops or "deals"
 */
class NewClass extends StoreProduct 
{
	private $url;

	/**
     * NewClass constructor.
     *
     * @param string $url String with the URL of a product page at Dell.com
	 * 
     */
	public function __construct($url)
	{
		// TODO ???????????
        // TODO ?? $this->url = $url;

		$html = file_get_contents($url);
		$dell_doc = new DOMDocument();
		libxml_use_internal_errors(TRUE);
	
		if(!empty($html)){
	
			$dell_doc->loadHTML($html);
			libxml_clear_errors();        
			$dell_xpath = new DOMXPath($dell_doc);
	
            // TODO put in a method
			// product name
			$dell_row = $dell_xpath->query('//*[@id="page-title"]/div[1]/div/h1/span');        
			if($dell_row->length > 0){
				foreach($dell_row as $row){
					$productName = trim($row->nodeValue);
					// TODO (string)
				}
			}    
            
            // TODO put in a method
			// part number (model)
			$dell_row = $dell_xpath->query("//*[contains(concat(' ', @class, ' '), ' ps-product-info ')]");
			if($dell_row->length > 0){
				foreach($dell_row as $row){
					preg_match('/Manufacturer part (.*?) \|/', $row->nodeValue, $matches);
					$productPartNumber = $matches[1];
					// TODO (string)
				}
			}    
            
            // TODO put in a method
			// price (float)
			$dell_row = $dell_xpath->query("//*[contains(concat(' ', @class, ' '), ' ps-dell-price ')]");        
			if($dell_row->length > 0){
				foreach($dell_row as $row){
					// TODO: make it work for any currency format
					$removeDollarSign = str_replace('$','',trim($row->nodeValue));
					$removeComma = str_replace(',','', $removeDollarSign);
					// TODO (float)
					$productPrice = $removeComma;
				}
			}

			$StoreProductInstance = new StoreProduct($productName,$productPartNumber,$productPrice);
			echo 'from NewClass.php: ' . $StoreProductInstance->getName() . '<br />';
			echo 'from NewClass.php: ' . $StoreProductInstance->getModel() . '<br />';
			echo 'from NewClass.php: ' . $StoreProductInstance->getPrice() . '<br />';            
			
			// Create a new StoreProduct object using the scraped data
            parent::__construct($productName,$productPartNumber,$productPrice);
        
            // Return the StoreProduct Object 
            return $this;	
			
		} else {
			// TODO no page retrieved
		}
		
	}
}

?>