<?php
require_once '../models/productlist.php';

// Set the name of the current page
$PAGE = 'index';

// Get list of promo products
$PROMO_PRODUCTS = new ProductList(true);
$OTHER_PRODUCTS = new ProductList(false);


// Do the rendering of the page
include '../views/header.php';      // This requires the $PAGE variable
include '../views/main.php';        // This requires $PROMO_PRODUCTS and $OTHER_PRODUCTS
include '../views/footer.php';      // This has no variable requirements
