<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/ravitaillement/ravitaillement.php';
include '../models/attribution-biens/attributionBiens.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-cubes" style="color: darkorange; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-plus-square-o" style="color: darkorange; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Receipts</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-bomb" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Expired alert</span>
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
            <fieldset>
                <legend>Les ravitaillements</legend>
                <table class="table table-bordered table-responsive-lg table-striped">
                    <thead>
                    <th>
                        N°
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        Order
                    </th>
                    <th>
                        Quantity
                    </th>
                    <th>
                        UP (USD)
                    </th>
                    <th>
                        Value (USD)
                    </th>
                    <th>
                        Date d'expiration
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $bien_id = '';
                        $n = 0;
                        $bdravitaillement = new BdRavitaillement();
                        $valeur = "";
                        $valeur = date_add(date_create(date('Y-m-d')), date_interval_create_from_date_string('30 days'));
                        // $ravitaillements = $bdravitaillement->getRavitaillementBetweenDateExpiration(date_format(date_create(date('Y-m-d')),'Y-m-d'),date_format($valeur,"Y-m-d"));
                        $ravitaillements = $bdravitaillement->getRavitaillementAllDesc();
//                        echo date_format(date_create(date('Y-m-d')), 'Y-m-d');
//                        echo date_format($valeur, "Y-m-d");
                        foreach ($ravitaillements as $ravitaillement) {
                            if (($ravitaillement['dateExpiration'] <= date_format($valeur, "Y-m-d") && ($ravitaillement['dateExpiration'] >= date_format(date_create(date('Y-m-d')), 'Y-m-d'))) && (1)) {
                                $n++;
                                $reste_vide = false;
                                $bdattributionbiens = new BdAttributionBiens();
                                $attributions = $bdattributionbiens->getAttributionBiensById($ravitaillement['attribution_id']);
                                foreach ($attributions as $attribution) {
                                    if ($attribution['quantite'] == 0) {
                                        $reste_vide = true;
                                    }else{
                                        $reste_vide = false;
                                    }
                                }
                                if ($reste_vide == true) {
                                    ?>
                                    <tr>
                                        <td><?= $ravitaillement['id'] ?></td>
                                        <td><?= $ravitaillement['date'] ?></td>
                                        <td>
                                            <?php
                                            $quantite_biens=0;
                                            $bdattributionbiens = new BdAttributionBiens();
                                            $attributions = $bdattributionbiens->getAttributionBiensById($ravitaillement['attribution_id']);
                                            foreach ($attributions as $attribution) {
                                                ?>
                                                <?= $attribution['aId'] ?> . <?= $attribution['date'] . " / " . $attribution['bDesignation'] . "-" . $attribution['quantite'] . " à " . $attribution['fDesignation'] . " pour " . $attribution['delai_livraison'] . " jour(s) / quantité : " . $attribution['quantite_minimale'] ?>
                                            <?php
                                                $bien_id = $attribution['bId'];
                                                $quantite_biens=$attribution['quantite'];
                                            }
                                                // $demand = $bdattributionbiens->select('demande','id',$bien_id);
                                                // if (count($demand) > 0) {
                                                //     $distribution = $bdattributionbiens->select('distrubution','demande_id',$demand[0]['id']);
                                                //     if (count($distribution) > 0) {
                                                //         $quantite_biens= $distribution[0]['quantite_actuelle'];
                                                //     }
                                                // }
                                            ?>
                                        </td>
                                        <td><?= $quantite_biens ?></td>
                                        <td><?= $ravitaillement['prix'] ?></td>
                                        <td><?= ($quantite_biens * $ravitaillement['prix']) ?></td>
                                        <td><?= $ravitaillement['dateExpiration'] ?></td>
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