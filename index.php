<?php
include('./include/front_header.php');

if (isset($Session->connected) && $Session->connected == true) {

    $url_joueur = $config['URL_BASE']."get_score_joueur.php?joueur_id=".$Session->joueur_id;
    $score_joueur = json_decode(file_get_contents($url_joueur));
    $url_association = $config['URL_BASE']."get_score_association.php?association_id=".$Session->association_id;
    $score_association = json_decode(file_get_contents($url_association));

?>

<div class="row">
    <div class="w-100">
        <iframe width="100%" height="300px" frameborder="0" allowfullscreen src="https://umap.openstreetmap.fr/en/map/gamedb_352489?scaleControl=false&miniMap=false&scrollWheelZoom=false&zoomControl=false&allowEdit=false&moreControl=false&searchControl=null&tilelayersControl=null&embedControl=null&datalayersControl=false&onLoadPanel=undefined&captionBar=false"></iframe>

    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-6 box-shadow my-2">
            <div class="card-body">
                <h4 class="card-title mb-4">Flasher un totem</h4>
                <form class="form" method="post" action="./create_scan.php">
                    <input type="text" name="totem_code" class="form-control" id="nom" placeholder="Scannez le qr code du totem"/>
                    <input type="hidden" name="joueur_id" class="form-control" value="<?php echo $Session->joueur_id;?>"/>
                    <input type="hidden" name="association_id" class="form-control" value="<?php echo $Session->association_id;?>"/>
                    <button class="btn btn-primary btn-lg btn-block my-2" type="submit">Scanner</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-6 box-shadow my-2">
            <div class="card-body">
                <h4 class="card-title">Mon score : <?php echo $score_joueur; ?></h4>
                <div id="tester" style="width:100%;height:200px;"></div>
                <p class="card-text">Score de mon association : <?php echo $score_association; ?></p>
            </div>
        </div>
    </div>
</div>


<?php
}
else {
?>

<div class="row">
    <!-- <div class="col-md-6">
        <div class="card mb-6 box-shadow my-2">
            <div class="card-body">
                <h4 class="card-title mb-4">Inscription</h4>
                <p class="card-text">Inscrivez-vous</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-6 box-shadow my-2">
            <div class="card-body">
                <h4 class="card-title mb-4">Connexion</h4>
                <p class="card-text">Connectez-vous</p>
            </div>
        </div>
    </div> -->
    <div class="col-md-6">
        <a class="btn btn-secondary btn-lg btn-block" role="button" href="/inscription.php">S'inscrire</a>
    </div>
    <div class="col-md-6">
        <a class="btn btn-outline-secondary btn-lg btn-block" role="button" href="./connexion.php">Se connecter</a>
    </div>
</div>

<?php
}

include('./include/front_footer.php'); ?>


<script src="./include/plot_score.js"></script>
