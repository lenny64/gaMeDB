<?php
require_once("./include/common.php");
require_once("./include/functions.php");

function getScoreAssociation($association_id, $format=false)
{
    global $db;
    $nbScans = 0;
    $scans = Array();
    if (isset($association_id) && $association_id != NULL) {
        $liste_scans = mysqli_query($db, "SELECT * FROM scans WHERE scan_association_id = $association_id ORDER BY scan_datetime ASC;");
        while ($scan = mysqli_fetch_array($liste_scans)) {
            $nbScans++;
            $scans[] = $scan;
        }
        $score = evaluerScoreFromScans($scans);
        if (isset($format) && $format != NULL) {
            echo json_encode($score);
        }
    }
    return $score;
}

function getHistoriqueScoreAssociation($association_id, $format=false)
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
    }
    if (isset($format) && $format == 'json') {
        echo json_encode($tableau);
    }
    return $tableau;
}

if (isset($_GET['association_id']) && $_GET['association_id'] != NULL) {
    $score_association = getStatsAssociation($_GET['association_id']);
}

?>
