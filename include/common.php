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
$config_query = mysqli_query($db,"SELECT * FROM config");
while($config_result = mysqli_fetch_assoc($config_query)) {
    switch ($config_result['config_variable']) {
        case 'titre':
            $config['TITRE'] = $config_result['config_valeur'];
            break;
        case 'titre_menu':
            $config['TITRE_MENU'] = $config_result['config_valeur'];
            break;

    }
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
                    $this->role = $joueur['role'];
                    $_SESSION['connected'] = true;
                    $_SESSION['joueur_id'] = $this->joueur_id;
                    $token = $this->storeTokenInDatabase();
                    if (isset($infos['rememberMe']) && $infos['rememberMe'] == TRUE) {
                        $this->createCookie($token);
                    }
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
                $this->role = $joueur['role'];
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
        else if (isset($_COOKIE['token']) && $_COOKIE['token'] != NULL) {
            $this->checkCookie();
        }
    }
    function checkToken()
    {
        if (isset($this->joueur_id) && $this->joueur_id != NULL) {
            $ip = $_SERVER['REMOTE_ADDR'];
            $query = mysqli_query($this->db, "SELECT connection_token FROM connections WHERE connection_user_id = $this->joueur_id ORDER BY connection_timestamp DESC LIMIT 1;");
            $result = mysqli_fetch_assoc($query);
            if (!$result) {
                return false;
            }
            return $result['connection_token'];
        }
    }
    function storeTokenInDatabase()
    {
        if (isset($this->joueur_id) && $this->joueur_id != NULL) {
            $ip = $_SERVER['REMOTE_ADDR'];
            $token = hash('sha256', md5(uniqid($this->pseudo.':'.$ip,true)));
            $sql = "INSERT INTO connections (`connection_ip` , `connection_user_id`, `connection_token`) VALUES('$ip', '$this->joueur_id', '$token'); ";
            $store = mysqli_query($this->db, $sql);
            if (!$store) {
                return false;
            }
            return $token;
        }
    }
    function checkCookie()
    {
        if (isset($_COOKIE['token']) && $_COOKIE['token'] != NULL) {
            $cookie = $_COOKIE['token'];
            list ($user, $token, $mac) = explode(':',$cookie);
            $this->joueur_id = $user;
            $tokenbdd = $this->checkToken();
            if ($tokenbdd) {
                if (hash_equals($token, $tokenbdd)) {
                    $this->connecter(Array('joueur_id' => $this->joueur_id));
                }
            }
        }
    }
    function createCookie($token)
    {
        $cookie = $this->joueur_id.':'.$token;
        $mac = hash('sha256',$cookie);
        $cookie .= ':' . $mac;
        setcookie('token', $cookie);
        // $ip = $_SERVER['REMOTE_ADDR'];
        // setcookie('userId', $this->joueur_id);
        // setcookie('token', hash('sha256', md5(uniqid($this->pseudo.':'.$ip,true))));
    }
}
