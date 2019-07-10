<?php

require_once("./include/common.php");
require_once("./include/functions.php");

$totems = Array();

function getTotems($id=null) {
    global $db;
    if (isset($id) && $id !== NULL)
    {
        $totem_id = $id;
        $liste_totems = mysqli_query($db, "SELECT * FROM totems WHERE totem_id = $totem_id");
    }
    else
    {
        $liste_totems = mysqli_query($db, "SELECT * FROM totems");
    }

    while ($totem = mysqli_fetch_array($liste_totems))
    {
        $totems[$totem['totem_id']] = $totem;
    }

    if (isset($_GET['format']) && $_GET['format'] == 'json'){
        echo json_encode($totems);
    }
    return $totems;
}

if (isset($_GET['id']) && $_GET['id'] !== NULL) {
    getTotems($_GET['id']);
}
else {
    getTotems();
}


?>
