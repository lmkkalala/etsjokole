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
include '../models/crud/db.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-cube" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-hand-stop-o" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Vente sur stock</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-list-ol" style="color: darkgrey; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Rapport</span>
    </div>
    <?php
    $link = "service_distribution_liste_distribution_all";
    include("select_service.php");
    ?>

    <fieldset>
        <legend style="margin: 10px; color: orange; font-weight: bold;">
            <?php
            if (((isset($_GET['use_date1'])) && (isset($_GET['use_date2']))) && (($_GET['use_date1'] != "") && ($_GET['use_date2'] != ""))) {
                echo "Starting date : " . $_GET['use_date1'] . " / Ending date : " . $_GET['use_date2'];
                echo " / Ident. Client : " . $_GET['use_identiteClient'];
            }
            if ((isset($_GET['use_typerepas'])) && ($_GET['use_typerepas'] != "0")) {
                echo " / Type : " . $_GET['use_typerepas'];
            }

            ?>
        </legend>
    </fieldset>

    <div class="panel panel-body">
        <div>
            <fieldset>
                <?php
                if ((isset($_GET['use_date1']))) {
                ?>
                    <a style="font-size: 20px;" href='../views/service/distribution/pdf_list_distribution.php?use_date1=<?= $_GET['use_date1'] . '&use_date2=' . $_GET['use_date2'] . '&use_service=' . $_GET['use'] . '&use_typerepas=' . $_GET['use_typerepas'] . '&use_identiteClient=' . $_GET['use_identiteClient'] ?>' class="btn btn-primary pull-left">Print in PDF</a>
                    <?php
                    ?>
                    
                <?php
                }
                ?>

            </fieldset>
            <br>
            <fieldset>
                <legend>Sales list</legend>
                <table class="table table-bordered table-responsive-lg table-striped">
                    <thead>
                        <th>
                            Numero Vente
                        </th>
                        <th>
                            N°
                        </th>
                        <th>
                            Date
                        </th>
                        <th>
                            Ident. Client
                        </th>
                        <th>
                            Produit
                        </th>
                        <th>
                            Quantité
                        </th>
                        <th>
                            Prix (USD)
                        </th>
                        <th>
                            PA (USD)
                        </th>
                        <th>
                            Valeur HT (USD)
                        </th>
                        <th>
                           Valeur TVA  (USD)
                        </th>
                        <th>
                            Valeur TTC (USD)
                        </th>
                        <th>
                            Paiement
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
                        if (((isset($_GET['use_date1'])) && (isset($_GET['use_date2']))) && (($_GET['use_date1'] != "") && ($_GET['use_date2'] != ""))) {
                            if ($_GET['use_typerepas'] != "0") {
                                if ($_GET['use_identiteClient'] != "none") {
                                    $distributions = $bddistribution->getDistributionBeetwen2DatesByTypeRepasByIdentiteClient($_GET['use_date1'], $_GET['use_date2'], $_GET['use_typerepas'], $_GET['use_identiteClient']);
                                } else {
                                    $distributions = $bddistribution->getDistributionBeetwen2DatesByTypeRepas($_GET['use_date1'], $_GET['use_date2'], $_GET['use_typerepas']);
                                }
                            } else {
                                if ($_GET['use_identiteClient'] != "none") {
                                    $distributions = $bddistribution->getDistributionBeetwen2DatesByIdentiteClient($_GET['use_date1'], $_GET['use_date2'], $_GET['use_identiteClient']);
                                } else {
                                    $distributions = $bddistribution->getDistributionBeetwen2Dates($_GET['use_date1'], $_GET['use_date2']);
                                }
                            }
                        } else {
                            $distributions = $bddistribution->getDistributionAllDesc();
                        }

                        if (((isset($_GET['use_date1'])) && (isset($_GET['use_date2']))) && (($_GET['use_date1'] == "") && ($_GET['use_date2'] == "") && ($_GET['use_typerepas'] != "0"))) {
                            $distributions = $bddistribution->getDistributionByTypeRepas($_GET['use_typerepas']);
                        }

                        if ((isset($_GET['use_typerepas'])) && ($_GET['use_typerepas'] != "0")) {
                            $list_type_repas = [$_GET['use_typerepas']];
                        } else {
                            $list_type_repas = ['Input','Diesel','Lubricant','Fleet','Plant', 'cleaning', 'non-consomable', 'Office and kitchen equipment', 'Bar', 'Spoilage', 'Transfer', 'Staff meal', 'Back to supplier', 'Back charge to client', 'Fonction','PRO'];
                        }

                        $cumul_value_total = 0;
                        $cumul_tva_total = 0;
                        $cumul_value_ttc_total = 0;
                        $cumul_value_ttc_total_cash=0;
                        $cumul_value_ttc_total_credit=0;

                        foreach ($list_type_repas as $typerepas) {

                            if ((isset($_GET['use_typerepas'])) && (($_GET['use_typerepas'] != "0") || (($_GET['use_date1'] != "") && ($_GET['use_date2'] != "")))) {
                                if ((isset($_GET['use_typerepas'])) && (($typerepas == $_GET['use_typerepas']) || (($_GET['use_date1'] != "") && ($_GET['use_date2'] != "")))) {

                                    ?>
                                    <tr style="background-color: dodgerblue; color: white; font-weight: bold;">
                                        <td>
                                            <?= $typerepas ?>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php
                                    $pat = 0;
                                    $pvt = 0;
                                    $cumul_value_typerepas = 0;
                                    $cumul_tva=0;
                                    $cumul_value_ttc=0;
                                    $cumul_value_ttc_cash=0;
                                    $cumul_value_ttc_credit=0;
                                    foreach ($distributions as $distribution) {

                                        if ($distribution['typerepas'] == $typerepas) {

                                            $affiche_bon = false;
                                            //                            $bdmutation=new BdAffectationService();
                                            //                            $affectations=$bdaffectation->getAffectationServiceByService($idservice);
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
                                                $infolivraison = $livraison['lDate'] . " " . $livraison['bDesignation'] . " : " . $livraison['marque'] . " / " . $livraison['gDesignation'] . " / quantité initiale : " . $livraison['lQuantite'] . " / quantité actuelle : " . $livraison['quantite_actuelle'];
                                            }
                                            $db = new DB();
                                            $distrubutionData = $db->getWhere('distrubution','id', $distribution['distribution_id']);
                                            if(count($distrubutionData) > 0){
                                                $demande_id = $distrubutionData[0]['demande_id'];
                                                $demandeData = $db->getWhere('demande','id',$demande_id);
                                                if(count($demandeData) > 0){
                                                    $biens_id = $demandeData[0]['biens_id'];
                                                    $biensData = $db->getWhere('biens','id',$biens_id);
                                                    if(count($biensData)> 0){
                                                        $pa = $biensData[0]['prixunitaire'];
                                                    }else{
                                                        $pa = 0;
                                                    }
                                                }else{
                                                    $pa = 0;
                                                }
                                            }else{
                                                $pa = 0;
                                            }

                                            if (isset($infolivraison) && ($affiche_bon) && ($distribution['nombre_restant'] > 0)) {
                                                $pat = $pat + ($pa*$distribution['nombre_restant']);
                                                $pvt = $pvt + ($distribution['price']*$distribution['nombre_restant']);
                                                $n++;
                                                    ?>
                                                <tr>
                                                    <td><?= $distribution['venteposId'] ?></td>
                                                    <td><?= $distribution['id'] ?></td>
                                                    <td><?= $distribution['date'] ?></td>
                                                    <td><strong><?= $distribution['identiteClient'] ?></strong></td>
                                                    <td><?= $infolivraison ?></td>
                                                    <td><?= $distribution['nombre_restant'] ?></td>
                                                    <td><?= $distribution['price'] ?></td>
                                                    <td><?= $pa ?></td>
                                                    <td style="color: dodgerblue;">
                                                        <?php
                                                        echo ($distribution['nombre_restant'] * $distribution['price']);
                                                        $cumul_value_typerepas = $cumul_value_typerepas + ($distribution['nombre_restant'] * $distribution['price']);
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
                                                        $cumul_value_ttc=$cumul_value_ttc+(($distribution['nombre_restant'] * $distribution['price'])*(1+($distribution['tva']/100)));
                                                        ?>
                                                    </td>
                                                    <td style="color: black; font-weight: 700;">
                                                        <?php
                                                        echo (($distribution['typePaiement']));
                                                        if ($distribution['typePaiement']=="CASH") {
                                                            $cumul_value_ttc_cash=$cumul_value_ttc_cash+(($distribution['nombre_restant'] * $distribution['price'])*(1+($distribution['tva']/100)));
                                                        } else {
                                                            $cumul_value_ttc_credit=$cumul_value_ttc_credit+(($distribution['nombre_restant'] * $distribution['price'])*(1+($distribution['tva']/100)));
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        $pa = '';
                                    }
                                    $cumul_value_total = $cumul_value_total + $cumul_value_typerepas;
                                    $cumul_tva_total = $cumul_tva_total + $cumul_tva;
                                    $cumul_value_ttc_total = $cumul_value_ttc_total + $cumul_value_ttc;
                                    $cumul_value_ttc_total_cash = $cumul_value_ttc_total_cash + $cumul_value_ttc_cash;
                                    $cumul_value_ttc_total_credit = $cumul_value_ttc_total_credit + $cumul_value_ttc_credit;
                                    ?>
                                    <tr style="background-color: #008080; color: white; font-weight: bold;">
                                        <td>
                                            <?= "Value HT : " . $cumul_value_typerepas . " USD" ?>
                                        </td>
                                        <td>
                                            <?= "Value TVA : " . $cumul_tva . " USD" ?>
                                        </td>
                                        <td>
                                            <?= "Value TTC : " . $cumul_value_ttc . " USD" ?>
                                        </td>
                                        <td>
                                            <?= "Value TTC CASH : " . $cumul_value_ttc_cash . " USD" ?>
                                        </td>
                                        <td>
                                            <?= "Value TTC CREDIT : " . $cumul_value_ttc_credit . " USD" ?>
                                        </td>
                                        <td><?=" PAT : ".$pat. " USD"?></td>
                                        <td>
                                            <?=" Marge : ".($pvt-$pat). " USD"?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <td style="">
                            <span>Nombre:</span><span><?= $n ?></span>
                        </td>
                        <td style="font-weight: bold; color: dodgerblue;">
                            <span> Grand Total value HT : </span><span><?= $cumul_value_total ?> USD</span>
                        </td>
                        <td style="font-weight: bold;">
                            <span> Grand Total TVA : </span><span><?= $cumul_tva_total ?> USD</span>
                        </td>
                        <td style="font-weight: bold; color: forestgreen;">
                            <span> Grand Total value TTC : </span><span><?= $cumul_value_ttc_total ?> USD</span>
                        </td>
                        <td style="font-weight: bold; color: forestgreen;">
                            <span> Grand Total value TTC CASH : </span><span><?= $cumul_value_ttc_total_cash ?> USD</span>
                        </td>
                        <td style="font-weight: bold; color: forestgreen;">
                            <span> Grand Total value TTC CREDIT : </span><span><?= $cumul_value_ttc_total_credit ?> USD</span>
                        </td>
                    </tfoot>
                </table>
            </fieldset>
        </div>
    </div>
</div>