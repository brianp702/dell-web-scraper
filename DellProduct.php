<?php
// TODO: does it make sense to use foreach for DOMDocument query results? We expect only 1 match

/**
 * Dell.com product page scraper (en-us)
 * known issues: doesn't work for some product categories, such as laptops and "deals"
 */
class DellProduct extends StoreProduct 
{
    // TODO: does constructor argument always go here also?
	private $url;

	/**
	 * DellProduct constructor.
	 *
	 * @param string $url String with the URL of a product page at Dell.com
	 * 
	 * @return StoreProduct
	 */
	public function __construct($url)
	{		
        // TODO: any benefit to setting the url?
        // $this->url = $url;

		// TODO: handle getSiteContents() returning false
		$siteContents = $this->getSiteContents($url);
		$productPartNumber = $this->getProductPartNumber($siteContents);
		$productPrice = $this->getProductPrice($siteContents);
		$productName = $this->getProductName($siteContents);
		
		// Create a new StoreProduct object using the scraped data, return it
		return parent::__construct($productName,$productPartNumber,$productPrice);
		
		// Return StoreProduct object 
		//return $this;
        // TODO is this returning a StoreProduct object? How to do that?
	}

	private function getSiteContents($productURL)
	{
		$html = file_get_contents($productURL);
		$dellDOMDoc = new DOMDocument();
		libxml_use_internal_errors(TRUE);
	
		if(!empty($html)){	
			$dellDOMDoc->loadHTML($html);
			libxml_clear_errors();        
			$dellDOMXPath = new DOMXPath($dellDOMDoc);
			return $dellDOMXPath;
		} else {
			return false;
		}
	}
	
	private function getProductName($DOMDocument)
	{
		$dellQuery = $DOMDocument->query('//*[@id="page-title"]/div[1]/div/h1/span');
		if($dellQuery->length > 0){
			foreach($dellQuery as $row){
				$productName = trim($row->nodeValue);
				return (string) $productName;
			}
		} 
	}
	
	private function getProductPartNumber($DOMDocument)
	{
		$dellQuery = $DOMDocument->query("//*[contains(concat(' ', @class, ' '), ' ps-product-info ')]");
		if($dellQuery->length > 0){
			foreach($dellQuery as $row){
				preg_match('/Manufacturer part (.*?) \|/', $row->nodeValue, $matches);
				$productPartNumber = $matches[1];
				return (string) $productPartNumber;
			}
		}  
	}
	
	private function getProductPrice($DOMDocument)
	{
		$dellQuery = $DOMDocument->query("//*[contains(concat(' ', @class, ' '), ' ps-dell-price ')]");        
		if($dellQuery->length > 0){
			foreach($dellQuery as $row){
				$removeDollarSign = str_replace('$','',trim($row->nodeValue));
				$productPrice = str_replace(',','', $removeDollarSign);
				return (float) $productPrice;
			}
		}		
	}
}

?>