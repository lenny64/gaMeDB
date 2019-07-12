<?php

require_once("./include/common.php");
require_once("./include/functions.php");

function getJoueurs($joueur_id=false)
{
    $joueurs = Array();
    global $db;

    if ($joueur_id !== false && $joueur_id !== NULL)
    {
        $liste_joueurs = mysqli_query($db, "SELECT * FROM joueurs WHERE joueur_id = $joueur_id");
        echo json_encode($joueur_id);
    }
    else
    {
        // ATTENTION GROS PROBLEME DE SECURITE A RESOUDRE
        $liste_joueurs = mysqli_query($db, "SELECT joueur_id, joueur_pseudo, joueur_association_id FROM joueurs");
    }

    while ($joueur = mysqli_fetch_assoc($liste_joueurs))
    {
        $joueurs[] = $joueur;
    }

    echo json_encode($joueurs);

    return $joueurs;
}

if (isset($_GET['joueur_id']) && $_GET['joueur_id'] != NULL) {
    getJoueurs($_GET['joueur_id']);
}
else {
    getJoueurs();
}

?>
