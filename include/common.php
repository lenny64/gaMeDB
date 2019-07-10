<?php


if(file_exists(dirname(__FILE__) . "/../config/config.php")) {
  require_once(dirname(__FILE__) . "/../config/config.php");
}
else {
  echo "Fichier config/config.php manquant";
  error_log("[FATAL] Fichier config/config.php manquant");
  exit();
}

global $config;

if(!$db = mysqli_connect($config['MYSQL_HOST'],
                     $config['MYSQL_USER'],
                     $config['MYSQL_PASSWORD'],
		     $config['MYSQL_DATABASE'])) {
  error_log("[FATAL] Connection à la base impossible");
  exit();
}

mysqli_query($db, "SET sql_mode = ''");
$config_query = mysqli_query($db,"SELECT * FROM associations");
while($config_result = mysqli_fetch_array($config_query)) {
  //print_r($config_result);
}
