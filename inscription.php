<?php
include('./include/front_header.php');
include('./create_joueur.php');
include('./get_associations.php');

if ($creationok === false) {
?>
<div class="row">
    <div class="col-md-12">
        <h3>Nouveau joueur</h3>
        <form class="form" method="post" action="./inscription.php">
            <div class="row">
                <div class="col-md-6 col-sm-12 mb-3">
                    <input type="text" name="nom" class="form-control" id="nom" placeholder="Nom"/>
                </div>
                <div class="col-md-6 col-sm-12 mb-3">
                    <input type="text" name="prenom" class="form-control" id="prenom" placeholder="Prénom"/>
                </div>
            </div>
            <div class="mb-3">
                <input type="text" name="mail" class="form-control" id="mail" placeholder="E-mail"/>
            </div>
            <div class="mb-3">
                <input type="text" name="pseudo" class="form-control" id="pseudo" placeholder="Pseudo"/>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" id="password" placeholder="Mot de passe"/>
            </div>
            <div class="mb-3">
                <select name="association_id" class="form-control">
                    <option value="0">Association</option>
                    <?php foreach ($associations as $asso) {
                        echo "<option value='".$asso['association_id']."'>".$asso['association_nom']."</option>";
                    } ?>
                </select>
            </div>
            <div class="col-md-12 mb-3">
                Votre association n'existe pas ? <a href="./create_association.php">Créez la</a>
            </div>
            <button class="btn btn-primary btn-lg btn-block" type="submit">Créer joueur</button>
        </form>
    </div>
</div>
<?php
}
else {
?>
    <div class="row">
        <div class="col-md-12">
            <h3>Joueur créé</h3>
        </div>
    </div>
<?php
}
 ?>


<?php include('./include/front_footer.php'); ?>
