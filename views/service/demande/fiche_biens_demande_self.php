<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/biens/biens.php';
include '../models/attribution-biens/attributionBiens.php';
include '../models/demande/demande.php';
include '../models/preparation/preparation.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-cube" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-plus-square-o" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Gestion des demandes</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-gift" style="color: darkorange; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-clipboard" style="color: darkorange; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Fiche des demandes pour un biens/produit</span>
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
                    </table>
                    <?php
                }
                ?>
            </fieldset>
            <fieldset>
                <legend>Fiche des demandes d'un biens/produit</legend>
                <form method="post" action="../contollers/demande/demandeController.php">
                    <input type="hidden" name="tb_idbiens" value="<?= $_GET['use'] ?>">
                    <button class="btn btn-info pull-right" style="margin-bottom: 10px;" type="submit" name="bt_encours_self">Voir les demandes encours</button>
                </form>
                <?php
                if ((isset($_GET['reponse'])) && ($_GET['reponse'] == sha1("get_encours_self"))) {
                    ?>
                <h4>Les demandes encours</h4>
                <?php
                    include 'liste_demande_by_idbiens_encours.php';
                } else {
                    include 'liste_demande_by_idbiens.php';
                }
                ?>
            </fieldset>
        </div>
    </div>
</div>

