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

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sticky-footer-navbar/">

    <script src="./include/plotly-latest.min.js"></script>

    <!-- Bootstrap core CSS -->
    <link href="./vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./include/fontawesome-5.10.1/css/all.css" rel="stylesheet">


</head>

<body>

<header>
    <nav class="navbar navbar-expand-md">
        <a class="navbar-brand" href="./index.php">gaMeDB</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon">...</span>
        </button>
        <div id="navbarCollapse" class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <?php if (isset($Session->role) && $Session->role == "admin") echo '<li class="nav-item"><a class="nav-link" href="./admin.php">Administration</a></li>'; ?>
                <?php if (!isset($Session->connected) || $Session->connected == false) echo '<li class="nav-item"><a class="nav-link" href="./inscription.php">Inscription</a></li>'; ?>
                <?php if (isset($Session->connected) && $Session->connected == true) { ?>
                    <li class="nav-item"><a class="nav-link" href="./index.php?deconnexion">Déconnexion</a></li>
                    <li class="nav-item"><a class="btn btn-outline-primary" href="#"><?php echo $Session->pseudo;?></a></li>
                <?php } else { ?>
                    <li class="nav-item"><a class="btn btn-outline-primary" href="./connexion.php">Se connecter</a></li>
                <?php } ?>
            </ul>
        </div>
    </nav>
</header>

<div class="album py-3 bg-light">
<div class="container">
