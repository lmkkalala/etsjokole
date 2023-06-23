<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/attribution-biens/attributionBiens.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-list-alt" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-gift" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Order</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-list-ol" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">List</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Orders</legend>
                <table class="table table-bordered table-responsive-lg">
                    <thead>
                    <th>
                        Num. Commande
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        Etat
                    </th>
                    <th>
                        Biens/produits
                    </th>
                    <th>
                        Gestion
                    </th>
                    <th>
                        Fournisseur
                    </th>
                    <th>
                        Quantité
                    </th>
                    <th>
                        Délai de livraison
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdattributionbiens = new BdAttributionBiens();
                        $attributions = $bdattributionbiens->getAttributionBiensAllDesc();
                        foreach ($attributions as $attribution) {
                            $n++;
                            ?>
                            <tr>
                                <td><?= $attribution['numeroOrder'] ?></td>
                                <td><?= $attribution['date'] ?></td>
                                <td>
                                    <b>
                                        <?php
                                        if ($attribution['etat']) {
                                            echo 'Finalisée';
                                        } else {
                                            echo 'En cours';
                                        }
                                        ?>
                                    </b>
                                </td>
                                <td><?= $attribution['bDesignation']." : ".$attribution['gDesignation'] ?></td>
                                <td><?= $attribution['technique_gestion'] ?></td>
                                <td><?= $attribution['fDesignation']." : ".$attribution['domaine'] ?></td>
                                <td><?= $attribution['quantite_minimale'] ?></td>
                                <td><?= $attribution['delai_livraison'] ?></td>
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

