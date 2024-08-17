<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/demande/demande.php';
include '../models/livraison/livraison.php';
include '../models/unite/unite.php';
include '../models/biens/biens.php';
include '../models/ravitaillement/ravitaillement.php';
include '../models/crud/db.php';
$DB = new DB();
$pa = 0;
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-cube" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Entrée</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-list-ol" style="color: darkgrey; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Inventaire</span>
    </div>
    <div class="panel panel-body">
        <div><fieldset>
                <legend>Recherche par date :</legend>
                <form class="form-inline" method="POST" action="../contollers/reception/receptionController.php">
                    <div class="row form-group-lg">
                        <div class="col-4">
                            <input type="date" class="form-control" name="tb_date" value="<?=(isset($_GET['date'])) ? $_GET['date']: date('Y-m-d') ?>">
                        </div>
                        <div class="col-4">
                            <select class="form-control" name="autres_place">
                                <option value="00">Selectionner ICI</option>
                                <option value="00" selected>Kamanyola</option>
                                <?php
                                    $LieuDataList = $DB->get('lieureception');
                                    if (count($LieuDataList) != 0) {
                                        foreach ($LieuDataList as $key => $value) {
                                ?>
                                <option value="<?=$value['id']?>"><?=$value['lieu']?></option>
                                <?php } } ?>
                            </select>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-success mt-1" name="bt_search_by_dates_inventory">
                                <span class="glyphicon glyphicon-search" style="color: white; font-size: 20px;"></span> Rechercher
                            </button>
                        </div>

                    </div>
                </form>
            </fieldset>
            <fieldset>
                <h3 style="color: orange;">
                    <?php
                    if ((isset($_GET['date'])) && ($_GET['date'] != "")) {
                        echo "Date : " . $_GET['date'];
                    }
                    ?>
                </h3>
            </fieldset>
            <fieldset >
                <?php
                if (isset($_GET['date'])) {
                    ?>
                    <a style="font-size: 20px;" href='../views/service/reception/pdf_reception_inventory.php?date=<?= $_GET['date'] ?>' target="_blank" class="btn btn-primary pull-left">Print in PDF</a>
                    <?php
                }
                ?>

            </fieldset>
            <br>
            <fieldset>
                <legend>Receipts</legend>
                <table id="listdatabyid" class="table table-bordered table-responsive-lg table-hover table-striped">
                    <thead>
                        <tr>
                            <th>
                                #
                            </th>
                            <th>
                                Id
                            </th>
                            <th>
                                Item
                            </th>
                            <th>
                                Category
                            </th>
                            <th>
                                Actual quantity
                            </th>
                            <th>
                                UP (USD)
                            </th>
                            <th>
                                Actual value (USD)
                            </th>
                            <th>
                                PV
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $n = 0;
                        $cumul_value = 0;
                        $average_price = 0;
                        $bdlivraison = new BdLivraison();
                        $bdbiens = new BdBiens();
                        $biens = $bdbiens->getBiensAll();
                        $cumul_quantite_actuelle = 0;
                        foreach ($biens as $bien) {
                            $cumul_quantite_actuelle = 0;

                            $trouve = FALSE;
                            $livraisons = $bdlivraison->getLivraisonWithQuantitePositiveByIdBiens($bien['bId']);
                            foreach ($livraisons as $livraison) {
                                $livraison_etat = $livraison['lEtat'];
                                if ((isset($_GET['date'])) && (($livraison_etat == 0) && ($_GET['date']>=$livraison['lDate']))) {
                                    if ($livraison['sId']==$_SESSION['idservice']) {
                                        $trouve = TRUE;
                                    }
                                }
                            }

                            if ($trouve) {
                                $n++;
                            ?>
                                <tr>
                                    <td><?= $n ?></td>
                                    <td><?= $bien['bId'] ?></td>
                                    <td><?= $bien['bDesignation'] ?></td>
                                    <td><?= $bien['gDesignation'] ?></td>
                                    <?php
                                    $livraisons = $bdlivraison->getLivraisonWithQuantitePositiveByIdBiens($bien['bId']);
                                    foreach ($livraisons as $livraison) {
                                        $livraison_etat = $livraison['lEtat'];
                                        if ($livraison_etat == 0) {
                                            if ($livraison['sId']==$_SESSION['idservice']) {
                                                $cumul_quantite_actuelle = $cumul_quantite_actuelle + $livraison['quantite_actuelle'];
                                            }
                                        }
                                    }

                                    $somme_prix_biens = 0;
                                    $s = 0;
                                    $bdravitaillement = new BdRavitaillement();
                                    $ravitaillements = $bdravitaillement->getRavitaillementByIdBiens($bien['bId']);
                                    foreach ($ravitaillements as $ravitaillement) {
                                        $s++;
                                        $somme_prix_biens = $somme_prix_biens + $ravitaillement['prix'];
                                    }
                                    

                                    if (isset($_GET['autres_place']) and $_GET['autres_place'] != '00') {
                                        $autrePrix = $DB->getWhereMultipleMore(' * FROM receptionautreprix',' bien_id = '.$bien['bId'].'',' Limit 10');
                                        $countRow = count($autrePrix);
                                        if ($countRow > 0) {
                                            foreach ($autrePrix as $key => $value) {
                                                $pa = $pa + $autrePrix[$key]['prix_reception'];
                                            }
                                            $average_price = ($pa / $countRow);
                                        }else{
                                            if ($s>0) {
                                                $average_price = ($somme_prix_biens / $s);
                                            } 
                                        }
                                    }else{
                                        if ($s>0) {
                                            $average_price = ($somme_prix_biens / $s);
                                        }
                                    }

                                    ?>
                                    <td style="color:dodgerblue; font-weight:bold;"><?= $cumul_quantite_actuelle ?></td>
                                    <td><?= round($average_price,3) ?></td>
                                    <td>
                                    <?php
                                        echo round(($cumul_quantite_actuelle * $average_price),3);
                                        $cumul_value = $cumul_value + ($cumul_quantite_actuelle * $average_price);
                                    ?>
                                    </td>
                                    <td><?= $bien['bPv'] ?></td>
                                </tr>
                            <?php
                                $average_price = 0;
                                $pa = 0;   
                            } 
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th style="font-size: 20px;">
                                <span>Nombre:</span><span><?= $n ?></span>
                            </th>
                            <th style="color: dodgerblue; font-weight: bold;">
                                Total value :
                            </th>
                            <th style="color: dodgerblue; font-weight: bold;">
                                <?= " " . round($cumul_value,3) . " USD" ?>
                            </th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </fieldset>
        </div>
    </div>
</div>

