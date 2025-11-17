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
        <span class="fa fa-cubes" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-share-alt" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Livraison</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-gift" style="color: #0069d9; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-file-text-o" style="color: #0069d9; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Fiche de livraisons pour un biens/produit</span>
    </div>
    <div class="panel panel-body">
        <div>
            <div class="row">
                <h4>Taper le mot-clé de la recherche :</h4>
                <form class="form-inline" method="POST" action="../contollers/livraison/livraisonController.php">
                    <div class="row form-group-lg">
                        <div class="col-md-6 col-12 mt-2">
                            <input type="text" class="form-control w-100" name="tb_search" placeholder="Mot-clé"> 
                        </div>
                         
                        <div class="col-md-6 col-12 mt-2">
                            <button type="submit" class="btn btn-secondary w-100" name="bt_search_for_biens">
                                <span class="glyphicon glyphicon-search"></span> Rechercher
                            </button>
                        </div>                          
                    </div>
                </form>
            </div>
            <div class="row">
                <h4>Liste des biens/produits</h4>
                <div class="col-md-12 overflow-auto">
                    <table class="table table-bordered table-responsive-lg">
                        <thead>
                            <tr>
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
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $n = 0;
                            $bdbiens = new BdBiens();
                            if ((isset($_GET['use']))) {
                                $biens=$bdbiens->getBiensByName($_GET['use']);
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
                                        <form method="POST" action="../contollers/livraison/livraisonController.php">
                                            <input type="hidden" name="tb_idbiens" value="<?= $bien['bId'] ?>">
                                            <button type="submit" class="btn btn-primary" name="bt_view_for_biens"><span class="glyphicon glyphicon-file" style="color: white; font-size: 15px;"></span></button>
                                        </form>
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
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

