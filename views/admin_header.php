<?php
/** This view contains the HTML header and page header of the site
 * Used variables:
 * @var string $PAGE        the variable containing the name of the currently active menu item
 */

/**
 * Create a formatted menu item source from menu name, target link and active flag.
 *
 * @param string $title     title of the menu item
 * @param string $link      target of the menu item
 * @param bool $active      whether the menu item is active
 * @return string           formatted HTML source of the menu item
 */
function menu_item($title, $link, $active) {
    $buff  = '<li class="nav-item'.($active ? ' active' : '').'">';
    $buff .= '    <a class="nav-link" href="'.$link.'">'.$title;
    $buff .= ($active ? ' <span class="sr-only">(aktív)</span>' : '').'</a>';
    $buff .= '</li>';
    return $buff;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Szuper Webshop</title>
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/shop-homepage.css" rel="stylesheet">
</head>

<body>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">Webshop</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <?php echo menu_item('Megrendelések',    'https://beta.dev.itk.ppke.hu/webprog/~trira/admin/orders', $PAGE == 'admin_orders'); ?>
                <?php echo menu_item('Termékek', 'https://beta.dev.itk.ppke.hu/webprog/~trira/admin/products', $PAGE == 'admin_products'); ?>
            </ul>
        </div>
    </div>
</nav>
