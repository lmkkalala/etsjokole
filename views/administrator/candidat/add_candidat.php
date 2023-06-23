<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-bandcamp" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span><span class="h3">Candidat</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-asterisk" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">New</span>
    </div>
    <div class="panel panel-body">
        <div>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == (sha1("succes"))))) {
                ?>
                <div class="alert alert-success">
                    <span class="glyphicon glyphicon-ok" style="font-size: 15px;margin-right: 5px;"></span><span>Enregistrement effectué avec succès</span>
                </div>
                <?php
            }
            ?>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == (sha1("traitement_error"))))) {
                ?>
                <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-ban-circle" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur d'enregistrement</span>
                </div>
                <?php
            }
            ?>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == (sha1("remplissage_error"))))) {
                ?>
                <div class="alert alert-warning">
                    <span class="glyphicon glyphicon-blackboard" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur de remplissage, Recommencer SVP</span>
                </div>
                <?php
            }
            ?>

            <form class="form-horizontal" method="POST" action="../contollers/candidat/candidatController.php">
                <div class="form-group-lg">
                    <div class="input-group-lg">
                        <label class="control-label">Nom :</label>
                        <input class="form-control" type="text" name="tb_nom" placeholder="Nom">
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Post-nom :</label>
                        <input class="form-control" type="text" name="tb_postnom" placeholder="Post-nom">
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Prenom :</label>
                        <input class="form-control" type="text" name="tb_prenom" placeholder="Prenom">
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Sexe :</label>
                        <input type="radio" name="rb_sexe" value="M">Masculin
                        <input type="radio" name="rb_sexe" value="F">Feminin
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Nationalité :</label>
                        <input class="form-control" type="text" name="tb_nationalite" placeholder="Nationalité">
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Adresse :</label>
                        <input class="form-control" type="text" name="tb_adresse" placeholder="Adresse">
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Date de naissance :</label>
                        <input class="form-control" type="date" name="tb_datenaissance" placeholder="Date de naissance">
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Lieu de naissance :</label>
                        <input class="form-control" type="text" name="tb_lieunaissance" placeholder="Lieu de naissance">
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Téléphone :</label>
                        <input class="form-control" type="text" name="tb_telephone" placeholder="Téléphone">
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Email :</label>
                        <input class="form-control" type="text" name="tb_email" placeholder="Email">
                    </div>
                    <fieldset>
                        <legend></legend>
                        <div class="input-group-lg">
                            <input class="btn btn-success" type="submit" name="bt_enregistrer" value="Save">
                            <input class="btn btn-danger" type="reset" value="Reset">
                        </div>
                    </fieldset>
                </div>
            </form>
        </div>

    </div>
</div>

