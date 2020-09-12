<?php
/** This view creates the footer of the page and also it closes the HTML stucture. No additional variables are needed.
 */
?>
<!-- Footer -->
<footer class="py-5 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white"> &copy; <?php echo date("Y"); ?> Webshop &ndash; Minden jog fenntartva!</p>
    </div>
    <div id="myModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kosár tartalma</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="basketContent" class="modal-body">

                </div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-primary" href="https://beta.dev.itk.ppke.hu/webprog/~trira/order">Pénztárhoz</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Bezár</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container -->
</footer>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
    function basketSum(decoded_data) {
        var sum=0;

        for (x in decoded_data) {
            sum+=decoded_data[x]['price']
        }
        return sum.toString();
    }

    function getQuantity(decoded_data,prod_id) {
        for (x in decoded_data) {
            if (decoded_data[x]['id'] === prod_id.toString()) {

                return decoded_data[x]['quantity']
            }
        }
        return ""
    }

    $("[data-product]").click(function () {
        var prod_id = $(this).data("product"); // A megnyomott gomb data-product értéke

        var result=[];
        $.get( "https://beta.dev.itk.ppke.hu/webprog/~trira/basket/add/"+prod_id, function( data ) {
            $( ".result" ).html( data );

            var decoded_data = $.parseJSON(data);
            var txt="";
            txt += "<table border='1'>"
            for (x in decoded_data) {
                txt += "<tr><td>" + decoded_data[x]['name'] + "</td><td>" + decoded_data[x]['quantity'] + " darab"+ "</td><td>" + decoded_data[x]['price'] +" Ft"+ "</td></tr>";
            }
            txt += "</table>"
            txt += "<br><p>Összesen: "+basketSum(decoded_data)+" Ft</p>"

            // $.each(decoded_data, function(index, value) {
            //     console.log(value);
            //     result.push(value);
            // });
            let buttonSelector="#"+prod_id.toString()
            $(buttonSelector).html("Kosárban ("+getQuantity(decoded_data,prod_id)+")")
            $("#basketContent").html(txt)
            $("#myModal").modal("show");
        });




    });
</script>

</body>

</html>