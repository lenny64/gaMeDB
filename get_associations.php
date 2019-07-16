<?php
require_once("./include/common.php");

header('Content-Type: application/json; charset=utf-8');

function getAssociations($association_id=false)
{
    global $db;
    $associations = Array();

    if ($association_id !== false && $association_id !== NULL) {
        $liste_associations = mysqli_query($db, "SELECT * FROM associations WHERE association_id = $association_id");
    }
    else {
        $liste_associations = mysqli_query($db, "SELECT * FROM associations");
    }

    while ($association = mysqli_fetch_array($liste_associations)) {
        $associations[] = $association;
    }

    echo json_encode($associations,JSON_PRETTY_PRINT);
    return $associations;
}

if (isset($_GET['association_id']) && $_GET['association_id'] != NULL) {
    getAssociations($_GET['association_id']);
}
else {
    getAssociations();
}

?>
