<?php
// TODO : fix all variable names, classname, etc

/**
 * Dell.com web scraper
 * known issues: doesn't work for laptops or "deals"
 */
class NewClass extends StoreProduct 
{
	private $url;
	//private $siteContents;
	//private $productPartNumber;
	//private $productPrice;
	//private $productName;

	/**
	 * NewClass constructor.
	 *
	 * @param string $url String with the URL of a product page at Dell.com
	 * 
	 * @return StoreProduct
	 */
	public function __construct($url)
	{
		
		$siteContents = $this->getSiteContents($url);
		$productPartNumber = $this->getProductPartNumber($siteContents);
		$productPrice = $this->getProductPrice($siteContents);
		$productName = $this->getProductName($siteContents);

		$StoreProductInstance = new StoreProduct($productName,$productPartNumber,$productPrice);          
		
		// Create a new StoreProduct object using the scraped data
		parent::__construct($productName,$productPartNumber,$productPrice);
	
		// Return StoreProduct Object 
		return $this;
	}

	private function getSiteContents($url)
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
			return $dell_xpath;
		} else {
			// TODO no page retrieved
		}
	}
	
	private function getProductName($DOMDocument)
	{
		// product name
		$dell_row = $DOMDocument->query('//*[@id="page-title"]/div[1]/div/h1/span');        
		if($dell_row->length > 0){
			// TODO: don't loop, because there is only 1 result
			foreach($dell_row as $row){
				$productName = trim($row->nodeValue);
				return $productName;
				// TODO (string)
			}
		} 
	}
	
	private function getProductPartNumber($DOMDocument)
	{
		// part number (model)
		$dell_row = $DOMDocument->query("//*[contains(concat(' ', @class, ' '), ' ps-product-info ')]");
		if($dell_row->length > 0){
			// TODO: don't loop, because there is only 1 result
			foreach($dell_row as $row){
				preg_match('/Manufacturer part (.*?) \|/', $row->nodeValue, $matches);
				$productPartNumber = $matches[1];
				return $productPartNumber;
				// TODO (string)
			}
		}  
	}
	
	private function getProductPrice($DOMDocument)
	{
		// TODO put in a method
		$dell_row = $DOMDocument->query("//*[contains(concat(' ', @class, ' '), ' ps-dell-price ')]");        
		if($dell_row->length > 0){
			// TODO: don't loop, because there is only 1 result
			foreach($dell_row as $row){
				// TODO: make it work for any currency format
				$removeDollarSign = str_replace('$','',trim($row->nodeValue));
				$removeComma = str_replace(',','', $removeDollarSign);
				$productPrice = $removeComma;
				return $productPrice;
				// TODO (float)
			}
		}		
	}
}

?>