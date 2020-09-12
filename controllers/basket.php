<?php

/**
 * @var $PRODUCT_ID
 * @var $__CLIENT_ROOT
 * @var $BASKET_ACTION
 */



require_once '../models/product.php';
require_once '../models/basket.php';
// Process user input
if(!isset($PRODUCT_ID) || ($BASKET_ACTION!='ADD' && $BASKET_ACTION!='REMOVE' && $BASKET_ACTION!='MINUS')) {
   print ("No product found, or incorrect basket action");
}

// Get product id
$id = intval($PRODUCT_ID);
$product = Product::find($id);

if(is_null($product)) {
   print ("No product found");
}

// Start session
session_start();
if(!isset($_SESSION['basket'])) {
    $_SESSION['basket'] = [];
}

// Create the basket
$BASKET = new Basket($_SESSION['basket']);
if ($BASKET_ACTION=='ADD') {
    print ($BASKET->add($product));

}
elseif ($BASKET_ACTION=='REMOVE') {
    print($BASKET->remove($product));

}
elseif ($BASKET_ACTION=='MINUS') {
    print($BASKET->minus($product));
} else print "Unexpected error";



