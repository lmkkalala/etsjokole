<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="glyphicon glyphicon-user" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span><span class="h3">Agent</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-asterisk" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">New</span>
    </div>
    <div class="panel panel-body">
        <div>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == "succes"))) {
                ?>
                <div class="alert alert-success">
                    <span class="glyphicon glyphicon-ok" style="font-size: 15px;margin-right: 5px;"></span><span>Enregistrement effectué avec succès</span>
                </div>
                <?php
            }
            ?>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == "traitement_error"))) {
                ?>
                <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-ban-circle" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur d'enregistrement</span>
                </div>
                <?php
            }
            ?>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == "remplissage_error"))) {
                ?>
                <div class="alert alert-warning">
                    <span class="glyphicon glyphicon-blackboard" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur de remplissage, Recommencer SVP</span>
                </div>
                <?php
            }
            ?>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == "format_error"))) {
                ?>
                <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-file" style="font-size: 15px;margin-right: 5px;"></span><span>Format non pris en charge, Recommencer SVP</span>
                </div>
                <?php
            }
            ?>

            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == "upload_error"))) {
                ?>
                <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-file" style="font-size: 15px;margin-right: 5px;"></span><span>Le fichier n'a pas été charger, Recommencer SVP</span>
                </div>
                <?php
            }
            ?>

            <form class="form-horizontal" method="POST" action="../contollers/agent/agentController.php" enctype="multipart/form-data">
                <div class="form-group-lg">
                    <div class="input-group-lg">
                        <label class="control-label">Nom :</label>
                        <input class="form-control" type="text" name="tb_nom" placeholder="Nom" required>
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Postnom :</label>
                        <input class="form-control" type="text" name="tb_postnom" placeholder="Post-nom" required>
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Prénom :</label>
                        <input class="form-control" type="text" name="tb_prenom" placeholder="Prénom" required>
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Sexe :</label>
                        <input class="radio-inline" type="radio" name="rb_sexe" value="h" checked>Homme
                        <input class="radio-inline" type="radio" name="rb_sexe" value="f">Femme
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Grade :</label>
                        <input class="form-control" type="text" name="tb_grade" placeholder="Grade" value="Seller" required>
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Code barre :</label>
                        <input class="form-control" type="text" name="tb_codebar" placeholder="Code barre" required>
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Photo agent :</label>
                        <input class="form-control" type="file" name="tb_file">
                    </div>
                    <fieldset>
                        <legend></legend>
                        <div class="input-group-lg">
                            <input class="btn btn-success" type="submit" name="bt_enregistrer" value="Enregistrer">
                            <input class="btn btn-danger" type="reset" value="Initialiser">
                        </div>
                    </fieldset>
                </div>
            </form>
        </div>

    </div>
</div>

