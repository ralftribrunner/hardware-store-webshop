<?php
/** This view is for displaying the basket
 * Used variables:
 * @var Basket $BASKET
 */
?>
<table class="table table-striped">
    <thead>
    <tr>
        <th class="name">Termék</th>
        <th class="quantity">Mennyiség</th>
        <th class="minus"></th>
        <th class="price">Ár</th>
        <th class="plus"></th>
        <th class="delete"></th>
    </tr>
    </thead>
    <tbody id="basketbody">
    <?php
    foreach($BASKET->getContent() as $item) {
        print ('
            <tr id="'.$item["id"].'">
                <td class="name">'.$item["nev"].'</td>
                <td id="quantity" class="quantity">'.$item["darab"].' darab</td>
                <td class="minus">  <button type="button" onclick="decrementBasketElement('.  $item["id"] .')" class="btn btn-secondary">-</button> </td>
                <td class="price">'.$item["ar"].' Ft</td>
                <td class="plus">  <button type="button" onclick="incrementBasketElement('.  $item["id"] .' )" class="btn btn-success">+</button> </td>
                <td class="delete"> <button type="button" onclick="removeBasketElement('.  $item["id"].')" class="btn btn-danger">Törlés</button> </td>
            </tr>
            ');
    }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <th class="name table-info" colspan="2">Összesen:</th>
        <th id="sum" class="price table-info"><?php echo number_format($BASKET->getTotal(), 0, ',', ' ') ?> Ft</th>
    </tr>
    </tfoot>
</table>

<script type="text/javascript">
    
    /**
     * @return {string}
     */
    function JSON_to_table(decoded_data) {
        var txt="";
        txt += "<table border='1'>"
        for (x in decoded_data) {
            txt += "<tr>" +
                "<td class='name'>" + decoded_data[x]['name'] + "</td>" +
                "<td class='quantity'>" + decoded_data[x]['quantity'] + " darab"+ "</td>" +
                "<td class='minus'>"+ "<button type=\"button\" onclick=\"decrementBasketElement(" + decoded_data[x]['id']  +")\" class=\"btn btn-secondary\">" +"-"+ "</button>"   +"</td>"+
                "<td class='price'>" + decoded_data[x]['price'] +" Ft"+ "</td>" +
                "<td class='plus'>"+ "<button type=\"button\" onclick=\"incrementBasketElement(" +decoded_data[x]['id'] +")\" class=\"btn btn-success\">" +"+"+ "</button>"   +"</td>"+
                "<td class='delete'>"+ "<button type=\"button\" onclick=\"removeBasketElement(" +decoded_data[x]['id'] +")\" class=\"btn btn-danger\">" +"Törlés"+ "</button>"   +"</td>"+
                "</tr>";
        }
        txt += "</table>"
        return txt;

    }


    function basketSum(decoded_data) {
        var sum=0;

        for (x in decoded_data) {
            sum+=decoded_data[x]['price']
        }
        return sum.toString();

    }

    function removeBasketElement(id) {
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (request.readyState == 4) {
                // Response arrived
                if (request.status == 200) {

                    // HTTP response is "200 OK" - we have result
/*
                    document.getElementById(id).remove();
                    document.getElementById("sum").innerText=request.responseText + " Ft"
*/
                    var decoded_data = $.parseJSON(request.responseText);

                    $("#basketbody").html(JSON_to_table(decoded_data))
                    $("#sum").html(basketSum(decoded_data) + " Ft")

                   // window.alert(request.responseText);
                    return request.responseText; // response as raw text
                }
                else {
                    console.log("Error in request");
                }
            }
        };
       request.open('GET', 'https://beta.dev.itk.ppke.hu/webprog/~trira/basket/remove/'+id, true);
        request.send();

    }
    function incrementBasketElement(id) {
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (request.readyState == 4) {
                // Response arrived
                if (request.status == 200) {

                    // HTTP response is "200 OK" - we have result
                    //window.alert(request.responseText);
                    /*
                    document.getElementById(id).children.item(1).textContent=request.responseText.split(';')[0]
                    document.getElementById("sum").innerText=request.responseText.split(';')[1] + " Ft"
                    */
                    var decoded_data = $.parseJSON(request.responseText);

                    $("#basketbody").html(JSON_to_table(decoded_data))
                    $("#sum").html(basketSum(decoded_data)+" Ft")
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
    function decrementBasketElement(id) {
        const request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (request.readyState == 4) {
                // Response arrived
                if (request.status == 200) {

                    // HTTP response is "200 OK" - we have result

/*
                    if(request.responseText.split(';')[1]!==undefined) {
                        document.getElementById(id).children.item(1).textContent=request.responseText.split(';')[1]
                    } else {
                        document.getElementById(id).remove();
                    }
                    document.getElementById("sum").innerText=request.responseText.split(';')[0] + " Ft"
                    */
                    var decoded_data = $.parseJSON(request.responseText);

                    $("#basketbody").html(JSON_to_table(decoded_data))
                    $("#sum").html(basketSum(decoded_data)+ " Ft")
                    return request.responseText; // response as raw text
                }
                else {
                    console.log("Error in request");
                }
            }
        };
        request.open('GET', 'https://beta.dev.itk.ppke.hu/webprog/~trira/basket/minus/'+id, true);
        request.send();

    }

</script>