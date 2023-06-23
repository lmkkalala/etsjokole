<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/livrepaie/LivrePaie.php';
include '../models/promotion/Promotion.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-bandcamp" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span><span class="h3">Bulletin de paie</span>
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
                    <span class="glyphicon glyphicon-blackboard" style="font-size: 25px;margin-right: 5px;"></span><span style="font-size: 20px;">Erreur de remplissage, Recommencer SVP</span>
                </div>
                <?php
            }
            ?>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == (sha1("doublons_error"))))) {
                ?>
                <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-refresh" style="font-size: 15px;margin-right: 5px;"></span><span>Doublons, Mois et année déjà enregistrés</span>
                </div>
                <?php
            }
            ?>

            <form class="form-horizontal" method="POST" action="../contollers/bulletin/bulletinController.php">
                <div class="form-group-lg">
                    <div class="input-group-lg">
                        <label class="control-label">Livre de paie :</label>
                        <select class="form-control select2" name="cb_livrepaie">
                            <option value="0">Choisir le livre de paie</option>
                            <?php
                            $bdlivrepaie = new BdLivrePaie();
                            $livrepaies = $bdlivrepaie->getLivrePaieAllDesc();
                            foreach ($livrepaies as $livrepaie) {
                                if ($livrepaie['active']) {
                                    if (1) {
                                        ?>
                                        <option value="<?= $livrepaie['id'] ?>"><?= "Mois : ".$livrepaie['mois'] . " / Année : " . $livrepaie['annee'] ?></option>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Employé :</label>
                        <select class="form-control select2" name="cb_affectationservice">
                            <option value="0">Choisir l'employé</option>
                            <?php
                            $bdpromotion = new BdPromotion();
                            $promotions = $bdpromotion->getPromotionAllDesc();
                            foreach ($promotions as $promotion) {
                                if ($promotion['afActive']) {
                                    if (1) {
                                        ?>
                                        <option value="<?= $promotion['afId'] ?>"><?= "Matricule: ". $promotion['matricule']." / ".$promotion['nom'] . " " . $promotion['postnom']. " " . $promotion['prenom']. " (Service: " . $promotion['sDesignation']. " / Fonction: " . $promotion['fDesignation']. " / Contrat: " . $promotion['tcDesignation']. " / Catégorie: " . $promotion['ctDesignation'].")" ?></option>
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
                            <input class="btn btn-success" type="submit" name="bt_continuer" value="Next step">
                            <input class="btn btn-danger" type="reset" value="Reset">
                        </div>
                    </fieldset>
                </div>
            </form>
        </div>

    </div>
</div>

