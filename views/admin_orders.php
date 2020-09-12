<?php
/** This array contains the users.
 * @var array $ORDERS
 */

?>

<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">name</th>
        <th scope="col">email</th>
        <th scope="col">comment</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($ORDERS as $item) {
        print ('
            <tr>
                <td>'.$item['id'].'</td>
                <td>'.$item['name'].'</td>
                <td>'.$item['email'].'</td>
                <td>'.$item['comment'].'</td>
            </tr>
    ');
    }

    ?>
    </tbody>
</table>
<form method="POST">
    <input type="submit" value="Logout">
</form>