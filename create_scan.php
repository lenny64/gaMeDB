<?php
include('./include/front_header.php');

$creationok = false;

if (isset($_POST['totem_code']) && isset($_POST['joueur_id']) && isset($_POST['association_id']))
{
    if ($_POST['totem_code'] != NULL && $_POST['joueur_id'] != NULL && $_POST['association_id'] != NULL) {
        $totem_code = mysqli_real_escape_string($db, $_POST['totem_code']);
        // Je cherche l'id du totem grace au code
        $totem_result_bdd = mysqli_query($db, "SELECT totem_id FROM totems WHERE totem_code = '".$totem_code."'");
        $totem_id = mysqli_fetch_array($totem_result_bdd)[0];
        // Je cherche l'id du joueur
        $joueur_id = 1;
        // Je cherche l'id de l'association
        $association_id = 1;
        if (empty($totem_id))
        {
            echo json_encode("Erreur de valeurs");
        }
        else {
            $creationok = true;
        }
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
    include('./get_stats.php');
    getStats($association_id=$association_id,$joueur_id=$joueur_id);
    echo json_encode("Succes !!");
}


 ?>
