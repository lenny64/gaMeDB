<?php
require_once("./include/common.php");
require_once("./include/functions.php");

function getScoreJoueur_old($joueur_id)
{
    global $db;
    $nbScans = 0;
    $scans = Array();
    if (isset($joueur_id) && $joueur_id != NULL) {
        $liste_scans = mysqli_query($db, "SELECT * FROM scans WHERE scan_joueur_id = $joueur_id ORDER BY scan_datetime ASC;");
        while ($scan = mysqli_fetch_array($liste_scans)) {
            $nbScans++;
            $scans[] = $scan;
        }
        $score = evaluerScoreFromScans($scans);
        echo json_encode($score);
        return $score;
    }
}

function getScoreJoueur($joueur_id)
{
    global $db;
    $score = 0;
    if (isset($joueur_id) && $joueur_id != NULL) {
        $db_score = mysqli_query($db, "SELECT points_joueur_points FROM `points_joueur` WHERE points_joueur_joueur_id = '".$joueur_id."' ORDER BY points_joueur_datetime DESC LIMIT 1;");
        $score = mysqli_fetch_all($db_score)[0][0];
        echo json_encode($score);
        return $score;
    }
}



if (isset($_SESSION['joueur_id']) && $_SESSION['joueur_id'] != NULL) {
    $score_joueur = getScoreJoueur($_SESSION['joueur_id']);
}

else if (isset($_GET['joueur_id']) && $_GET['joueur_id'] != NULL) {
    $score_joueur = getScoreJoueur($_GET['joueur_id']);
}

?>
