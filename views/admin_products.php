<?php
/**
 * @var array<Product> $PRODUCTS
 *
 */


?>

<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">name</th>
        <th scope="col">price</th>
        <th scope="col">inPromo</th>
        <th scope="col">description</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($PRODUCTS as $product) {
        $checked=$product->isInPromo() ? 'checked':'';
        print ('
            <tr>
                <td>'.$product->getId().'</td>
                <td>'.$product->getName().'</td>
                <td>'.$product->getPrice().'</td>
                <td><input type="checkbox"  onclick="return false;" '.$checked.'></td>
                <td>'.$product->getDescription().'</td>
                <td>
                    <a type="button" class="btn btn-primary" href="https://beta.dev.itk.ppke.hu/webprog/~trira/admin/products/edit/'.$product->getId().'">Edit</a>
                </td>
                <td>
                    <a type="button" class="btn btn-primary" href="https://beta.dev.itk.ppke.hu/webprog/~trira/admin/products/delete/'.$product->getId().'">Delete</a>
                </td>
            </tr>
            
    ');
    }

    ?>
    </tbody>
</table>
<a type="button" class="btn btn-primary" href="https://beta.dev.itk.ppke.hu/webprog/~trira/admin/products/new">New</a>
