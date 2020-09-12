<?php
/**
 * @var ProductForm $PRODUCTFORM
 *
 */

$NAME=$PRODUCTFORM->getName() ?? '';
$PRICE= $PRODUCTFORM->getPrice() ?? '';
$IN_PROMO=$PRODUCTFORM->isInPromo() ? 'checked' :'';
$DESCRIPTION=$PRODUCTFORM->getDescription()??'';

?>

<br><br>
<form method="POST">
  <label for="fname">Name:</label>
  <input type="text" id="fname" name="fname" size="30" value="<?php print($NAME);?>"><br><br>
  <label for="fprice">Price:</label>
  <input type="text" id="fprice" name="fprice" value="<?php print($PRICE)?>" ><br><br>
    <label for="fin_promo">In promo:</label>
    <input type="checkbox" id="fin_promo" name="fin_promo" <?php print($IN_PROMO)?>><br><br>
    <label for="fdescription:">Description:</label>
    <input type="text" id="fdescription" name="fdescription" size="70" value="<?php print($DESCRIPTION) ?>"><br><br>

  <input type="submit" name="fsave" value="Save">
</form>
