<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/biens/biens.php';
include '../models/attribution-biens/attributionBiens.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-list-alt" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-gift" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Order</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-gift" style="color: tomato; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-book" style="color: tomato; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Order per item</span>
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
                <legend>Fiche des commandes d'un biens/produit</legend>
                <form method="post" action="../contollers/attribution-biens/attributionBiensController.php">
                    <input type="hidden" name="tb_idbiens" value="<?= $_GET['use'] ?>">
                    <button class="btn btn-info pull-right" style="margin-bottom: 10px;" type="submit" name="bt_encours_self">Voir les commandes encours</button>
                </form>
                <?php
                if ((isset($_GET['reponse'])) && ($_GET['reponse'] == sha1("get_encours_self"))) {
                    ?>
                <h4>Les commandes encours</h4>
                <?php
                    include 'liste_attribution_biens_by_idbiens_encours.php';
                } else {
                    include 'liste_attribution_biens_by_idbiens.php';
                }
                ?>
            </fieldset>
        </div>
    </div>
</div>

