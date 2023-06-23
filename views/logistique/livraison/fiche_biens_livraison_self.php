<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/biens/biens.php';
include '../models/livraison/livraison.php';
include '../models/unite/unite.php';
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
            <fieldset>
                <legend>Le biens/produit</legend>
                <?php
                $bdbiens = new BdBiens();
                $biens = $bdbiens->getBiensById($_GET['use']);
                foreach ($biens as $bien) {
                    ?>
                    <table class="table table-bordered table-responsive-lg table-striped">
                        <tr>
                            <td><b>N°</b></td>
                            <td><?= $bien['bId'] ?></td>
                        </tr>
                        <tr>
                            <td><b>Désignation</b></td>
                            <td style="color: #0069d9;"><b><?= $bien['bDesignation'] ?></b></td>
                        </tr>
                        <tr>
                            <td><b>Marque</b></td>
                            <td><?= $bien['marque'] ?></td>
                        </tr>
                        <tr>
                            <td><b>Catégorie</b></td>
                            <td><?= $bien['gDesignation'] ?></td>
                        </tr>
                        <tr>
                            <td><b>Quantité</b></td>
                            <td style="color: forestgreen"><b><?= $bien['quantite'] ?></b></td>
                        </tr>
                        <tr>
                            <td><b>Niveau de stock max</b></td>
                            <td><?= $bien['stock_max'] ?></td>
                        </tr>
                        <tr>
                            <td><b>Niveau de stock min</b></td>
                            <td><?= $bien['stock_min'] ?></td>
                        </tr>
                        <tr>
                            <td><b>Niveau de stock critique</b></td>
                            <td><?= $bien['stock_critique'] ?></td>
                        </tr>
                        <tr>
                            <td><b>Périssable</b></td>
                            <td>
                                <?php
                                if ($bien['type_perissable']) {
                                    echo 'Oui';
                                } else {
                                    echo 'Non';
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Etat</b></td>
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
                    </table>
                    <?php
                }
                ?>
            </fieldset>
            <fieldset>
                <legend>Fiche des livraisons d'un biens/produit</legend>
                <?php
                include 'liste_livraison_by_idbiens.php';
                ?>
            </fieldset>
        </div>
    </div>
</div>

