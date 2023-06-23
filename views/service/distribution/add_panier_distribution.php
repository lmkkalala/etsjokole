ï»¿<?php
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
        <span class="fa fa-cube" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-hand-stop-o" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Sales</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-shopping-cart" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Items</span>
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
            <form class="form-horizontal" method="POST" action="../contollers/distribution/distributionController.php">
                <fieldset>
                    <div class="form-group-lg">
                        <div class="input-group-lg">
                            <label class="control-label">Distribution :</label>
                            <select class="form-control" name="cb_distribution">
                                <option value="0">Choisir la distribution concernée : </option>
                                <?php
                                $panier_livraison = "";
                                $bddistribution = new BdDistribution();
                                $distributions = $bddistribution->getDistributionMax();
                                $iddistribution_considere = 0;
                                foreach ($distributions as $distribution) {
                                    $iddistribution_considere = $distribution['Id'];
                                }
                                ?>
                                <option value="0"><?= $iddistribution_considere ?> </option>
                                <?php
                                $distributions = $bddistribution->getDistributionById($iddistribution_considere);
                                foreach ($distributions as $distribution) {
                                    $bdlivraison = new BdLivraison();
                                    $livraisons = $bdlivraison->getLivraisonById($distribution['distribution_id']);
                                    foreach ($livraisons as $livraison) {
                                        ?>
                                        <option value="0"><?= $livraison['dIdmutation'] ?> </option>
                                        <?php
                                        $idaffectation_online = $livraison['dIdmutation'];
                                        $infolivraison = $livraison['lDate'] . " " . $livraison['bDesignation'] . " : " . $livraison['marque'] . " / " . $livraison['gDesignation'] . " / quantité initiale : " . $livraison['lQuantite'] . " / quantité actuelle : " . $livraison['quantite_actuelle'];
                                        $idbiens = $livraison['bId'];
                                        $panier_livraison = $livraison['panier'];
                                    }
                                    if ($idaffectation_online == $_SESSION['idaffectation']) {
                                        $bdaffectation = new BdAffectationService();
                                        $affectations = $bdaffectation->getAffectationServiceByIdSecond($distribution['mutation_id']);
                                        foreach ($affectations as $affectation) {
                                            $info_preneur = $affectation['nom'] . " " . $affectation['postnom'] . " " . $affectation['prenom'];
                                        }
                                        if (1) {
                                            ?>
                                            <option value="<?= $distribution['id'] ?>" selected><?= $livraison['lDate'] . " " . $livraison['bDesignation'] . " : " . $livraison['marque'] . " / " . $livraison['gDesignation'] . " pour " . $info_preneur . " / quantité total : " . $distribution['nombre'] . " / quantité non récuperée : " . $distribution['nombre_restant'] ?></option>
                                            <?php
                                            $quantite_choosen_distribution = $distribution['nombre'];
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
                    <legend></legend>
                    <div class="input-group-lg">
                        <input type="hidden" name="tb_idaffectation" value="<?= $_SESSION['idaffectation'] ?>">
                        <input type="hidden" name="tb_use_date" value="<?= $_GET['use_date'] ?>">
                        <input type="hidden" name="tb_use_typerepas" value="<?= $_GET['use_typerepas'] ?>">
                        <input type="hidden" name="tb_use_identiteClient" value="<?= $_GET['use_identiteClient'] ?>">
                        <input type="hidden" name="tb_use_ventePOS" value="<?= $_GET['use_ventePOS'] ?>">
                        <input class="btn btn-success" type="submit" name="bt_enregistrer_panier" value="Valider">
                    </div>
                </fieldset>
                <hr>
                <fieldset>
                    <legend>Sélectionner les unités</legend>
                    <?php
                    include 'liste_unite_by_idbiens.php';
                    
                    ?>
                </fieldset>
                
            </form>
        </div>
    </div>
</div>

