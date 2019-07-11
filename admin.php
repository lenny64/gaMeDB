<?php
require_once('./include/front_header.php');
require_once('./get_associations.php');
require_once('./get_joueurs.php');
require_once('./get_totems.php');
require_once('./supprimer_totem.php');
?>

<div class="col-md-12 my-2">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Associations</h5>
            <p class="card-text">
                <ul class="list-group">
                <?php foreach ($associations as $asso) {
                    echo "<li class='list-group-item'>".$asso['association_nom']."</li>";
                } ?>
                </ul>
            </p>
        </div>
    </div>
</div>

<div class="col-md-12 my-2">
    <div class="card mb-12 box-shadow">
        <div class="card-body">
            <h5 class="card-title">Joueurs</h5>
            <p class="card-text">
                <ul class="list-group">
                <?php
                $joueurs = getJoueurs();
                foreach ($joueurs as $joueur) {
                    echo "<li class='list-group-item'>".$joueur['joueur_pseudo']."</li>";
                } ?>
                </ul>
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
                <?php $totems = getTotems();
                foreach ($totems as $totem) {
                    echo "<li class='list-group-item'>".$totem['totem_localisation']." ".$totem['totem_code']." <a href='https://umap.openstreetmap.fr/en/map/balades-massy_312751#18/".$totem['totem_longitude']."/".$totem['totem_latitude']."' target='_blank'>localiser</a> <a href='./admin.php?action=supprimer_totem&id=".$totem['totem_id']."'>supprimer</a></li>";
                } ?>
                </ul>
            </p>
        </div>
        <div class="col-md-12">
            <form action="./create_totem.php" method="post" class="form-inline">
                <div class="form-group mx-sm-3 mb-2">
                    <input type="text" name="longitude" placeholder="Longitude" class="form-control"/>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <input type="text" name="latitude" placeholder="Latitude" class="form-control"/>
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
