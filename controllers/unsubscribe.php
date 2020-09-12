<?php
require_once('../models/subscribers.php');
$subscribers=new subscribers();
if (isset($_GET['token'])) {
    $result=$subscribers->unsubscribe($_GET['token']);
    if ($result) die("Sikeres leiratkozás!");
}
die("Sikertelen leiratkozás");




