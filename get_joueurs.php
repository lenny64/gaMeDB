<?php

require_once("./include/common.php");
require_once("./include/functions.php");

$joueurs = Array();

if (isset($_GET['id']) && $_GET['id'] !== NULL)
{
    $joueur_id = $_GET['id'];
    $liste_joueurs = mysqli_query($db, "SELECT * FROM joueurs WHERE joueur_id = $joueur_id");
}
else
{
    $liste_joueurs = mysqli_query($db, "SELECT * FROM joueurs");
}

while ($joueur = mysqli_fetch_array($liste_joueurs))
{
    $joueurs[] = $joueur;
}

if (isset($_GET['format']) && $_GET['format'] == 'json') {
    echo json_encode($joueurs);
}

?>
