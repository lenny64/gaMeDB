<?php
require_once("./include/common.php");

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

function getScoreJoueur($joueur_id)
{
    global $db;
    $score = 0;
    if (isset($joueur_id) && $joueur_id != NULL) {
        $db_score = mysqli_query($db, "SELECT points_joueur_points FROM `points_joueur` WHERE points_joueur_joueur_id = '".$joueur_id."' ORDER BY points_joueur_datetime DESC LIMIT 1;");
        $resultats_score = mysqli_fetch_all($db_score);
        if (isset($resultats_score[0][0])) {
            $score = $resultats_score[0][0];
        }
        else {
            $score = "0";
        }
        echo json_encode($score,JSON_PRETTY_PRINT);
        return $score;
    }
    else {
        echo json_encode(Array("Erreur" => "Veuillez spécifier un joueur_id"));
        return $score;
    }
}



if (isset($_SESSION['joueur_id']) && $_SESSION['joueur_id'] != NULL) {
    $score_joueur = getScoreJoueur($_SESSION['joueur_id']);
}

else if (isset($_GET['joueur_id']) && $_GET['joueur_id'] != NULL) {
    $score_joueur = getScoreJoueur($_GET['joueur_id']);
}

else {
    echo json_encode(Array("Erreur" => "Veuillez spécifier un joueur_id"));
}
?>
