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
        <span class="fa fa-recycle" style="color: #0069d9; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Gestion des récuperations</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-gift" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-file-text-o" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Fiche de récuperations par biens/produit</span>
    </div>
    <div class="panel panel-body">
        <div class="row">
            <div class="col-md-12">
                <h4>Taper le mot-clé de la recherche :</h4>
                <form class="form-inline" method="POST" action="../contollers/recuperation/recuperationController.php">
                    <div class="form-group-lg">
                        <div class="row">
                            <div class="col-md-6 col-12 mt-2">
                                <input type="text" class="form-control w-100" name="tb_search" placeholder="Mot-clé"> 
                            </div>
                            <div class="col-md-6 col-12 mt-2">
                            <button type="submit" class="btn btn-secondary w-100" name="bt_search_for_biens">
                                <span class="glyphicon glyphicon-search" style="color: white;"></span>
                                <span style="color: white;">Recherche</span>
                            </button>
                            </div>
                        </div>                          
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h4>Liste des biens/produits</h4>
                <table class="table table-bordered table-responsive-lg">
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
                        Opération
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdbiens = new BdBiens();
                        if ((isset($_GET['use']))) {
                            $biens=$bdbiens->getBiensByNameActive($_GET['use']);
                        } else {
                            $biens = $bdbiens->getBiensAllDescActive();
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
                                <td>
                                    <form method="POST" action="../contollers/recuperation/recuperationController.php">
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
                            <span><?= $n ?></span>
                        </td>
                        <td>
                        <span>Nombre:</span>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

