<?php include('./include/front_header.php');
include('./get_score_joueur.php');
include('./get_score_association.php');

if (isset($Session->connected) && $Session->connected == true) {

?>


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
                <h4 class="card-title">Mon score</h4>
                <p class="card-text"><?php echo $score_joueur; ?></p>
                <div id="tester" style="width:100%;height:200px;"></div>
            </div>
        </div>
    </div>
</div>


<?php
}
else {
?>

<div class="row">
    <div class="col-md-6">
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
    </div>
</div>

<?php
}

include('./include/front_footer.php'); ?>


<script src="./include/plot_score.js"></script>
