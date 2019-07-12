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

class Session
{
    function __construct()
    {
        session_start();
        global $config;
        global $db;
        $this->db = $db;
    }
    function connecter($infos)
    {
        // Methode par utilisateur et mot de passe
        if (isset($infos['pseudo']) && isset($infos['password']) && $infos['pseudo'] != false && $infos['password'] != false) {
            $pseudo = mysqli_real_escape_string($this->db, $infos['pseudo']);
            $password = mysqli_real_escape_string($this->db, $infos['password']);
            $db_liste_joueurs = mysqli_query($this->db, "SELECT * FROM joueurs WHERE joueur_pseudo = '".strtolower($pseudo)."' LIMIT 1;");
            while ($joueur = mysqli_fetch_assoc($db_liste_joueurs)) {
                if (md5($password) == $joueur['joueur_password']) {
                    $this->connected = true;
                    $this->pseudo = $joueur['joueur_pseudo'];
                    $this->joueur_id = $joueur['joueur_id'];
                    $this->association_id = $joueur['joueur_association_id'];
                    $this->nom = $joueur['joueur_nom'];
                    $this->prenom = $joueur['joueur_prenom'];
                    $this->mail = $joueur['joueur_mail'];
                    $_SESSION['connected'] = true;
                    $_SESSION['joueur_id'] = $this->joueur_id;
                }
            }
        }
        else if (isset($infos['joueur_id']) && $infos['joueur_id'] != null) {
            $joueur_id = $infos['joueur_id'];
            $db_joueur = mysqli_query($this->db, "SELECT * FROM joueurs WHERE joueur_id = $joueur_id LIMIT 1;");
            while ($joueur = mysqli_fetch_assoc($db_joueur)) {
                $this->connected = true;
                $this->pseudo = $joueur['joueur_pseudo'];
                $this->joueur_id = $joueur['joueur_id'];
                $this->association_id = $joueur['joueur_association_id'];
                $this->nom = $joueur['joueur_nom'];
                $this->prenom = $joueur['joueur_prenom'];
                $this->mail = $joueur['joueur_mail'];
                $_SESSION['connected'] = true;
                $_SESSION['joueur_id'] = $this->joueur_id;
            }
        }
        else {
            echo "erreur";
        }
        if ($this->connected == true) {
        }
    }
    function checkConnected()
    {
        if (isset($_SESSION['connected'])) {
            if ($_SESSION['connected'] == true) {
                if (isset($_SESSION['joueur_id']) && $_SESSION['joueur_id'] != NULL) {
                    $this->connecter(Array('joueur_id' => $_SESSION['joueur_id']));
                }
            }
        }
    }
}
