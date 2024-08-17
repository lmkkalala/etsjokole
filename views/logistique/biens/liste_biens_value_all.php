<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/biens/biens.php';
include '../models/ravitaillement/ravitaillement.php';
include '../models/unite/unite.php';

?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-cube" style="color: #0069d9; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Items</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-list-ol" style="color: darkgrey; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Store inventory</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Rechercher :</legend>
                <form class="form-inline" method="POST" action="../contollers/biens/biensController.php">
                    <div class="row form-group-lg">
                        <div class="col-md-4 mt-1">
                            <select class="form-control select2" name="cb_biens">
                                <option value="0">Choose item</option>
                                <?php
                                $bdbiens = new BdBiens();
                                $biens = $bdbiens->getBiensAllDesc();
                                foreach ($biens as $bien) {
                                    if (1) {
                                        if (1) {
                                ?>
                                            <option value="<?= $bien['bId'] ?>"><?= $bien['bDesignation'] . " / Marque : " . $bien['marque'] . " / " . $bien['gDesignation'] . " / Codebarre: " . $bien['codebarre'] ?></option>
                                <?php
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-success w-100 mt-1" name="bt_search_for_all_for_value"><span class="glyphicon glyphicon-search btn" style="color: white; font-size: 20px;margin-right: 5px;"></span> Rechercher</button>
                        </div>
                        <div class="col-md-4">
                            <a style="font-size: 20px;" href='../views/logistique/biens/pdf_list_biens_value_all.php' target="_blank" class="btn btn-secondary w-100 mt-1">Print in PDF</a>
                   
                            <!-- <a style="font-size: 20px;" href='../views/logistique/biens/excel_list_biens_value_all.php' class="btn btn-success pull-right">Export to Excel</a> -->
                        </div>
                    </div>
                </form>
            </fieldset>
            <br>
            <fieldset>
                <legend>Items</legend>
                <table id="listdatabyid" class="table table-bordered table-responsive-lg table-striped">
                    <thead>
                        <tr>
                        <th>
                            N°
                        </th>
                        <th>
                            Category
                        </th>
                        <th>
                            Name / State
                        </th>
                        <th>
                            Perissable
                        </th>
                        <th>
                            Quantity
                        </th>
                        <th>
                            Average UP (USD)
                        </th>
                        <th>
                            Value (USD)
                        </th>
                        
                        <th>
                            Crisis level
                        </th>
                        <th>
                            Codebarre
                        </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $cumul_value_item = 0;
                        $bdbiens = new BdBiens();
                        if ((isset($_GET['use_biens'])) && ($_GET['use_biens'] != 0)) {

                            $biens = $bdbiens->getBiensById($_GET['use_biens']);
                        } else {
                            $biens = $bdbiens->getBiensAllDesc();
                        }

                        foreach ($biens as $bien) {
                            if ($bien['quantite']) {
                        ?>
                                <tr>
                                    <td><?=$n?></td>
                                    <td>
                                        <?= $bien['bId'] ?> <br>
                                        <?= $bien['gDesignation'] ?>
                                    </td>
                                    <td>
                                        <?= $bien['bDesignation'] ?> 
                                        /
                                        <?php
                                        if ($bien['active'] == 1) {
                                        ?>
                                            <h4 style="color: forestgreen;">Actif</h4>
                                        <?php
                                        } else {
                                        ?>
                                            <h4 style="color: red;">Inactif</h4>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <b>
                                            <?php
                                            if ($bien['type_perissable']) {
                                                echo 'Oui';
                                            } else {
                                                echo 'Non';
                                            }
                                            ?>
                                        </b>
                                    </td>
                                    <td><?= $bien['quantite'] ?></td>
                                    <?php
                                    
                                    $somme_prix_biens = 0;
                                    $s = 0;
                                    $bdravitaillement = new BdRavitaillement();
                                    $ravitaillements = $bdravitaillement->getRavitaillementByIdBiensMore($bien['bId'],'ORDER BY s.id DESC Limit 3');
                                    
                                    foreach ($ravitaillements as $ravitaillement) {
                                        $s++;
                                        $somme_prix_biens = $somme_prix_biens + $ravitaillement['prix'];
                                    }
                                    $average_price=0;
                                    
                                    if ($s>0) {
                                        $average_price = ($somme_prix_biens / $s);
                                    }
                                    
                                    ?>
                                    <td><?= $average_price ?></td>
                                    <td>
                                        <?php
                                        echo ($bien['quantite'] * $average_price);
                                        $cumul_value_item = $cumul_value_item + ($bien['quantite'] * $average_price);
                                        ?>
                                    </td>
                                    
                                    <td><?= $bien['stock_critique'] ?></td>
                                    <td><?= $bien['codebarre'] ?></td>
                                </tr>
                        <?php
                            $n++;
                            }
                            
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th style="font-weight: bold;">
                                <span>Number : </span>
                            </th>
                            <th><span><?= $n ?></span></th>
                            <th style="font-weight: bold;color: forestgreen;">
                                <span>Total value : </span>
                            </th>
                            <th>
                                <span><?= $cumul_value_item ?> USD </span>
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