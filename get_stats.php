<?php
require_once("./include/common.php");
require_once("./include/functions.php");
require_once("./get_totems.php");


function getStats($association_id=false, $joueur_id=false)
{
    global $db;
    $score = 0;
    $nbScans = 0;
    $scans = Array();
    if (isset($association_id) && $association_id != NULL) {
        if (isset($joueur_id) && $joueur_id != NULL) {
            $liste_scans = mysqli_query($db, "SELECT * FROM scans WHERE scan_joueur_id = $joueur_id ORDER BY scan_datetime ASC;");
        }
        else {
            $liste_scans = mysqli_query($db, "SELECT * FROM scans WHERE scan_association_id = $association_id ORDER BY scan_datetime ASC;");
        }
        while ($scan = mysqli_fetch_array($liste_scans)) {
            $nbScans++;
            $scans[] = $scan;
        }
        if (sizeof($scans) > 1) {
            for ($i=0; $i < sizeof($scans); $i++) {
                // Y'a-t-il un suivant ?
                if (array_key_exists($i+1,$scans)) {
                    // CALCUL DE LA DISTANCE ENTRE I ET I1
                    $totem_i_id = $scans[$i]['scan_totem_id'];
                    $totem_i = getTotems($id=$totem_i_id);
                    $totem_i_longitude = floatval($totem_i[$totem_i_id]['totem_longitude']);
                    // echo $totem_i_longitude;
                    $totem_i_latitude = floatval($totem_i[$totem_i_id]['totem_latitude']);

                    $totem_i1_id = $scans[$i+1]['scan_totem_id'];
                    $totem_i1 = getTotems($id=$totem_i1_id);
                    $totem_i1_longitude = floatval($totem_i1[$totem_i1_id]['totem_longitude']);
                    $totem_i1_latitude = floatval($totem_i1[$totem_i1_id]['totem_latitude']);

                    $distance_exacte = distance($totem_i_latitude, $totem_i_longitude, $totem_i1_latitude, $totem_i1_longitude, 'K');
                    $distance = (round($distance_exacte)%5 === 0) ? round($distance_exacte) : round(($distance_exacte+5/2)/5)*5;
                    // echo $distance_exacte." - ".$distance."<br/>";
                    // Si la distance est inférieure à 5 km on compte 5x + 5
                    if ($distance > 0 && $distance < 5) {
                        $score = $score + (5 * $distance + 5);
                        // echo $score;
                    }
                    // Entre 5 et 10 km on compte 10x - 20
                    else if ($distance >= 5 && $distance < 10) {
                        $score +=  $score + (10 * $distance - 20);
                        echo $score." ";
                    }
                    // Entre 10 et 20 km on compte 10x
                    else if ($distance >= 10 && $distance < 20) {
                        $score +=  $score + (10 * $distance);
                    }
                    // Entre 20 et 50 km on compte 15x - 100
                    else if ($distance >= 20 && $distance < 50) {
                        $score +=  $score + (15 * $distance - 100);
                    }
                    // Au-dela on fait une asymptote qui tend vers 1000
                    else if ($distance >= 50) {
                        $score +=  $score + (1000 - (1 / $distance));
                    }
                }
            }
        }
        // Qu'un seul scan ? On met un score à 20
        else {
            $score = 20;
        }
        // mysqli_query($db, "INSERT INTO points_association (`points_association_association_id`,
        //                                                     `points_association_points`)
        //                                             VALUES('".$association_id."',
        //                                                     '".$score."');");
    }
}

if (isset($_GET['association_id']) && $_GET['association_id'] != NULL) {
    getStats($_GET['association_id']);
}
else if (isset($_GET['association_id']) && isset($_GET['joueur_id']) &&
            $_GET['association_id'] != NULL && $_GET['joueur_id'] != NULL) {
    getStats($_GET['association_id'], $_GET['joueur_id']);
}

?>
