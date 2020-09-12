<?php
ob_start(); // Ez azért kell, hogy a HTML ne a HTTP-be íródjon, hanem egy bufferbe
?>
    <h1>Kedves <?php echo $FORM->getNameValue(); ?>!</h1>
    <p>Köszönjük, hogy nálunk rendeltél. Az alábbi termékeket fogjuk szállítani:</p>
<?php
foreach($BASKET->getContent() as $item) {
    print ('
            <tr>
                <td class="name">'.$item["nev"].'</td>
                <td id="quantity" class="quantity">'.$item["darab"].'</td>
            </tr>
            <br>
            ');
}
if ($FORM->getNewsletterValue()=="on")  print('<p>Köszönjük, hogy feliratkozott a hírlevelünkre!</p>');
?>

    <p>Üdvözlettel:<br>A Webshop tulaja</p>
<?php
if ($FORM->getNewsletterValue()=="on")  print('    
    <br>
    <p>Amennyiben le szeretne iratkozni a hírlevelünkről, kattintson az alábbi linkre:</p>
    <br>
    <a href="https://beta.dev.itk.ppke.hu/webprog/~trira/unsubscribe.php?token='.$FORM->getToken().'">Leiratkozás</a>');

$MAIL_HTML = utf8_encode(ob_get_clean()); // Ezzel a buffer tartalmát a változóba tesszük, és töröljük a buffert
?>

