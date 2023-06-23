<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/biens/biens.php';
include '../models/attribution-biens/attributionBiens.php';
include '../models/demande/demande.php';
include '../models/livraison/livraison.php';
include '../models/recuperation/recuperation.php';
include '../models/distribution/distribution.php';
include '../models/affectation-service/affectationService.php';
include '../models/service/service.php';
include '../models/unite/unite.php';
include '../models/ravitaillement/ravitaillement.php';

?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-cube" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-hand-stop-o" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">POS</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-gift" style="color: orange; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-file-text-o" style="color: orange; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Vente par bien/produit</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Le biens/produit</legend>
                <?php
                $bdbiens = new BdBiens();
                $biens = $bdbiens->getBiensById($_GET['use2']);
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
                <legend>Fiche de distributions d'un biens/produit</legend>
                <?php
                include 'liste_distribution_by_idbiens.php';
                ?>
            </fieldset>
        </div>
    </div>
</div>

