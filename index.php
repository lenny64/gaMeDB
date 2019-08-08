<?php
include('./include/front_header.php');

if (isset($Session->connected) && $Session->connected == true) {

    $url_joueur = $config['URL_BASE']."get_score_joueur.php?joueur_id=".$Session->joueur_id;
    $score_joueur = json_decode(file_get_contents($url_joueur));
    $url_association = $config['URL_BASE']."get_score_association.php?association_id=".$Session->association_id;
    $score_association = json_decode(file_get_contents($url_association));

?>

<script type="text/javascript" src="./include/jsqrcode-master/grid.js"></script>
<script type="text/javascript" src="./include/jsqrcode-master/version.js"></script>
<script type="text/javascript" src="./include/jsqrcode-master/detector.js"></script>
<script type="text/javascript" src="./include/jsqrcode-master/formatinf.js"></script>
<script type="text/javascript" src="./include/jsqrcode-master/errorlevel.js"></script>
<script type="text/javascript" src="./include/jsqrcode-master/bitmat.js"></script>
<script type="text/javascript" src="./include/jsqrcode-master/datablock.js"></script>
<script type="text/javascript" src="./include/jsqrcode-master/bmparser.js"></script>
<script type="text/javascript" src="./include/jsqrcode-master/datamask.js"></script>
<script type="text/javascript" src="./include/jsqrcode-master/rsdecoder.js"></script>
<script type="text/javascript" src="./include/jsqrcode-master/gf256poly.js"></script>
<script type="text/javascript" src="./include/jsqrcode-master/gf256.js"></script>
<script type="text/javascript" src="./include/jsqrcode-master/decoder.js"></script>
<script type="text/javascript" src="./include/jsqrcode-master/qrcode.js"></script>
<script type="text/javascript" src="./include/jsqrcode-master/findpat.js"></script>
<script type="text/javascript" src="./include/jsqrcode-master/alignpat.js"></script>
<script type="text/javascript" src="./include/jsqrcode-master/databr.js"></script>
<script type="text/javascript" src="./include/qrcode.js"></script>
<link rel="stylesheet" href="css/custom.css">

<div class="modal" tabindex="-1" role="dialog" id="exampleModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="modalText"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="col-md-12 mb-4">
    <form class="form" method="post" action="./create_scan.php">
        <input type="file" accept="image/*" capture="environment" onchange="openQRCamera(this);" tabindex=-1 class="form-control" id="input-image"/>
        <label for="input-image" id="label-input-image" class="btn btn-primary my-2 col-md-12 btn-lg"><i class="fas fa-qrcode"></i> Flasher un totem</label>
    </form>
</div>
<div class="row">
    <div class="w-100">
        <iframe width="100%" height="300px" frameborder="0" allowfullscreen src="https://umap.openstreetmap.fr/en/map/gamedb_352489?scaleControl=false&miniMap=false&scrollWheelZoom=false&zoomControl=false&allowEdit=false&moreControl=false&searchControl=null&tilelayersControl=null&embedControl=null&datalayersControl=false&onLoadPanel=undefined&captionBar=false"></iframe>
    </div>
</div>
<div class="col-md-12 mt-4">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Mon score : <?php echo $score_joueur; ?></h4>
            <div id="tester" style="width:100%;height:200px;"></div>
            <p class="card-text">Score de mon association : <?php echo $score_association; ?></p>
        </div>
    </div>
</div>


<?php
}
else {
?>

<div class="row">
    <div class="col-md-6">
        <a class="btn btn-secondary btn-lg btn-block" role="button" href="./inscription.php">S'inscrire</a>
    </div>
    <div class="col-md-6">
        <a class="btn btn-outline-secondary btn-lg btn-block" role="button" href="./connexion.php">Se connecter</a>
    </div>
</div>

<?php
}

include('./include/front_footer.php'); ?>


<script src="./include/plot_score.js"></script>
