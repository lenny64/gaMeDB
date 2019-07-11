<?php
include_once("./get_totems.php");

function jsonError($prefix, $error_msg, $internal_code="Unknown", $http_status_code=500, $severity="FATAL")
{
    error_log('['. $severity . '] ' . $prefix.': '.$internal_code . ' - ' .$error_msg);
    if($severity == "FATAL") {
        $json = array("error" => array('status' => $http_status_code, "code" => $internal_code, "message" => $error_msg));
        http_response_code($http_status_code);
        echo json_encode($json, JSON_PRETTY_PRINT);
        exit();
    }
}

function distance($lat1, $lon1, $lat2, $lon2, $unit) {
    if (($lat1 == $lat2) && ($lon1 == $lon2)) {
        return 0;
    }
    else {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }
}

function evaluerScoreFromScans($scans) {
    $score = 0;
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
                // Si la distance est de 0 on gagne 5 points
                if ($distance == 0) {
                    $score = $score + 5;
                }
                // Si la distance est inférieure à 5 km on compte 5x + 5
                if ($distance > 0 && $distance < 5) {
                    $score = $score + (5 * $distance + 5);
                }
                // Entre 5 et 10 km on compte 10x - 20
                else if ($distance >= 5 && $distance < 10) {
                    $score = $score + (10 * $distance - 20);
                }
                // Entre 10 et 20 km on compte 10x
                else if ($distance >= 10 && $distance < 20) {
                    $score = $score + (10 * $distance);
                }
                // Entre 20 et 50 km on compte 15x - 100
                else if ($distance >= 20 && $distance < 50) {
                    $score = $score + (15 * $distance - 100);
                }
                // Au-dela on fait une asymptote qui tend vers 1000
                else if ($distance >= 50) {
                    $score = $score + (1000 - (1 / $distance));
                }
            }
        }
    }
    // Qu'un seul scan ? On met un score à 20
    else if (sizeof($scans) == 1) {
        $score = 20;
    }
    else {
        $score = 0;
    }
    return $score;
}




 ?>
