<?php
require_once("./include/common.php");
require_once("./include/functions.php");
require_once("./get_score_joueur.php");

function postScoreJoueur($joueur_id)
{
    global $db;
    $score = getScoreJoueur($joueur_id);
    mysqli_query($db, "INSERT INTO points_joueur (`points_joueur_joueur_id`, `points_joueur_points`) VALUES($joueur_id, $score);");
}

?>
