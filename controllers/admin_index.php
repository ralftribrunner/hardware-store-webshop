<?php
session_start();

require_once '../models/admin.php';


$PAGE='admin_orders';


if (isset($_POST['logout']) && isset($_SESSION['admin']) && $_SESSION['admin']==true ) {
    $_SESSION['admin']=false;

}
 $admin=new Admin("");


if (isset($_POST['username']) && (!isset($_SESSION['admin']) || $_SESSION['admin']==false  )) {
    $admin=new Admin($_POST['username']);
    if ($admin->auth($_POST['password'])) {
       $_SESSION['admin']=true;


    }
    else {
        $_SESSION['admin']=false;
    }
}

if (isset($_SESSION['admin']) && $_SESSION['admin']==true) {;
    $ORDERS=$admin->getOrders();
    include '../views/admin_header.php';
    include '../views/admin_orders.php';
}
else {
    include '../views/admin_login.php'; //admin sign-in platform
    include '../views/footer.php';      // This has no variable requirements

}