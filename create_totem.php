<?php
include('./include/front_header.php');

$creationok = false;

if (isset($_POST['longitude']) && isset($_POST['latitude']) && isset($_POST['localisation']))
{
    $longitude = mysqli_real_escape_string($db, $_POST['longitude']);
    $latitude = mysqli_real_escape_string($db, $_POST['latitude']);
    $localisation = mysqli_real_escape_string($db, $_POST['localisation']);
    $code = uniqid();
    if (empty($longitude) || empty($latitude) || empty($localisation))
    {
        echo json_encode("Erreur de valeurs");
    }
    else {
        $creationok = true;
    }
}
else {
    $creationok = false;
}

if ($creationok === true)
{
    mysqli_query($db, 'INSERT INTO totems (`totem_code`,
                                            `totem_longitude`,
                                            `totem_latitude`,
                                            `totem_localisation`)
                                    VALUES( "'.$code.'",
                                            "'.$longitude.'",
                                            "'.$latitude.'",
                                            "'.$localisation.'");');
    echo json_encode("Totem created");
}


 ?>
