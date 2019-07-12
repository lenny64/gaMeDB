<?php
require_once("./include/common.php");

function getHistoriqueScoreJoueur($joueur_id, $format=false)
{
    global $db;
    $tableau = Array();
    if (isset($joueur_id) && $joueur_id != NULL) {
        $joueur_id = mysqli_real_escape_string($db, $joueur_id);
        $liste_scores = mysqli_query($db, "SELECT points_joueur_datetime AS dt, points_joueur_points AS points FROM points_joueur WHERE points_joueur_joueur_id = $joueur_id ORDER BY dt ASC LIMIT 200");
        while ($score = mysqli_fetch_array($liste_scores)) {
            $tableau['dt'][] = $score['dt'];
            $tableau['points'][] = $score['points'];
        }
        echo json_encode($tableau);
        return $tableau;
    }
}

if (isset($_GET['joueur_id']) && $_GET['joueur_id'] != NULL) {
    getHistoriqueScoreJoueur($_GET['joueur_id'],'json');
}

?>
