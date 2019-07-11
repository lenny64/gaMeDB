<?php
require_once("./include/common.php");
require_once("./include/functions.php");
require_once("./get_score_association.php");

function postScoreAssociation($association_id)
{
    global $db;
    $score = getScoreAssociation($association_id);
    mysqli_query($db, "INSERT INTO points_association (`points_association_association_id`, `points_association_points`) VALUES($association_id, $score);");
}

?>
