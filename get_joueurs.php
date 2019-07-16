<?php
require_once("./include/common.php");

header('Content-Type: application/json; charset=utf-8');

function getJoueurs($joueur_id=false)
{
    global $db;
    $joueurs = Array();

    if ($joueur_id !== false && $joueur_id !== NULL) {
        $liste_joueurs = mysqli_query($db, "SELECT * FROM joueurs WHERE joueur_id = $joueur_id");
    }
    else {
        $liste_joueurs = mysqli_query($db, "SELECT joueur_id, joueur_pseudo, joueur_association_id FROM joueurs");
    }

    while ($joueur = mysqli_fetch_assoc($liste_joueurs)) {
        $joueurs[] = $joueur;
    }

    echo json_encode($joueurs,JSON_PRETTY_PRINT);
    return $joueurs;
}

if (isset($_GET['joueur_id']) && $_GET['joueur_id'] != NULL) {
    getJoueurs($_GET['joueur_id']);
}
else {
    getJoueurs();
}

?>
