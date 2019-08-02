<?php

include('./include/common.php');
include('./include/functions.php');

include('./session.php');


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">

    <title>gaMeDB</title>

    <!-- <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/product/"> -->

    <script src="./include/plotly-latest.min.js"></script>

    <!-- Bootstrap core CSS -->
    <link href="./bootstrap-4.0.0/dist/css/bootstrap.min.css" rel="stylesheet">


</head>

<body>

<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4">
    <h5 class="my-0 mr-md-auto font-weight-normal"><a href="./index.php">gaMeDB</a></h5>
    <nav class="my-2 my-md-0 mr-md-3">
        <?php if (isset($Session->role) && $Session->role == "admin") echo '<a class="p-2 text-dark" href="./admin.php">Administration</a>'; ?>
        <?php if (!isset($Session->connected) || $Session->connected == false) echo '<a class="p-2 text-dark" href="./inscription.php">Inscription</a>'; ?>
    </nav>
    <?php if (isset($Session->connected) && $Session->connected == true) { ?>
        <a class="p-2 text-dark" href="./index.php?deconnexion">Déconnexion</a>
        <a class="btn btn-outline-primary" href="#"><?php echo $Session->pseudo;?></a>
    <?php } else { ?>
        <a class="btn btn-outline-primary" href="./connexion.php">Se connecter</a>
    <?php } ?>
</div>

<div class="album py-5 bg-light">
<div class="container">
