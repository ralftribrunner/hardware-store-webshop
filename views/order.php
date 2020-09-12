<?php
/** This view contains the layout of the order form. It depends on other views.
 * @var bool $SUCCESS
 */
?>
<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="display-4">Kosár tartalma</h1>
            <?php include('../views/basket.php'); ?>

            <h1 class="text-primary">Megrendelés</h1>
            <?php
                if (isset($SUCCESS) && $SUCCESS==true) {
                    print ('
                    <div class="alert alert-success" role="alert">
                        Sikeres megrendelés!
                    </div>
                    
                ');

            }
            //  Ha létezik a $SUCCESS változó, akkor annak megfelelően adjuk visszajelzést, hogy sikerült-e a
            //  megrendelés. Ha igen, akkor ne printeljük ki újra a formot.
            else {
                include('../views/order_form.php');
            }

            ?>
        </div>
        <!-- /.col-lg-9 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container -->