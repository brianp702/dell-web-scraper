<?php

// test for DellProduct class
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
var_dump($instanceStoreProduct);
print_r($instanceStoreProduct);
echo "</pre>";

/* 
echo $instanceStoreProduct->getName() . '<br />';
echo $instanceStoreProduct->getModel() . '<br />';
echo $instanceStoreProduct->getPrice() . '<br />';
 */
/* 
DellProduct Object
(
    [url:DellProduct:private] => https://www.dell.com/en-us/shop/alienware-34-curved-gaming-monitor-aw3420dw/apd/210-atzq/monitors-monitor-accessories
    [name:StoreProduct:private] => Alienware 34 Curved Gaming Monitor - AW3420DW
    [model:StoreProduct:private] => 7TJ7D
    [price:StoreProduct:private] => 1139.99
)
 */

 ?>