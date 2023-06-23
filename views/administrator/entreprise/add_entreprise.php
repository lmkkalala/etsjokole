<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="glyphicon glyphicon-equalizer" style="color: red; font-size: 30px;margin-right: 5px;"></span><span class="h3">Configuration</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-cd" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Etape 1</span>
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
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == (sha1("upload_error"))))) {
                ?>
                <div class="alert alert-warning">
                    <span class="glyphicon glyphicon-blackboard" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur du téléchargement du logo, Recommencer SVP</span>
                </div>
                <?php
            }
            ?>

            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == (sha1("format_error"))))) {
                ?>
                <div class="alert alert-warning">
                    <span class="glyphicon glyphicon-blackboard" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur du téléchargement du logo, Mauvais format</span>
                </div>
                <?php
            }
            ?>
            <?php
            $bdentreprise = new BdEntreprise();
            $n = $bdentreprise->getRowCountEntreprise();
            if ($n == 0) {
                ?>
                <form class="form-horizontal" method="POST" action="../contollers/entreprise/entrepriseController.php" enctype="multipart/form-data">
                    <div class="form-group-lg">
                        <div class="input-group-lg">
                            <label class="control-label">Désignation :</label>
                            <input class="form-control" type="text" name="tb_designation" placeholder="Désignation">
                        </div>
                        <div class="input-group-lg">
                            <label class="control-label">Sigle :</label>
                            <input class="form-control" type="text" name="tb_sigle" placeholder="Sigle">
                        </div>
                        <div class="input-group-lg">
                            <label class="control-label">Logo :</label>
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
                <?php
            } else {
                ?>
            <fieldset>
                <legend>Récommandation</legend>
                <h2><span class="glyphicon glyphicon-exclamation-sign" style="color: forestgreen;margin: 10px;"></span>Le logiciel est déjà configuré</h2>
            </fieldset>
                <?php
            }
            ?>
        </div>

    </div>
</div>

