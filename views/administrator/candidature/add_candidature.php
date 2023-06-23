<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/candidat/candidat.php';
include '../models/offre-emploie/OffreEmploie.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-bandcamp" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span><span class="h3">Canditature</span>
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
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == (sha1("doublons_error"))))) {
                ?>
                <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-refresh" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur de doublons, Recommencer SVP</span>
                </div>
                <?php
            }
            ?>

            <form class="form-horizontal" method="POST" action="../contollers/candidature/candidatureController.php">
                <div class="form-group-lg">
                    <div class="input-group-lg">
                        <label class="control-label">Date de la soummission :</label>
                        <input class="form-control" type="date" name="tb_datesoumission">
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Offre d'emploie :</label>
                        <select class="form-control select2" name="cb_offreemploie">
                            <option value="0">Choisir l'offre d'emploie</option>
                            <?php
                            $bdOffreEmploie = new BdOffreEmploie();
                            $offreemploies = $bdOffreEmploie->getOffreEmploieAllDesc();
                            foreach ($offreemploies as $offreemploie) {
                                if ($offreemploie['active']) {
                                    if (1) {
                                        ?>
                                        <option value="<?= $offreemploie['id'] ?>"><?= $offreemploie['numero'] . " / " . $offreemploie['libelle'] . " / Date lancement  : " . $offreemploie['dateLancement']. " / Date cloture : ". $offreemploie['dateCloture'] ?></option>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Candidat :</label>
                        <select class="form-control select2" name="cb_candidat">
                            <option value="0">Choose candidate</option>
                            <?php
                            $bdcandidat = new BdCandidat();
                            $candidats = $bdcandidat->getCandidatAllDesc();
                            foreach ($candidats as $candidat) {
                                if ($candidat['active']) {
                                    if (1) {
                                        ?>
                                        <option value="<?= $candidat['id'] ?>"><?= $candidat['nom'] . " " . $candidat['postnom'] . " " . $candidat['prenom']. " / sexe : ". $candidat['sexe'] ?></option>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </select>
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

