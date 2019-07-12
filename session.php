<?php
include_once('./include/common.php');


$Session = new Session();
$Session->checkConnected();

if (isset($_GET['deconnexion'])) {
    session_destroy();
    $Session->connected = false;
}
else if (isset($_GET['connexion'])) {
    if (isset($_POST['pseudo']) && isset($_POST['password'])) {
        if ($_POST['pseudo'] != NULL && $_POST['password'] != NULL) {
            $Session->connecter(Array('pseudo' => $_POST['pseudo'], 'password' => $_POST['password']));
        }
    }
}

function getSession($format = false)
{
    global $Session;
    if (isset($_SESSION['joueur_id']) && $_SESSION['joueur_id'] != NULL) {
        if (isset($Session->joueur_id)) {
            $resultat = Array();
            $resultat['joueur_id'] = $Session->joueur_id;
            $resultat['pseudo'] = $Session->pseudo;
            $resultat['mail'] = $Session->mail;
            if (isset($format) && $format == 'json') {
                echo json_encode($resultat);
            }
            return $resultat;
        }
    }
    else {
        if (isset($format) && $format == 'json') {
            echo json_encode("disconnected");
        }
        return false;
    }
}

if (isset($_GET['getSession'])) {
    getSession('json');
}

?>
