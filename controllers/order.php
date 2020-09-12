<?php
require_once '../models/basket.php';
require_once '../models/orderform.php';
// Load PHPMailer
require '/opt/phpmailer/src/autoload.php';
/** @var PHPMailer\PHPMailer\PHPMailer $mail */


// Set the name of the current page
$PAGE = 'order';

// Start session
session_start();
if(!isset($_SESSION['basket'])) {
    $_SESSION['basket'] = [];
}

// Get the basket
$BASKET = new Basket($_SESSION['basket']);
$FORM   = new OrderForm($_POST);


// Check if the form is submitted
if($FORM->isSubmitted()) {

    // Try to validate
    $FORM->validate();

    // If the form is valid, save it!
    if($FORM->isValid()) {
        $SUCCESS = $FORM->save($BASKET);
        if($SUCCESS) {
            try {
                $mail->addAddress($FORM->getMailValue());
                $mail->Subject = 'Webshop rendelés';
                $mail->isHTML(true); // Set email format to HTML
                include('../views/mail_html.php'); /** @param string $MAIL_HTML */
                $mail->Body =utf8_encode($MAIL_HTML);
                include('../views/mail_alt.php'); /** @param string $MAIL_HTML_ALT */
                $mail->AltBody = utf8_encode($MAIL_HTML_ALT);
                $mail->send();
                $BASKET->deleteBasket();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }
}


// Do the rendering of the page
include '../views/header.php';      // This requires the $PAGE variable
include '../views/order.php';       // This requires $PROMO_PRODUCTS and $OTHER_PRODUCTS
include '../views/footer.php';      // This has no variable requirements
