<?php
require_once '../models/productlist.php';
require_once '../models/product.php';
require_once '../models/ProductForm.php';
session_start();

/**
 * @var $NEW
 * @var $EDIT
 * @var $PRODUCT_ID
 */

$PAGE='admin_products';

if (!isset($_SESSION['admin']) || $_SESSION['admin']==false) header('Location: orders');

if (isset($_POST['fsave'])) {
    $PROD=Product::find($PRODUCT_ID);

    if ($PROD){
        $PRODUCTFORM=$PROD;
    }
    else {

        $PRODUCTFORM=new ProductForm($PRODUCT_ID,$_POST);
    }

   $PRODUCTFORM->save();
   unset($_POST['save']);
   unset($EDIT);
   unset($NEW);
}

if (isset($_POST['fdel'])) {

    $PRODUCTFORM=new ProductForm($PRODUCT_ID,$_POST);
    $PRODUCTFORM->delete();
    unset($_POST['fdel']);
    unset($DELETE);
}
if (isset($_POST['fnotdel'])) {

    unset($DELETE);
}


$PRODUCTLIST=new ProductList();
$PRODUCTLIST2=new ProductList(true);
$PRODUCTS=array_merge($PRODUCTLIST->getProducts(),$PRODUCTLIST2->getProducts());

include '../views/admin_header.php';
include '../views/admin_products.php';

if(isset($NEW)&&$NEW==true) {
    $PRODUCTFORM=ProductForm::new();

    include '../views/admin_form.php';
}
elseif (isset($EDIT) && $EDIT==true && isset($PRODUCT_ID)) {
    $PRODUCTFORM=ProductForm::find($PRODUCT_ID);

    include '../views/admin_form.php';
}
elseif (isset($DELETE) && $DELETE==true && isset($PRODUCT_ID)) {
    if ($PRODUCTFORM=ProductForm::find($PRODUCT_ID))
    include '../views/admin_deleteform.php';
    else {
        echo "nothing found";
    }
}