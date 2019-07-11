<?php
require_once("./include/common.php");
require_once("./include/functions.php");

function getScoreJoueur($joueur_id, $format=false)
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
        if (isset($format) && $format == 'json') {
            echo json_encode($score);
        }
    }
    return $score;
}



if (isset($_SESSION['joueur_id']) && $_SESSION['joueur_id'] != NULL) {
    $score_joueur = getScoreJoueur($_SESSION['joueur_id']);
}

else if (isset($_GET['joueur_id']) && $_GET['joueur_id'] != NULL) {
    $score_joueur = getScoreJoueur($_GET['joueur_id']);
}

?>
