<?php
/** This view is for displaying a product (object)
 * Used variables:
 * @var Product $product
 */
?>
<div class="col-lg-4 col-md-6 mb-4">
    <div class="card h-100">
        <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
        <div class="card-body">
            <h4 class="card-title">
                <a href="#"><?php echo $product->getName(); ?></a>
            </h4>
            <h5><?php echo number_format($product->getPrice(), 0,',',' ') ?> Ft</h5>
            <h6>Raktáron 15 db</h6>
            <p class="card-text"><?php echo $product->getDescription(); ?></p>
        </div>
        <div class="card-footer text-center">
            <button type="button" id="<?php echo $product->getId(); ?>" data-product="<?php echo $product->getId(); ?>" class="btn btn-primary">Kosárba!</button>



        </div>
    </div>
</div>


<script type="text/javascript">
    function updateBasket(id) {
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (request.readyState == 4) {
                // Response arrived
                if (request.status == 200) {
                    // HTTP response is "200 OK" - we have result
                    window.alert("A terméket hozzáadtuk a kosárhoz. A kosárban lévő darabszám:"+request.responseText.split(';')[0] +" darab");
                    return request.responseText; // response as raw text
                }
                else {
                    console.log("Error in request");
                }
            }
        };
        request.open('GET', 'https://beta.dev.itk.ppke.hu/webprog/~trira/basket/add/'+id, true);
        request.send();

    }

</script>