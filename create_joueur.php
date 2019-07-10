<?php

$creationok = false;

if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['mail']) &&
    isset($_POST['pseudo']) && isset($_POST['password']) && isset($_POST['association_id']))
{
    $nom = mysqli_real_escape_string($db, $_POST['nom']);
    $prenom = mysqli_real_escape_string($db, $_POST['prenom']);
    $mail = mysqli_real_escape_string($db, $_POST['mail']);
    $pseudo = mysqli_real_escape_string($db, $_POST['pseudo']);
    $password = md5(mysqli_real_escape_string($db, $_POST['password']));
    $association_id = mysqli_real_escape_string($db, $_POST['association_id']);
    if (empty($nom) || empty($prenom) || empty($mail) || empty($pseudo) ||
        empty($password) || empty($association_id) || $association_id == 0)
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
    mysqli_query($db, 'INSERT INTO joueurs (`joueur_nom`,
                                            `joueur_prenom`,
                                            `joueur_mail`,
                                            `joueur_pseudo`,
                                            `joueur_password`,
                                            `joueur_association_id`)
                                    VALUES( "'.$nom.'",
                                            "'.$prenom.'",
                                            "'.$mail.'",
                                            "'.$pseudo.'",
                                            "'.$password.'",
                                            "'.$association_id.'");');
}


 ?>
