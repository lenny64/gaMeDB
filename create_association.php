<?php
include('./include/front_header.php');
include('./get_associations.php');

$creationok = false;

if (isset($_POST['nom']) && isset($_POST['localisation'])) {
    if ($_POST['nom'] != NULL && $_POST['localisation'] != NULL) {
        $nom = mysqli_real_escape_string($db, $_POST['nom']);
        $localisation = mysqli_real_escape_string($db, $_POST['localisation']);
        $creationok = true;
    }
}

if ($creationok == true) {
mysqli_query($db, 'INSERT INTO associations (association_nom,
                                            association_localisation)
                                    VALUES ("'.$nom.'",
                                            "'.$localisation.'");');
}

if ($creationok == false) {
?>
<div class="row">
    <div class="col-md-12">
        <h3>Nouvelle association</h3>
        <form class="form" method="post" action="./create_association.php">
            <div class="row">
                <div class="col-md-6 col-sm-12 mb-3">
                    <input type="text" name="nom" class="form-control" id="nom" placeholder="Nom"/>
                </div>
                <div class="col-md-6 col-sm-12 mb-3">
                    <input type="text" name="localisation" class="form-control" id="localisation" placeholder="Localisation"/>
                </div>
            </div>
            <button class="btn btn-primary btn-lg btn-block" type="submit">Créer association</button>
        </form>
    </div>
</div>
<?php
}
else {
?>
    <div class="row">
        <div class="col-md-12">
            <h3>Association créée</h3>
        </div>
    </div>
<?php
}
include('./include/front_footer.php'); ?>
