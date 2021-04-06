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
//$productURL = 'https://www.dell.com/en-us/shop/accessories/apd/341-2939?c=us&l=en&s=dhs&cs=19&sku=341-2939';
//$productURL = 'https://www.dell.com/en-us/shop/alienware-wireless-gaming-headset-aw988/apd/520-aanp/audio';

$DellStoreProduct = new DellProduct($productURL);

echo "<pre>";
print_r($DellStoreProduct);
echo "</pre>";

/* Output:
DellProduct Object
(
    [url:DellProduct:private] => https://www.dell.com/en-us/shop/alienware-34-curved-gaming-monitor-aw3420dw/apd/210-atzq/monitors-monitor-accessories
    [name:StoreProduct:private] => Alienware 34 Curved Gaming Monitor - AW3420DW
    [model:StoreProduct:private] => 7TJ7D
    [price:StoreProduct:private] => 1139.99
)
 */

 /* other product pages to test 
$dellURLArray = [
   'https://www.dell.com/en-us/shop/corsair-ml-series-ml120-pro-led-premium-magnetic-levitation-case-fan-120-mm-blue/apd/a9856981/pc-accessories?ref=p13n_ena_pdp_vv&c=us&cs=19&l=en&s=dhs',
   'https://www.dell.com/en-us/shop/dell-laptop-replacement-keyboard-english-refurbished/apd/7t425/pc-accessories?ref=p13n_ena_pdp_vv&c=us&cs=19&l=en&s=dhs',
   'https://www.dell.com/en-us/shop/alienware-25-gaming-monitor-aw2521hfl/apd/210-awdy/monitors-monitor-accessories?ref=p13n_ena_pdp_mv&c=us&cs=19&l=en&s=dhs',
   'https://www.dell.com/en-us/shop/dell-b2360d-b2360dn-s2830dn-b3460dn-b3465dn-b3465dnf-drum-u-r-60000-pg-yield-part-kvk63-sku-331-9811/apd/331-9811/printers-ink-toner?ref=p13n_ena_pdp_mv&c=us&cs=19&l=en&s=dhs',
   'https://www.dell.com/en-us/shop/enhance-voltaic-pro-headset-71-channel-full-size-wired-usb/apd/ab174786/audio',
   'https://www.dell.com/en-us/shop/dell-laptops/xps-13-laptop/spd/xps-13-9305-laptop/xn9305epfls', // laptop pages don't work
   'https://deals.dell.com/en-us/productdetail/86wg', // deals don't work, seems like the HTTP request is refused
   'https://deals.dell.com/en-us/productdetail/86ww',
   'https://deals.dell.com/en-us/productdetail/86yk',
   'https://www.dell.com/en-us/shop/download-microsoft-win-home-10/apd/a8497306/software',
   'https://www.dell.com/en-us/shop/avg-tuneup-2020-5-devices-1-year-download/apd/aa791283/software'
];
 */
 ?>