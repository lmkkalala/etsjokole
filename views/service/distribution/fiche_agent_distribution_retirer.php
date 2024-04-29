<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 include '../models/distribution/distribution.php';
 include '../models/crud/db.php';
 include '../models/livraison/livraison.php';
include '../models/affectation-service/affectationService.php';
include '../models/preparation/preparation.php';
include '../models/demande/demande.php';
?>

<legend>Liste vendu a retirer par le client</legend>
    <table class="table table-bordered table-striped table-responsive-lg">
        <thead>
        <th>
            Sale N°,
            N°,
            Date,
            Client
        </th>
        <th>
            Item
        </th>
        <th>
            Quantity
        </th>
        <th>
            Price (USD)
        </th>
        <th>
            Value HT (USD)
        </th>
        <th>
            Value TVA (USD)
        </th>
        <th>
            Value TTC (USD)
        </th>
        <th>
            Retirer
        </th>
        <th>
            Supprimer
        </th>
    </thead>
    <tbody>
        <div>
            <?php
            $n = 0;
            if (1) {
                $use =  $_SESSION['idaffectation'];
            } else {
                $use = 0;
            }
            
            $bddistribution = new BdDistribution();
            $db = new DB();
            // $distributions = $bddistribution->getDistributionAllDesc();
            $distributions = $db->getWhereMultiple('affectation','mutation_id ='.$use.' and typePaiement = "CASH_A_RETIRER"');
            
            $cumul_value = 0;
            $cumul_tva=0;
            $cumul_value_total=0;
            foreach ($distributions as $distribution) {

                    $affiche_bon = false;

                    $bdlivraison = new BdLivraison();
                    $livraisons = $bdlivraison->getLivraisonById($distribution['distribution_id']);
                    foreach ($livraisons as $livraison) {
                        $bddemande = new BdDemande();
                        $demandes = $bddemande->getDemandeById($livraison['demande_id']);
                        foreach ($demandes as $demande) {
                            $bdaffectation = new BdAffectationService();
                            $affectations = $bdaffectation->getAffectationServiceById($demande['mutation_id']);
                            foreach ($affectations as $affectation) {
                                if ($affectation['id'] == $use) {
                                    $affiche_bon = true;
                                }
                            }
                        }
                        $idaffectation_online = $livraison['dIdmutation'];
                        $infolivraison = $livraison['bDesignation'] . " : " . $livraison['marque'] . " / " . $livraison['gDesignation'];
                    }
                    if (isset($infolivraison) && ($affiche_bon) && ($distribution['nombre_restant'] > 0)) {
                        $n++;
            ?>
                        <tr>
                            <td>
                                <?= $distribution['venteposId'] ?><br>
                                <?= $distribution['id'] ?><br>
                                <?= $distribution['date'] ?><br>
                                <strong style="color: #0080c0;"><?= $distribution['identiteClient'] ?></strong>
                            </td>
                            <td><?= $infolivraison ?></td>
                            <td><?= $distribution['nombre_restant'] ?></td>
                            <td><?= $distribution['price'] ?></td>
                            <td style="color: dodgerblue;">
                                <?php
                                echo ($distribution['nombre_restant'] * $distribution['price']);
                                $cumul_value = $cumul_value + ($distribution['nombre_restant'] * $distribution['price']);
                                ?>
                            </td>
                            <td>
                                <?php 
                                echo (($distribution['nombre_restant'] * $distribution['price'])*($distribution['tva']/100));
                                $cumul_tva=$cumul_tva+ (($distribution['nombre_restant'] * $distribution['price'])*($distribution['tva']/100));
                                ?>
                            </td>
                            <td style="color: forestgreen; font-weight: 700;">
                                <?php
                                echo (($distribution['nombre_restant'] * $distribution['price'])*(1+($distribution['tva']/100)));
                                $cumul_value_total=$cumul_value_total+(($distribution['nombre_restant'] * $distribution['price'])*(1+($distribution['tva']/100)));
                                ?>
                            </td>
                            <td>
                                <div class="row">
                                    <?php if($distribution['typePaiement'] == 'CASH_A_RETIRER'){ ?>
                                    <div class="col-md-12">
                                        <form class="form-horizontal" method="POST" action="../contollers/distribution/distributionController.php">
                                            <div class="input-group-lg">
                                                <input type="text" class="form-control mt-1" name="tb_use_identiteClient" value="<?= $distribution['identiteClient'] ?>">
                                                <input type="date" class="form-control mt-1" name="tb_use_date" value="<?= $distribution['date'] ?>">
                                                <input class="btn btn-info text-white w-100 mt-1" type="submit" name="bt_RetirerDistribution" value="Retirer Quantite">
                                                <input type="hidden" name="quantiteVendu" value="<?= $distribution['nombre_restant'] ?>">
                                                <input type="hidden" name="typePaiement" value="<?= $distribution['typePaiement'] ?>">
                                                <input type="hidden" name="distribution_id" value="<?= $distribution['distribution_id'] ?>">
                                                <input type="hidden" name="tb_idaffectation" value="<?= $_SESSION['idaffectation'] ?>">
                                                <input type="hidden" name="tb_use_typerepas" value="<?= 'typerepas' ?>">
                                                <input type="hidden" name="tb_use_ventePOS" value="<?= $distribution['venteposId'] ?>">
                                                <input type="hidden" name="row_affectationID" value="<?= $distribution['id'] ?>">
                                            </div>
                                        </form>
                                    </div>
                                    <?php } ?>
                                </div>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-md-12 mt-2">
                                        <form class="form-horizontal" method="POST" action="../contollers/distribution/distributionController.php">
                                            <div class="input-group-lg">
                                                <input type="text" class="form-control mt-1" name="tb_use_identiteClient" value="<?= $distribution['identiteClient'] ?>">
                                                <input type="date" class="form-control mt-1" name="tb_use_date" value="<?= $distribution['date'] ?>">
                                                <input class="btn btn-danger w-100 mt-1" type="submit" name="bt_delete_lineDistribution" value="Delete">
                                                <input type="hidden" name="tb_idaffectation" value="<?= $_SESSION['idaffectation'] ?>">
                                                <input type="hidden" name="tb_distributionId" value="<?= $distribution['id'] ?>">
                                                <input type="hidden" name="typePaiement" value="<?= $distribution['typePaiement'] ?>">
                                                <input type="hidden" name="tb_use_typerepas" value="<?= 'typerepas' ?>">
                                                <input type="hidden" name="tb_use_ventePOS" value="<?= $distribution['venteposId'] ?>">
                                                <input type="hidden" name="row_affectationID" value="<?= $distribution['id'] ?>">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>

                        </tr>
                        <?php
                    }
            }
            ?>
            </tbody>
            <tfoot>
                <td>
                    <span>Nombre:</span><span><?= $n ?></span>
                </td>
                <td style="font-weight: bold; color: dodgerblue;">
                    <span> Total  HT : </span><span><?= $cumul_value ?> USD</span>
                </td>
                <td style="font-weight: bold;">
                    <span> Total TVA : </span><span><?= $cumul_tva ?> USD</span>
                </td>
                <td style="font-weight: bold; color: forestgreen;">
                    <span> Total TTC : </span><span><?= $cumul_value_total ?> USD</span>
                </td>
            </tfoot>
    </div>
</table>