<?php
require_once("./include/common.php");

header('Content-Type: application/json; charset=utf-8');

function getHistoriqueScoreAssociation($association_id)
{
    global $db;
    $tableau = Array();
    if (isset($association_id) && $association_id != NULL) {
        $association_id = mysqli_real_escape_string($db, $association_id);
        $liste_scores = mysqli_query($db, "SELECT points_association_datetime AS dt, points_association_points AS points FROM points_association WHERE points_association_association_id = $association_id ORDER BY dt ASC LIMIT 200");
        while ($score = mysqli_fetch_array($liste_scores)) {
            $tableau['dt'][] = $score['dt'];
            $tableau['points'][] = $score['points'];
        }
        echo json_encode($tableau,JSON_PRETTY_PRINT);
        return $tableau;
    }
}

if (isset($_GET['association_id']) && $_GET['association_id'] != NULL) {
    getHistoriqueScoreAssociation($_GET['association_id']);
}

?>
