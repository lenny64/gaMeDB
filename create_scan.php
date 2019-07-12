<?php
include('./include/front_header.php');

function postScoreAssociation($association_id)
{
    global $db;
    global $config;
    $url_score = $config['URL_BASE']."get_score_association.php?association_id=".$association_id;
    $score = json_decode(file_get_contents($url_score));
    mysqli_query($db, "INSERT INTO points_association (`points_association_association_id`, `points_association_points`) VALUES($association_id, $score);");
}


function postScoreJoueur($joueur_id)
{
    global $db;
    global $config;
    $url_score = $config['URL_BASE']."get_score_joueur.php?joueur_id=".$joueur_id;
    $score = json_decode(file_get_contents($url_score));
    mysqli_query($db, "INSERT INTO points_joueur (`points_joueur_joueur_id`, `points_joueur_points`) VALUES($joueur_id, $score);");
}

$creationok = false;

if (isset($_POST['totem_code']) && isset($_POST['joueur_id']) && isset($_POST['association_id']))
{
    if ($_POST['totem_code'] != NULL && $_POST['joueur_id'] != NULL && $_POST['association_id'] != NULL) {
        $totem_code = mysqli_real_escape_string($db, $_POST['totem_code']);
        // Je cherche l'id du totem grace au code
        $totem_result_bdd = mysqli_query($db, "SELECT totem_id FROM totems WHERE totem_code = '".$totem_code."'");
        $totem_id = mysqli_fetch_array($totem_result_bdd)[0];
        // Je cherche l'id du joueur
        $joueur_id = mysqli_real_escape_string($db, $_POST['joueur_id']);
        // Je cherche l'id de l'association
        $association_id = mysqli_real_escape_string($db, $_POST['association_id']);
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
    // Je lis les scores
    $url_association = $config['URL_BASE']."get_score_association.php?association_id=".$Session->association_id;
    $score_association = json_decode(file_get_contents($url_association));
    $url_joueur = $config['URL_BASE']."get_score_joueur.php?joueur_id=".$Session->joueur_id;
    $score_joueur = json_decode(file_get_contents($url_joueur));

    // J'écris dans scans
    mysqli_query($db, 'INSERT INTO scans (`scan_joueur_id`,
                                            `scan_association_id`,
                                            `scan_totem_id`)
                                    VALUES( "'.$joueur_id.'",
                                            "'.$association_id.'",
                                            "'.$totem_id.'");');

    // Je lis les 2 derniers scans
    $query_last_scans = 'SELECT s.scan_joueur_id,s.scan_association_id,s.scan_datetime, t.totem_longitude, t.totem_latitude FROM `scans` AS s, `totems` AS t
                WHERE s.scan_totem_id = t.totem_id AND s.scan_joueur_id = "'.$joueur_id.'" ORDER BY s.scan_datetime DESC LIMIT 2';
    $db_last_scans = mysqli_query($db, $query_last_scans);
    $last_scans = mysqli_fetch_all($db_last_scans, MYSQLI_ASSOC);
    // Je récupère la distance
    $distance = distance($last_scans[0]['totem_latitude'], $last_scans[0]['totem_longitude'], $last_scans[1]['totem_latitude'], $last_scans[1]['totem_longitude'], 'K');
    // J'initialise score
    $score = 0;
    // Si la distance est de 0 on gagne 5 points
    if ($distance == 0) {
        $score = 5;
    }
    // Si la distance est inférieure à 5 km on compte 5x + 5
    if ($distance > 0 && $distance < 5) {
        $score = (5 * $distance + 5);
    }
    // Entre 5 et 10 km on compte 10x - 20
    else if ($distance >= 5 && $distance < 10) {
        $score = (10 * $distance - 20);
    }
    // Entre 10 et 20 km on compte 10x
    else if ($distance >= 10 && $distance < 20) {
        $score = (10 * $distance);
    }
    // Entre 20 et 50 km on compte 15x - 100
    else if ($distance >= 20 && $distance < 50) {
        $score = (15 * $distance - 100);
    }
    // Au-dela on fait une asymptote qui tend vers 1000
    else if ($distance >= 50) {
        $score = (1000 - (1 / $distance));
    }
    // Pour un premier scan on met un score à 20
    if (sizeof($last_scans) <= 1) {
        $score = 20;
    }
    $points_gagnes = (round($score)%5 === 0) ? round($score) : round(($score+5/2)/5)*5;
    $score_joueur += $points_gagnes;
    $score_association += $points_gagnes;
    echo $score_joueur;
    $db_insert_score_joueur = mysqli_query($db, 'INSERT INTO points_joueur (points_joueur_joueur_id,
                                                                            points_joueur_points)
                                                VALUES ("'.$joueur_id.'",
                                                        "'.$score_joueur.'");');
    $db_inser_score_association = mysqli_query($db, 'INSERT INTO points_association (points_association_association_id,
                                                                            points_association_points)
                                                VALUES ("'.$association_id.'",
                                                        "'.$score_association.'");');

    echo json_encode("Succes !!");
}


 ?>
