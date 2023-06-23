<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/attribution-biens/attributionBiens.php';
include '../models/demande/demande.php';
include '../models/livraison/livraison.php';
include '../models/biens/biens.php';
include '../models/unite/unite.php';
include '../models/distribution/distribution.php';
include '../models/recuperation/recuperation.php';
include '../models/affectation-service/affectationService.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-cube" style="color: #0069d9; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-recycle" style="color: #0069d9; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Gestion des récuperations</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-shopping-cart" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Panier de récuperation</span>
    </div>
    <div class="panel panel-body">
        <div>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("succes")))) {
                ?>
                <div class="alert alert-success">
                    <span class="glyphicon glyphicon-ok" style="font-size: 15px;margin-right: 5px;"></span><span>Enregistrement effectué avec succès</span>
                </div>
                <?php
            }
            ?>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("traitement_error")))) {
                ?>
                <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-ban-circle" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur d'enregistrement</span>
                </div>
                <?php
            }
            ?>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("remplissage_error")))) {
                ?>
                <div class="alert alert-warning">
                    <span class="glyphicon glyphicon-blackboard" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur de remplissage, Recommencer SVP</span>
                </div>
                <?php
            }
            ?>
            <form class="form-horizontal" method="POST" action="../contollers/recuperation/recuperationController.php">
                <fieldset>
                    <div class="form-group-lg">
                        <div class="input-group-lg">
                            <label class="control-label">Récuperation :</label>
                            <select class="form-control" name="cb_recuperation">
                                <?php
                                $panier_recuperation = "";
                                $bdrecuperation = new BdRecuperation();
                                $bddistribution = new BdDistribution();
                                $recuperations = $bdrecuperation->getRecuperationMax();
				$quantite_choosen_recuperation_service=0;
                                foreach ($recuperations as $recuperation) {
                                    $idrecuperation = $recuperation['Id'];
                                }
                                $recuperations = $bdrecuperation->getRecuperationById($idrecuperation);
                                foreach ($recuperations as $recuperation) {
                                    $iddistribution_concerne = $recuperation['distribution_id'];
                                }
                                $distributions = $bddistribution->getDistributionById($iddistribution_concerne);
                                foreach ($distributions as $distribution) {
                                    $panier_recuperation = $distribution['panier'];
                                    $bdlivraison = new BdLivraison();
                                    $livraisons = $bdlivraison->getLivraisonById($distribution['distribution_id']);
                                    foreach ($livraisons as $livraison) {
                                        $idaffectation_online = $livraison['dIdmutation'];
                                        $infolivraison = $livraison['lDate'] . " " . $livraison['bDesignation'] . " : " . $livraison['marque'] . " / " . $livraison['gDesignation'] . " / quantité initiale : " . $livraison['lQuantite'] . " / quantité actuelle : " . $livraison['quantite_actuelle'];
                                        $idbiens = $livraison['bId'];
                                    }
                                    if ($idaffectation_online == $_SESSION['idaffectation']) {
                                        $bdaffectation = new BdAffectationService();
                                        $affectations = $bdaffectation->getAffectationServiceByIdSecond($distribution['mutation_id']);
                                        foreach ($affectations as $affectation) {
                                            $info_preneur = $affectation['nom'] . " " . $affectation['postnom'] . " " . $affectation['prenom'];
                                        }
                                        if ($recuperation['panier']=="") {
                                            ?>
                                            <option value="<?= $idrecuperation ?>" selected><?= $recuperation['date'] . " " . $livraison['bDesignation'] . " : " . $livraison['marque'] . " / " . $livraison['gDesignation'] . " pour " . $info_preneur . " / quantité total : " . $recuperation['quantite'] ?></option>
                                            <?php
                                            $quantite_choosen_recuperation_service=$recuperation['quantite'];
                                        } else {
                                            ?>
                                            <option value="0">Aucune récuperation en attente</option>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </fieldset>
                <br>

                <fieldset>
                    <legend>Sélectionner les unités</legend>
                    <?php
                    include 'liste_unite_by_idbiens.php';
                    ?>
                </fieldset>
                <fieldset>
                    <legend></legend>
                    <div class="input-group-lg">
                        <input class="btn btn-success" type="submit" name="bt_enregistrer_panier" value="Enregistrer">
                        <input class="btn btn-danger" type="reset" value="Initialiser">
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>

