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
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-cube" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-hand-stop-o" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Gestion des distributions</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-list-ol" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-check-circle-o" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Liste des distributions récuperées</span>
    </div>
    <?php
    $link = "service_distribution_liste_distribution_totale";
    include("select_service.php");
    ?>
    <div class="panel panel-body">
        <div>
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
                        Unités
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
                            $use=$_GET['use'];
                        } else {
                            $use=0;
                        }
                        $bddistribution = new BdDistribution();
                        $distributions = $bddistribution->getDistributionAllDesc();
                        foreach ($distributions as $distribution) {
                            $affiche_bon=false;
                            //$bdmutation=new BdAffectationService();
                            //$affectations=$bdaffectation->getAffectationServiceByService($idservice);
                            $bdlivraison = new BdLivraison();
                            $livraisons = $bdlivraison->getLivraisonById($distribution['distribution_id']);
                            foreach ($livraisons as $livraison) {
                                $bddemande=new BdDemande();
                                $demandes=$bddemande->getDemandeById($livraison['demande_id']);
                                foreach ($demandes as $demande) {
                                    $bdaffectation=new BdAffectationService();
                                    $affectations=$bdaffectation->getAffectationServiceById($demande['mutation_id']);
                                    foreach ($affectations as $affectation) {
                                        if ($affectation['service_id']==$use) {
                                            $affiche_bon=true;
                                        }
                                    }
                                }
                                $idaffectation_online = $livraison['dIdmutation'];
                                $infolivraison = $livraison['lDate'] . " " . $livraison['bDesignation'] . " : " . $livraison['marque'] . " / " . $livraison['gDesignation'] . " / quantité initiale : " . $livraison['lQuantite'] . " / quantité actuelle : " . $livraison['quantite_actuelle'];
                            }
                            if ((isset($infolivraison)) && ($distribution['nombre_restant'] == 0) && ($affiche_bon)) {
                                $n++;
                        ?>
                        <tr>
                            <td><?= $distribution['id'] ?></td>
                            <td><?= $distribution['date'] ?></td>
                            <td><?= $infolivraison ?></td>
                            <td>
                                <?php
                                $paniers = explode("/", $distribution['panier']);
                                $code = "";
                                $bdunite = new BdUnite();
                                $unites = $bdunite->getUniteAllDesc();
                                foreach ($unites as $unite) {
                                    foreach ($paniers as $pan) {
                                        if (($pan != "") && ($pan == $unite['id']) && (1)) {
                                            $code = $code . " / " . $unite['code'];
                                        }
                                    }
                                }
                                echo $code;
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

