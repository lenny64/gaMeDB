<?php

require_once("./include/common.php");
require_once("./include/functions.php");

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

if (isset($_GET['format']) && $_GET['format'] == 'json'){
    echo json_encode($associations);
}

?>
