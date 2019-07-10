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





 ?>
