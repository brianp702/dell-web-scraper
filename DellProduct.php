<?php
// TODO: does it make sense to use foreach for DOMDocument query results? We expect only 1 match
// TODO: am I doing scraping the best way?
// TODO: is this class structured correctly for OOP? variables at the top, variable in constructor
// Can I return StoreProduct object from this class?

/**
 * Dell.com product page scraper (en-us)
 * known issues: doesn't work for some product categories, such as laptops and "deals"
 */
class DellProduct extends StoreProduct 
{
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
		$this->url = $url;

		// TODO: handle getSiteContents() returning false
		$siteContents = $this->getSiteContents($url);
		$productPartNumber = $this->getProductPartNumber($siteContents);
		$productPrice = $this->getProductPrice($siteContents);
		$productName = $this->getProductName($siteContents);
		
		/* 
		The assignment says "create a new StoreProduct object using that data".
		As per var_dump(), this constructor results in a DellProduct object being returned, with StoreProduct items in it.
		If var_dump() is right, then I don't know how to return a StoreProduct data from within this class.
		However, this seems to accomplish the functionality of the assignment.
		*/
		parent::__construct($productName,$productPartNumber,$productPrice);
	}

	private function getSiteContents($productURL)
	{
		$html = file_get_contents($productURL);
		$dellDOMDoc = new DOMDocument();
		libxml_use_internal_errors(true);
	
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