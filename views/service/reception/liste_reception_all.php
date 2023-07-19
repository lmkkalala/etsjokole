<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/demande/demande.php';
include '../models/livraison/livraison.php';
include '../models/unite/unite.php';
include '../models/ravitaillement/ravitaillement.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-cube" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-share-alt" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Receipts</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-list-ol" style="color: darkgrey; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Report</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Search by date :</legend>
                <form class="form-inline" method="POST" action="../contollers/reception/receptionController.php">
                    <div class="row form-group-lg">
                        <div class="col-6">
                            <input type="date" class="form-control" name="tb_date">
                        </div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-success mt-1" name="bt_search_by_dates">
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
                <legend>Sales</legend>
                <table class="table table-bordered table-striped table-responsive-lg">
                    <thead>
                        <th>
                            N°
                        </th>
                        <th>
                            Date
                        </th>
                        <th>
                            Requisition
                        </th>
                        <th>
                            Quantity
                        </th>
                        <th>
                            Average Price (USD)
                        </th>
                        <th>
                            Value (USD)
                        </th>
                        <th>
                            Deliver
                        </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $cumul_value=0;
                        $bdlivraison = new BdLivraison();
                        $livraisons = $bdlivraison->getLivraisonAllDesc();
                        foreach ($livraisons as $livraison) {
                            if ((isset($_GET['date'])) && ($livraison['dIdmutation'] == $_SESSION['idaffectation']) && ($livraison['lDate'] == $_GET['date'])) {
                                $n++;
                        ?>
                                <tr>
                                    <td><?= $livraison['lId'] ?></td>
                                    <td><?= $livraison['lDate'] ?></td>
                                    <td><?= $livraison['dId'] ?> . <?= $livraison['date'] . " / " . $livraison['bDesignation'] . " / " . $livraison['gDesignation'] . " pour " . $livraison['nom'] . " " . $livraison['postnom'] . " " . $livraison['prenom'] . " : " . $livraison['sDesignation'] . " / quantité : " . $livraison['dQuantite'] ?></td>
                                    <td><?= $livraison['lQuantite'] ?></td>
                                    <?php
                                    $somme_prix_biens = 0;
                                    $s = 0;
                                    $bdravitaillement = new BdRavitaillement();
                                    $ravitaillements = $bdravitaillement->getRavitaillementByIdBiens($livraison['bId']);
                                    foreach ($ravitaillements as $ravitaillement) {
                                        $s++;
                                        $somme_prix_biens = $somme_prix_biens + $ravitaillement['prix'];
                                    }
                                    $average_price = ($somme_prix_biens / $s);

                                    $value_sale = ($livraison['lQuantite'] * $average_price);
                                    ?>
                                    <td><?= $average_price ?></td>
                                    <td style="font-weight: 700; color: #00aa00;"><?= $value_sale ?></td>
                                    <td><?= $livraison['lNom'] . " " . $livraison['lPostnom'] . " " . $livraison['lPrenom'] ?></td>
                                </tr>
                        <?php
                                $cumul_value = $cumul_value + $value_sale;
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <td style="font-size: 15px;">
                            <span>Nombre:</span><span><?= $n ?></span>
                        </td>
                        <td style="font-weight: 700; color: #00aa00;">
                            Total : <?= $cumul_value ?>
                        </td>
                    </tfoot>
                </table>
            </fieldset>
        </div>
    </div>
</div>