<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/ravitaillement/ravitaillement.php';
include '../models/attribution-biens/attributionBiens.php';
include '../models/unite/unite.php';
include '../models/biens/biens.php';
include '../models/fournisseur/fournisseur.php';
include '../models/addsin/AddsIn.php';
include '../models/costing/Costing.php';

?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-usd" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-plus-square-o" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Cost adds-in</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-asterisk" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">New</span>
    </div>
    <div class="panel panel-body">
        <div>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("succes")))) {
            ?>
                <div class="alert alert-success">
                    <span class="glyphicon glyphicon-ok" style="font-size: 15px;margin-right: 5px;"></span><span>Success</span>
                </div>
            <?php
            }
            ?>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("traitement_error")))) {
            ?>
                <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-ban-circle" style="font-size: 15px;margin-right: 5px;"></span><span>Error</span>
                </div>
            <?php
            }
            ?>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("remplissage_error")))) {
            ?>
                <div class="alert alert-warning">
                    <span class="glyphicon glyphicon-blackboard" style="font-size: 15px;margin-right: 5px;"></span><span>Data error</span>
                </div>
            <?php
            }
            ?>
            <fieldset>
                <legend>
                    <strong style="color: forestgreen; font-size: 30px;">
                    <?php
                    $bdAddsIn = new BdAddsIn();
                    $addsIns = $bdAddsIn->getAddsInById($_GET['use_addsin']);
                    foreach ($addsIns as $addsIn) {
                        echo $addsIn['designation'];
                    }
                    ?>
                    </strong>
                </legend>
            </fieldset>
            <fieldset>
                <legend>Cost adds-in</legend>
                <table class="table table-dark table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>Date</th>
                            <th>Adds-in</th>
                            <th>Quantité</th>
                            <th>Prix</th>
                            <th>Value</th>
                            <th>Receipt</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $c = 0;
                        $cumul_costing = 0;
                        $bdCosting = new BdCosting();
                        $costings = $bdCosting->getCostingByAddsInId($_GET['use_addsin']);
                        foreach ($costings as $costing) {
                            $c++;
                        ?>
                            <tr>
                                <td><?= $costing['dateSet'] ?></td>
                                <td><strong><?= $costing['designation'] ?></strong></td>
                                <td><?= $costing['quantite'] ?></td>
                                <td><?= $costing['prix'] ?> USD</td>
                                <td><strong style="color: #0080c0;"><?= ($costing['quantite'] * $costing['prix']) ?> USD</strong></td>
                                <td>
                                    <?php
                                    $cumul_total_fournisseur = 0;
                                    $cumul_TVA_fournisseur = 0;
                                    $n = 0;
                                    $BdRavitaillement = new BdRavitaillement();
                                    $ravitaillements = $BdRavitaillement->getRavitaillementByIdSecond($costing['sId']);
                                    foreach ($ravitaillements as $ravitaillement) {
                                        if (1) {
                                            $n++;
                                            $chaine_part_ravitaillement_sortie = "";
                                            $chaine_part_ravitaillement_reste = "";
                                            echo  $ravitaillement['date'];


                                            $date_ravitaillement = $ravitaillement['date'];
                                            $bdattributionbiens = new BdAttributionBiens();
                                            $attributions = $bdattributionbiens->getAttributionBiensById($ravitaillement['attribution_id']);
                                            foreach ($attributions as $attribution) {
                                                echo " / Item : " . $attribution['bDesignation'] . " / Supplier : " . $attribution['fDesignation'];
                                                $id_attributionbiens = $attribution['aId'];
                                                $quantite_biens = $attribution['quantite'];
                                            }
                                            echo " / Qty : " . $ravitaillement['quantite'];
                                            echo " / Prix : " . $ravitaillement['prix'] . " USD";
                                            echo " / Value : " . ($ravitaillement['quantite'] * $ravitaillement['prix']) . " USD";

                                            $cumul_total_fournisseur = $cumul_total_fournisseur + ($ravitaillement['quantite'] * $ravitaillement['prix']);
                                        }
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php
                            $cumul_costing = $cumul_costing + ($costing['quantite'] * $costing['prix']);
                        }
                        ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th><strong> # : <?= $c  ?></strong></th>
                            <th><strong style="color: forestgreen;"> Total value : <?= $cumul_costing  ?> USD</strong></th>
                        </tr>
                    </tfoot>
                </table>
            </fieldset>
        </div>

    </div>
</div>