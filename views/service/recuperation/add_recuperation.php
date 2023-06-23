<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/affectation-service/affectationService.php';
include '../models/livraison/livraison.php';
include '../models/demande/demande.php';
include '../models/distribution/distribution.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-cube" style="color: #0069d9; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-recycle" style="color: #0069d9; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Gestion des récuperations</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-asterisk" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Nouvelle récuperation</span>
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
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("quantite_error")))) {
                ?>
                <div class="alert alert-warning">
                    <span class="glyphicon glyphicon-edit" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur de la quantité, Recommencer SVP</span>
                </div>
                <?php
            }
            ?>

            <form class="form-horizontal" method="POST" action="../contollers/recuperation/recuperationController.php">
                <div class="form-group-lg">
                    <div class="input-group-lg">
                        <label class="control-label">Date :</label>
                        <input class="form-control" type="date" name="tb_date">
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Items /  Sale :</label>
                        <select class="form-control select2" name="cb_distribution">
                            <option value="0">Choisir une livraison à utiliser : </option>
                            <?php
                            $bddistribution = new BdDistribution();
                            $distributions = $bddistribution->getDistributionDescQuantitePositive();
                            foreach ($distributions as $distribution) {
                                $bdlivraison = new BdLivraison();
                                $livraisons = $bdlivraison->getLivraisonById($distribution['distribution_id']);
                                foreach ($livraisons as $livraison) {
                                    $idaffectation_online = $livraison['dIdmutation'];
                                    $infolivraison = $livraison['lDate'] . " " . $livraison['bDesignation'] . " : " . $livraison['marque'] . " / " . $livraison['gDesignation'] . " / quantité initiale : " . $livraison['lQuantite'] . " / quantité actuelle : " . $livraison['quantite_actuelle'];
                                }
                                if ($idaffectation_online == $_SESSION['idaffectation']) {
                                    $bdaffectation = new BdAffectationService();
                                    $affectations = $bdaffectation->getAffectationServiceByIdSecond($distribution['mutation_id']);
                                    foreach ($affectations as $affectation) {
                                        $info_preneur = $affectation['nom'] . " " . $affectation['postnom'] . " " . $affectation['prenom'];
                                    }
                                    if (1) {
                                        ?>
                                        <option value="<?= $distribution['id'] ?>"><?= $livraison['lDate'] . " " . $livraison['bDesignation'] . " / " . $livraison['gDesignation'] . " pour " . $info_preneur . " / quantité total : " . $distribution['nombre'] . " / quantité non récuperée : " . $distribution['nombre_restant'] ?></option>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Quantity :</label>
                        <input class="form-control" type="number" name="tb_quantite" placeholder="Quantité">
                    </div>
                    <fieldset>
                        <legend></legend>
                        <div class="input-group-lg">
                            <input type="hidden" name="tb_idaffectation" value="<?= $_SESSION['idaffectation'] ?>">
                            <input class="btn btn-success" type="submit" name="bt_enregistrer" value="Enregistrer">
                            <input class="btn btn-danger" type="reset" value="Initialiser">
                        </div>
                    </fieldset>
                </div>
            </form>
        </div>

    </div>
</div>

