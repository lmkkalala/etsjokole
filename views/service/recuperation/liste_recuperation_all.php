<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/demande/demande.php';
include '../models/distribution/distribution.php';
include '../models/livraison/livraison.php';
include '../models/recuperation/recuperation.php';
include '../models/affectation-service/affectationService.php';
include '../models/unite/unite.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-cube" style="color: #0069d9; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-recycle" style="color: #0069d9; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Gestion des récuperations</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-list-ol" style="color: darkgray; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Liste des toutes les récuperations</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Liste des récuperations</legend>
                <table class="table table-bordered table-responsive-lg">
                    <thead>
                    <th>
                        N°
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        Distribution
                    </th>
                    <th>
                        Les unités
                    </th>
                    <th>
                        Agent preneur
                    </th>
                    <th>
                        Quantité récuperée
                    </th>
                    <th>
                        Quantité initiale de la distribution
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
                        $bdrecuperation = new BdRecuperation();
                        $recuperations = $bdrecuperation->getRecuperationAllDesc();
                        foreach ($recuperations as $recuperation) {
                            $bddistribution = new BdDistribution();
                            $distributions = $bddistribution->getDistributionById($recuperation['distribution_id']);
                            foreach ($distributions as $distribution) {
                                $bdlivraison = new BdLivraison();
                                $livraisons = $bdlivraison->getLivraisonById($distribution['distribution_id']);
                                foreach ($livraisons as $livraison) {
                                    $idaffectation_online = $livraison['dIdmutation'];
                                    $infolivraison = $livraison['lDate'] . " " . $livraison['bDesignation'] . " : " . $livraison['marque'] . " / " . $livraison['gDesignation'] . " / quantité initiale : " . $livraison['lQuantite'] . " / quantité actuelle : " . $livraison['quantite_actuelle'];
                                    $idbiens = $livraison['bId'];
                                }
                                if ($idaffectation_online == $_SESSION['idaffectation']) {
                                    $n++;
                                    ?>
                                    <tr>
                                        <td><?= $recuperation['id'] ?></td>
                                        <td><?= $recuperation['date'] ?></td>
                                        <td><?= $infolivraison ?></td>
                                        <td>
                                            <?php
                                            $paniers = explode("/", $recuperation['panier']);
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
                                        <td><?= $recuperation['quantite'] ?></td>
                                        <td><?= $distribution['nombre'] ?></td>
                                        <td><?= $distribution['nombre_restant'] ?></td>
                                        <td>
                                            <?php
                                            if ($distribution['nombre_restant'] == 0) {
                                                ?>
                                                <h4 style="color: forestgreen;">Totale</h4>
                                                <?php
                                            } else {
                                                ?>
                                                <h4 style="color: red;">Partielle</h4>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
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

