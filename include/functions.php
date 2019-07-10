<?php

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




 ?>
