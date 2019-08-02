<?php
require_once("./include/common.php");

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

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
    if (isset($_GET['format']) && $_GET['format'] == 'geojson') {
        $a = Array();
        $a['type'] = 'FeatureCollection';
        foreach ($totems as $totem) {
            $feature['type'] = 'Feature';
            $feature['geometry'] = Array('type' => 'Point', 'coordinates' => Array($totem['totem_longitude']+0, $totem['totem_latitude']+0));
            // $feature['properties'] = Array('name' => $totem['totem_code'],'description' => $totem['totem_localisation']);
            $feature['properties'] = Array('description' => $totem['totem_localisation']);
            $a['features'][] = $feature;
        }
        echo json_encode($a);
    }
    else {
        echo json_encode($totems,JSON_PRETTY_PRINT);
    }
    return $totems;
}

if (isset($_GET['totem_id']) && $_GET['totem_id'] !== NULL) {
    getTotems($_GET['totem_id']);
}
else {
    getTotems();
}


?>
