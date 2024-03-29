<?php include('./include/front_header.php'); ?>


<div class="row">
    <div class="col-md-12">
        <div class="card mb-12 box-shadow my-2">
            <div class="card-body">
                <h4 class="card-title">Connexion</h4>
                <form class="form" method="post" action="./index.php?connexion">
                    <div class="mb-3 form-group">
                        <input type="text" name="pseudo" class="form-control" id="pseudo" placeholder="Pseudo"/>
                    </div>
                    <div class="mb-3 form-group">
                        <input type="password" name="password" class="form-control" id="password" placeholder="Mot de passe"/>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" name="rememberMe" id="rememberMe"/>
                        <label class="form-check-label" for="rememberMe">Se souvenir de moi</label>
                    </div>
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Connexion</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('./include/front_footer.php'); ?>
