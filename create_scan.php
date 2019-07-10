<?php
include('./include/front_header.php');

$creationok = false;

if (isset($_GET['totem_id']))
{
    $totem_id = mysqli_real_escape_string($db, $_GET['totem_id']);
    $joueur_id = 1;
    $association_id = 1;
    if (empty($totem_id))
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
    mysqli_query($db, 'INSERT INTO scans (`scan_joueur_id`,
                                            `scan_association_id`,
                                            `scan_totem_id`)
                                    VALUES( "'.$joueur_id.'",
                                            "'.$association_id.'",
                                            "'.$totem_id.'");');
}


 ?>
