
<?php

$route = $_GET['route'] ?? 'home'; //if $_GET['route'] exists, then $route=$_GET['route'], otherwise 'home'
$route = explode('/', $route);
/*
var_dump($route);
*/
$__SERVER_ROOT = '..';
$__CLIENT_ROOT = '/webprog/~trira';


if($route[0] == 'home') {
     require_once($__SERVER_ROOT.'/controllers/index.php');
} else if($route[0] == 'terms') {
     require_once($__SERVER_ROOT.'/controllers/terms.php');
} else if($route[0] == 'order') {
    require_once($__SERVER_ROOT.'/controllers/order.php');
}else if($route[0] == 'basket' && isset($route[1])) {
   if (isset($route[2])) {
       $PRODUCT_ID=$route[2];
       $BASKET_ACTION=null;

       if ($route[1] == 'add') {
            $BASKET_ACTION='ADD';
            require_once($__SERVER_ROOT.'/controllers/basket.php');
       }
       if ($route[1] == 'remove') {
           $BASKET_ACTION='REMOVE';
           require_once($__SERVER_ROOT.'/controllers/basket.php');
       }
       if ($route[1] == 'minus') {
           $BASKET_ACTION='MINUS';
           require_once($__SERVER_ROOT.'/controllers/basket.php');
       }

   }

} else if($route[0] == 'admin') {
    if ($route[1]=='orders' ) require_once($__SERVER_ROOT.'/controllers/admin_index.php');
    elseif ($route[1]=='products') {
        $PRODUCT_ID=null;
        if (isset($route[2]) && $route[2]=='new') {
            $NEW=true;
        }
        elseif (isset($route[2]) && $route[2]=='edit' && isset($route[3])) {
            $EDIT=true;
            $PRODUCT_ID=$route[3];
        }
        elseif (isset($route[2]) && $route[2]=='delete' && isset($route[3])) {
            $DELETE=true;
            $PRODUCT_ID=$route[3];
        }
        require_once($__SERVER_ROOT.'/controllers/admin_products.php');
    }
    else {
        require_once($__SERVER_ROOT.'/controllers/404.php');
    }
} else {
     require_once($__SERVER_ROOT.'/controllers/404.php');
}

?>

