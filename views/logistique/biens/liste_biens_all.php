<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/biens/biens.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-cube" style="color: #0069d9; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Items</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-list-ol" style="color: darkgrey; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">List</span>
    </div>
    <div class="panel panel-body">
        <div class="row">
            <div class="col-md-12">
                <h4>Rechercher :</h4>
                <form class="form-inline" method="POST" action="../contollers/biens/biensController.php">
                    <div class="row form-group-lg">
                        <div class="col-md-8 col-12 mt-2">
                            <input type="text" class="form-control" name="cb_biens">
                            <!-- <select class="form-control w-100 select2" name="cb_biens">
                                <option value="0">Choisir un produit</option>
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
                            </select> -->
                        </div>
                        <div class="col-md-4 col-12 mt-2">
                            <button type="submit" class="btn btn-secondary w-100" name="bt_search_for_all"><span class="glyphicon glyphicon-search" style="color: white; font-size: 20px;margin-right: 5px;"></span> Rechercher</button>
                        </div>
                    </div>
                </form>
            </div>
            
        </div>
        <div class="row mt-2">
                <div class="col-md-6 col-12 mt-1">
                    <a style="font-size: 20px;" href='../views/logistique/biens/pdf_list_biens_all.php' class="btn btn-primary w-100">Print in PDF</a>
                </div>
                <div class="col-md-6 col-12 mt-1">
                    <a style="font-size: 20px;" href='../views/logistique/biens/excel_list_biens_all.php' class="btn btn-success w-100">Export to Excel</a>
                </div>       
            </div>
        <div class="row">
            <div class="col-md-12 overflow-auto">
                <h4>Les biens/produits</h4>
                <table id="list_biens_all" class="table table-bordered table-responsive-lg table-striped">
                    <thead>
                        <th>
                            #
                        </th>
                        <th>
                            Category
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Perissable
                        </th>
                        <th>
                            Quantity
                        </th>
                        <th>
                            Unit price
                        </th>

                        <th>
                            Crisis level
                        </th>
                        <th>
                            Codebarre
                        </th>  
                        <th>
                            Status
                        </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdbiens = new BdBiens();
                        if ((isset($_GET['use_biens'])) && ($_GET['use_biens'] != 0)) {
                            // $biens = $bdbiens->getBiensById($_GET['use_biens']);
                            $biens = $bdbiens->getBiensByIdName($_GET['use_biens']);
                        } else {
                            $biens = $bdbiens->getBiensAllDesc();
                        }

                        foreach ($biens as $bien) {
                            $n++;
                            ?>
                            <tr >
                                <td><?= $bien['bId'] ?></td>
                                <td><?= $bien['gDesignation'] ?></td>
                                <td><?= $bien['bDesignation'] ?></td>
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
                                <td
                                <?php
                                if ($bien['quantite'] == 0) {
                                    echo "style='background-color:red; color:white;'";
                                } else if ($bien['quantite'] <= $bien['stock_critique']) {
                                    echo "style='background-color:orange; color:white;'";
                                }
                                ?>
                                ><?= $bien['quantite'] ?></td>
                                <td><?= $bien['prixunitaire'] ?></td>
                                <td><?= $bien['stock_critique'] ?></td>
                                <td><?= $bien['codebarre'] ?></td>
                                <td>
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
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td style="font-size: 20px;">
                                <span><?= $n ?></span>
                            </td>
                            <td><span>Number : </span></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

