<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/demande/demande.php';
include '../models/distribution/distribution.php';
include '../models/livraison/livraison.php';
include '../models/affectation-service/affectationService.php';
include '../models/service/service.php';
include '../models/unite/unite.php';
include '../models/preparation/preparation.php';
include '../models/ravitaillement/ravitaillement.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-cube" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-plus-square-o" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Preparation</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-bar-chart-o" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Statistiques</span>
    </div>
    <?php
    ?>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Taper la désignation de la catégorie :</legend>
                <form class="form-inline" method="POST" action="../contollers/preparation/preparationController.php">
                    <div class="form-group-lg">
                        <div class="input-group-lg">
                            <label class="control-label">Preparation :</label>
                            <select class="form-control select2" name="cb_preparation">
                                <option value="0">Choisir une preparation</option>
                                <?php
                                $bdpreparation = new BdPreparation();
                                $preparations = $bdpreparation->getPreparationByAffectationService($_SESSION['idaffectation']);
                                foreach ($preparations as $preparation) {
                                    if ($preparation['active']) {
                                        if (1) {
                                            ?>
                                            <option value="<?= $preparation['id'] ?>"><?= $preparation['dateHeure'] ?></option>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success" name="bt_search_for_preparation"><span class="glyphicon glyphicon-search" style="color: white; font-size: 20px;margin-right: 5px;"></span></button>
                    </div>
                </form>
            </fieldset>
            <legend style="color: orange; font-size: 20px;font-weight: bold;">
                <?php
                if ((isset($_GET['use_preparation'])) && ($_GET['use_preparation'] != 0)) {
                    $preparations = $bdpreparation->getPreparationById($_GET['use_preparation']);
                    foreach ($preparations as $preparation) {
                        echo "Preparation : ".$preparation['dateHeure'];
                    }
                } else {
                    echo "Choisir une preparation";
                }
                ?>
            </legend>
            <fieldset>
                <legend>Liste des distributions</legend>
                <table class="table table-bordered table-responsive-lg">
                    <thead>
                    <th>
                        N°
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        Livraison
                    </th>
                    
                    <th>
                        Total cost
                    </th>
                    <th>
                        Agent preneur
                    </th>
                    <th>
                        Quantité
                    </th>
                    <th>
                        Quantité non récuperée
                    </th>
                    <th>
                        Etat
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        if (isset($_GET['use'])) {
                            $use = $_GET['use'];
                        } else {
                            $use = 0;
                        }
                        $bddistribution = new BdDistribution();
                        if (isset($_GET['use_preparation'])) {
                            $distributions = $bddistribution->getDistributionByPreparationId($_GET['use_preparation']);
                        } else {
                            $distributions = $bddistribution->getDistributionAllDesc();
                        }
                        foreach ($distributions as $distribution) {

                            $affiche_bon = false;
//                            $bdmutation=new BdAffectationService();
//                            $affectations=$bdaffectation->getAffectationServiceByService($idservice);
                            $bdlivraison = new BdLivraison();
                            $livraisons = $bdlivraison->getLivraisonById($distribution['distribution_id']);
                            foreach ($livraisons as $livraison) {

                                $bdravitaillement = new BdRavitaillement();
                                $ravitaillements = $bdravitaillement->getRavitaillementById($livraison['lId']);
                                $bddemande = new BdDemande();
                                $demandes = $bddemande->getDemandeById($livraison['demande_id']);
                                foreach ($demandes as $demande) {
                                    $bdaffectation = new BdAffectationService();
                                    $affectations = $bdaffectation->getAffectationServiceById($demande['mutation_id']);
                                    foreach ($affectations as $affectation) {
                                        if (1) {
                                            $affiche_bon = true;
                                        }
                                    }
                                }
                                $idaffectation_online = $livraison['dIdmutation'];
                                $infolivraison = $livraison['lDate'] . " " . $livraison['bDesignation'] . " : " . $livraison['marque'] . " / " . $livraison['gDesignation'] . " / quantité initiale : " . $livraison['lQuantite'] . " / quantité actuelle : " . $livraison['quantite_actuelle'];
                            }
                            if (isset($infolivraison) && ($affiche_bon)) {
                                $chaine_part_ravitaillement = "";
                                $n++;
                                ?>
                                <tr>
                                    <td><?= $distribution['id'] ?></td>
                                    <td><?= $distribution['date'] ?></td>
                                    <td><?= $infolivraison ?></td>
                                    
                                    <td style="color:blue;font-size: 20px;font-weight: bold;">
                                        <?php
//                                      $chaine_part_ravitaillement;
                                        $items_ravitaillement = explode('-', $chaine_part_ravitaillement);
                                        $n_same_ravitaillement=0;
                                        $cumule_prix=0;
                                        foreach ($items_ravitaillement as $item) {
                                            
                                            if ((strlen($item)) == 1) {
                                                $bdravitaillement = new BdRavitaillement();
                                                $ravitaillements = $bdravitaillement->getRavitaillementById($item);
                                                $last = 0;
                                                $i = 0;
                                                $j = 0;
                                                $prix_item = 0;
                                                foreach ($ravitaillements as $ravitaillement) {
                                                    $i++;
//                                                    echo $item;
                                                }
                                                foreach ($ravitaillements as $ravitaillement) {
                                                    $cumule_prix=$cumule_prix+$ravitaillement['prix'];                                $j++;
                                                    
                                                }
                                            }
                                        }
                                        echo $cumule_prix." USD";
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $bdaffectation = new BdAffectationService();
                                        $affectations = $bdaffectation->getAffectationServiceByIdSecond($distribution['mutation_id']);
                                        foreach ($affectations as $affectation) {
                                            echo $affectation['nom'] . " " . $affectation['postnom'] . " " . $affectation['prenom'];
                                        }
                                        ?>
                                    </td>
                                    <td><?= $distribution['nombre'] ?></td>
                                    <td><?= $distribution['nombre_restant'] ?></td>
                                    <td>
                                        <?php
                                        if ($distribution['nombre_restant'] != 0) {
                                            ?>
                                            <h4 style="color: forestgreen;">Encours</h4>
                                            <?php
                                        } else {
                                            ?>
                                            <h4 style="color: red;">récuperée</h4>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                    <td style="font-size: 20px;">
                        <span>Nombre:</span><span><?= $n ?></span>
                    </td>
                    </tfoot>
                </table>
            </fieldset>
        </div>
    </div>
</div>

