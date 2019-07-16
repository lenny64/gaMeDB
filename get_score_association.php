<?php
require_once("./include/common.php");

header('Content-Type: application/json; charset=utf-8');

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
    else {
        echo json_encode(Array("Erreur" => "Veuillez spécifier une association_id"));
        return $score;
    }
}

if (isset($_GET['association_id']) && $_GET['association_id'] != NULL) {
    $score_association = getScoreAssociation($_GET['association_id']);
}

else {
    echo json_encode(Array("Erreur" => "Veuillez spécifier une association_id"));
}

?>
