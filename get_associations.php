<?php

require_once("./include/common.php");
require_once("./include/functions.php");

function getAssociations($association_id=false)
{
    global $db;
    $associations = Array();

    if (isset($_GET['id']) && $_GET['id'] !== NULL)
    {
        $association_id = $_GET['id'];
        $liste_associations = mysqli_query($db, "SELECT * FROM associations WHERE association_id = $association_id");
    }
    else
    {
        $liste_associations = mysqli_query($db, "SELECT * FROM associations");
    }

    while ($association = mysqli_fetch_array($liste_associations))
    {
        $associations[] = $association;
    }

    echo json_encode($associations);
    return $associations;
}

if (isset($_GET['association_id']) && $_GET['association_id'] != NULL) {
    getAssociations($_GET['association_id']);
}
else {
    getAssociations();
}

?>
