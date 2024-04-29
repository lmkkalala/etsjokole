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
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-list-ol" style="color: darkgrey; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Anciens Inventaires</span>
    </div>
    <div class="panel panel-body">
        <div><fieldset>
                <legend>Recherche par date :</legend>
                <form class="form-inline" method="POST" action="../contollers/reception/receptionController.php">
                    <div class="row form-group-lg">
                        <div class="col-6">
                            <input type="date" class="form-control" name="tb_date" value="<?=(isset($_GET['date'])) ? $_GET['date']: date('Y-m-d')?>">
                        </div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-success mt-1" name="bt_search_by_dates_inventory_old">
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
                    if (isset($_GET['date']) and !empty($_GET['date'])) {
                ?>
                    <a style="font-size: 20px;" href='../views/service/reception/pdf_reception_inventory.php?date=<?= $_GET['date'] ?>&time=old' class="btn btn-primary pull-left">Print in PDF</a>
                <?php
                }
                ?>

            </fieldset>
            <br>
            <fieldset>
                <legend>Receipts</legend>
                <table class="table table-bordered table-responsive-lg table-hover table-striped">
                    <thead>
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
                    </thead>
                    <tbody>
                    <?php
                    
                    if (isset($_GET['date']) and !empty($_GET['date'])) {
                        $bienVendu = 0;
                        $n = 0;
                        $cumul_value = 0;
                        $bdlivraison = new BdLivraison();
                        $bdbiens = new BdBiens();
                        $db = new DB();
                        $biens = $bdbiens->getBiensAll();
                        $cumul_quantite_actuelle = 0;
                        foreach ($biens as $bien) {
                            $cumul_quantite_actuelle = 0;
                            $bienVendu = 0;
                            $trouve = FALSE;
                            $livraisons = $bdlivraison->getLivraisonWithQuantiteByIdBiensWhere($bien['bId'], " AND l.date < '".$_GET['date']."' ");
                            
                            foreach ($livraisons as $livraison) {
                                $livraison_etat = $livraison['lEtat'];
                                if ((isset($_GET['date'])) && (($livraison_etat == 0))) {
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
                                    $livraisons = $bdlivraison->getLivraisonWithQuantiteByIdBiensWhere($bien['bId'], " AND l.date < '".$_GET['date']."' AND m.id = '".$_SESSION['idaffectation']."' ");
                                    
                                    foreach ($livraisons as $livraison) {
                                        $cumul_quantite_actuelle = $cumul_quantite_actuelle + $livraison['quantite_actuelle'];
                                        $vente  = $db->getWhereMultipleMore(" * FROM affectation "," distribution_id = '".$livraison['lId']."' AND date >= '".$_GET['date']."' AND date <= '".date('Y-m-d')."' ");
                                        if (count($vente) > 0) {
                                            foreach ($vente as $venteBien) {
                                                $bienVendu = $bienVendu + $venteBien['nombre'];
                                            }
                                        }
                                    }

                                    $cumul_quantite_actuelle = $cumul_quantite_actuelle + $bienVendu;
                                    $bg="";
                                    if ($cumul_quantite_actuelle > 0) {
                                       $bg="bg-info text-white";
                                    }

                                    $somme_prix_biens = 0;
                                    $s = 0;
                                    $bdravitaillement = new BdRavitaillement();
                                    $ravitaillements = $bdravitaillement->getRavitaillementByIdBiens($bien['bId']);
                                    foreach ($ravitaillements as $ravitaillement) {
                                        $s++;
                                        $somme_prix_biens = $somme_prix_biens + $ravitaillement['prix'];
                                    }
                                    
                                    if ($s > 0) {
                                        $average_price = ($somme_prix_biens / $s);
                                    }
                                    
                                    ?>
                                    <td class="<?=$bg?>" style="color:dodgerblue; font-weight:bold;"><?= $cumul_quantite_actuelle ?></td>
                                    <td><?= round($average_price,3) ?></td>
                                    <td>
                                        <?php
                                        echo round(($cumul_quantite_actuelle * $average_price),3);
                                        $cumul_value = $cumul_value + ($cumul_quantite_actuelle * $average_price);
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
                    <?php if (isset($_GET['date']) and !empty($_GET['date'])) { ?>
                    <td style="font-size: 20px;">
                        <span>Nombre:</span><span><?= $n ?></span>
                    </td>
                    <td style="color: dodgerblue; font-weight: bold;">
                        <?= "Total value : " . round($cumul_value,3) . " USD" ?>
                    </td>
                    <?php } ?>
                    </tfoot>
                </table>
            </fieldset>
        </div>
    </div>
</div>

