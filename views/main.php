<?php
/** This view contains the general skeleton of the site; a greeting section and two areas for the product listings
 * Used variables:
 * @var ProductList $PROMO_PRODUCTS      object of the list of promo products
 * @var ProductList $OTHER_PRODUCTS      object containing the non-promo products
 */
?>
<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="jumbotron">
                <h1 class="display-4">Üdvözöljük áruházunkban!</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed quis malesuada nunc. Proin ut tortor eu massa
                    gravida pharetra eget id risus. Maecenas ac quam quis sem ultrices dignissim. Phasellus laoreet consequat
                    ornare. Etiam pharetra scelerisque pharetra. Quisque lectus lectus, mattis sit amet pretium non, lobortis
                    et diam. Morbi at lorem nibh. Quisque consequat bibendum erat et sollicitudin. Fusce consequat enim tristique,
                    vestibulum mi at, eleifend sapien.</p>
            </div>
            <!-- /.jumbotron -->
            <section>
                <h1 class="text-primary">Akciós termék</h1>
                <div class="row">
                    <?php
                    foreach ($PROMO_PRODUCTS->getProducts() as $product) {
                        include('../views/product.php');
                    }
                    ?>
                </div>
                <!-- /.row -->
            </section>

            <section>
                <h1 class="text-primary">További termékeink</h1>
                <div class="row">
                    <?php
                    foreach ($OTHER_PRODUCTS->getProducts() as $product) {
                        include('../views/product.php');
                    }
                    ?>
                </div>
                <!-- /.row -->
            </section>
        </div>
        <!-- /.col-lg-9 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container -->