<?php
require_once('./include/front_header.php');
require_once('./supprimer_totem.php');
?>

<div class="col-md-12 my-2">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Associations</h5>
            <p class="card-text">
                <?php
                $url_associations = $config['URL_BASE']."get_associations.php";
                $associations = json_decode(file_get_contents($url_associations));
                $url_joueurs = $config['URL_BASE']."get_joueurs.php";
                $joueurs = json_decode(file_get_contents($url_joueurs));
                foreach ($associations as $asso) {
                    $url_score_association = $config['URL_BASE']."get_score_association.php?association_id=".$asso->association_id;
                    $score_association = json_decode(file_get_contents($url_score_association));
                    echo '<div class="col-md-12">';
                    echo '<button class="btn btn-default" type="button" data-toggle="collapse" data-target="#collapseAsso'.$asso->association_id.'" aria-expanded="false" aria-controls="multiCollapseExample2">'.$asso->association_nom.' ('.$score_association.')</button>';
                    echo '<div class="collapse multi-collapse" id="collapseAsso'.$asso->association_id.'">';
                    echo '<ul class="list-group">';
                    foreach ($joueurs as $joueur) {
                        $url_score_joueur = $config['URL_BASE']."get_score_joueur.php?joueur_id=".$joueur->joueur_id;
                        $score_joueur = json_decode(file_get_contents($url_score_joueur));
                        if ($joueur->joueur_association_id == $asso->association_id) {
                            echo '<li class="list-group-item">'.$joueur->joueur_pseudo.' ('.$score_joueur.')</li>';
                        }
                    }
                    echo '</ul>';
                    echo '</div>';
                    echo '</div>';
                } ?>
            </p>
        </div>
    </div>
</div>

<div class="col-md-12 my-2">
    <div class="card mb-12 box-shadow">
        <div class="card-body">
            <h5 class="card-title">Totems</h5>
            <p class="card-text">
                <ul class="list-group">
                <?php
                $url_totems = $config['URL_BASE']."get_totems.php";
                $totems = json_decode(file_get_contents($url_totems));
                foreach ($totems as $totem) {
                    echo "<li class='list-group-item'>".$totem->totem_localisation." ".$totem->totem_code." <a href='https://umap.openstreetmap.fr/en/map/balades-massy_312751#18/".$totem->totem_latitude."/".$totem->totem_longitude."' target='_blank'>localiser</a> <a href='./admin.php?action=supprimer_totem&id=".$totem->totem_id."'>supprimer</a></li>";
                } ?>
                </ul>
            </p>
        </div>
        <div class="col-md-12">
            <form action="./create_totem.php" method="post" class="form-inline">
                <div class="form-group mx-sm-3 mb-2">
                    <input type="text" name="latitude" placeholder="Latitude" class="form-control"/>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <input type="text" name="longitude" placeholder="Longitude" class="form-control"/>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <input type="text" name="localisation" placeholder="Localisation" class="form-control"/>
                </div>
                <button type="submit" class="btn mb-2">Ajouter</button>
            </form>
        </div>
    </div>
</div>

<?php include('./include/front_footer.php'); ?>
