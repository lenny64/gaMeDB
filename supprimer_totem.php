<?php

$suppressionok = false;

if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == 'supprimer_totem')
{
    $totem_id = mysqli_real_escape_string($db, $_GET['id']);
    if (empty($totem_id))
    {
        echo json_encode("Erreur de valeurs");
    }
    else {
        $suppressionok = true;
    }
}
else {
    $suppressionok = false;
}

if ($suppressionok === true)
{
    mysqli_query($db, 'DELETE FROM totems WHERE `totem_id` = '.$totem_id.';');
    echo json_encode("Totem removed");
}


 ?>
