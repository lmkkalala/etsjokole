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
        <span class="fa fa-archive" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">les unités</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-gift" style="color: #0069d9; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-file-text-o" style="color: #0069d9; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Fiche des unités pour un biens/produit</span>
    </div>
    <div class="panel panel-body">
        <div>
        <fieldset>
                <legend>Rechercher :</legend>
                <form class="form-inline" method="POST" action="../contollers/unite/uniteController.php">
                    <div class="row form-group-lg">
                        <div class="col-6">
                        <select class="form-control select2" name="cb_biens">
                            <option value="0">Choose item</option>
                            <?php
                            $bdbiens = new BdBiens();
                            $biens = $bdbiens->getBiensAllDesc();
                            foreach ($biens as $bien) {
                                if (1) {
                                    if (1) {
                            ?>
                                        <option value="<?= $bien['bId'] ?>"><?= $bien['bDesignation'] . " / Marque : " . $bien['marque'] . " / " . $bien['gDesignation'] ?></option>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                        </div>
                        <div class="col-6">
                        <button type="submit" class="btn btn-success" name="bt_search_for_biens_unite"><span class="glyphicon glyphicon-search" style="color: white; font-size: 20px;margin-right: 5px;"></span> Rechercher</button>
                        </div>
                    </div>
                </form>
            </fieldset>
            <fieldset>
                <legend>Liste des biens/produits</legend>
                <table class="table table-bordered table-responsive-lg table-striped">
                    <thead>
                    <th>
                        N°
                    </th>
                    <th>
                        Catégorie
                    </th>
                    <th>
                        Désignation
                    </th>
                    <th>
                        Marque
                    </th>
                    <th>
                        Périssable
                    </th>
                    <th>
                        Quantité
                    </th>
                    <th>
                        Stock max
                    </th>
                    <th>
                        Stock min
                    </th>
                    <th>
                        Stock critique
                    </th>                    
                    <th>
                        Etat
                    </th>                    
                    <th>
                        Opération
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdbiens = new BdBiens();
                        if ((isset($_GET['use']))) {
                            $biens=$bdbiens->getBiensById($_GET['use']);
                        } else {
                            $biens = $bdbiens->getBiensAllDesc();
                        }
                        foreach ($biens as $bien) {
                            $n++;
                            ?>
                            <tr>
                                <td><?= $bien['bId'] ?></td>
                                <td><?= $bien['gDesignation'] ?></td>
                                <td><?= $bien['bDesignation'] ?></td>
                                <td><?= $bien['marque'] ?></td>
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
                                <td><?= $bien['stock_max'] ?></td>
                                <td><?= $bien['stock_min'] ?></td>
                                <td><?= $bien['stock_critique'] ?></td>
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
                                <td>
                                    <form method="POST" action="../contollers/unite/uniteController.php">
                                        <input type="hidden" name="tb_idbiens" value="<?= $bien['bId'] ?>">
                                        <button type="submit" class="btn btn-primary" name="bt_view_for_biens"><span class="glyphicon glyphicon-file" style="color: white; font-size: 15px;margin-right: 5px;"></span></button>
                                    </form>
                                </td>
                            </tr>
                            <?php
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

