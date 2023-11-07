<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<legend>Sales list</legend>
<table class="table table-bordered table-striped table-responsive-lg">
    <thead>
    <th>
        Sale Number
    </th>
    <th>
        N°
    </th>
    <th>
        Date
    </th>
    <th>
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
        
    </th>
</thead>
<tbody>
    <?php
    $n = 0;
    if (1) {
        $use = $_SESSION['idservice'];
    } else {
        $use = 0;
    }
    
    $bddistribution = new BdDistribution();
    
    if (((isset($_GET['use_date1'])) && (isset($_GET['use_date2']))) && (($_GET['use_date1'] != "") && ($_GET['use_date2'] != ""))) {
        $distributions = $bddistribution->getDistributionBeetwen2Dates($_GET['use_date1'], $_GET['use_date2']);
    } else {
        $distributions = $bddistribution->getDistributionAllDesc();
    }

    if (!(isset($_GET['use_ventePOS']))) {
        $distributions=[];
    }
    
    $cumul_value = 0;
    $cumul_tva=0;
    $cumul_value_total=0;
    
    foreach ($distributions as $distribution) {

        if (($distribution['venteposId'] == $_GET['use_ventePOS'])) {

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
                        if ($affectation['service_id'] == $use) {
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
                    <td><?= $distribution['venteposId'] ?></td>
                    <td><?= $distribution['id'] ?></td>
                    <td><?= $distribution['date'] ?></td>
                    <td><strong style="color: #0080c0;"><?= $distribution['identiteClient'] ?></strong></td>
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
                        <form class="form-horizontal" method="POST" action="../contollers/distribution/distributionController.php">
                            <div class="input-group-lg">
                                <input class="btn btn-danger" type="submit" name="bt_delete_lineDistribution" value="Delete">
                                <input type="hidden" name="tb_idaffectation" value="<?= $_SESSION['idaffectation'] ?>">
                                <input type="hidden" name="tb_distributionId" value="<?= $distribution['id'] ?>">
                                
                                <input type="hidden" name="tb_use_date" value="<?= $_GET['use_date'] ?>">
                                <input type="hidden" name="tb_use_typerepas" value="<?= $_GET['use_typerepas'] ?>">
                                <input type="hidden" name="tb_use_identiteClient" value="<?= $_GET['use_identiteClient'] ?>">
                                <input type="hidden" name="tb_use_ventePOS" value="<?= $_GET['use_ventePOS'] ?>">
                            </div>
                        </form>
                    </td>

                </tr>
                <?php
            }
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
</table>

