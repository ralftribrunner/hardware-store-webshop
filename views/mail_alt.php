<?php
ob_start(); // Ez azért kell, hogy a HTML ne a HTTP-be íródjon, hanem egy bufferbe
?>
    Kedves <?php echo $FORM->getNameValue(); ?>!
    Köszönjük, hogy nálunk rendeltél. Az alábbi termékeket fogjuk szállítani:
<?php
include '../views/basket.php';
?>
    Üdvözlettel: A Webshop tulaja
<?php
$MAIL_HTML_ALT = ob_get_clean(); // Ezzel a buffer tartalmát a változóba tesszük, és töröljük a buffert
?>