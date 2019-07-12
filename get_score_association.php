<?php
require_once("./include/common.php");
require_once("./include/functions.php");

function getScoreAssociation_old($association_id)
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
        echo json_encode($score);
        return $score;
    }
}

function getScoreAssociation($association_id)
{
    global $db;
    $score = 0;
    if (isset($association_id) && $association_id != NULL) {
        $db_score = mysqli_query($db, "SELECT points_association_points FROM `points_association` WHERE points_association_association_id = $association_id ORDER BY points_association_datetime DESC LIMIT 1;");
        $score = mysqli_fetch_all($db_score)[0][0];
        echo json_encode($score);
        return $score;
    }
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
        return $tableau;
    }
    if (isset($format) && $format == 'json') {
        echo json_encode($tableau);
    }
}

if (isset($_GET['association_id']) && $_GET['association_id'] != NULL) {
    $score_association = getScoreAssociation($_GET['association_id']);
}

?>
