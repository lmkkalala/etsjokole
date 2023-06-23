<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/livraison/livraison.php';
include '../models/demande/demande.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-cubes" style="color: #0069d9; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-recycle" style="color: #0069d9; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Récuperation</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-list-ol" style="color: darkgray; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">listes de toutes les récuperations</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Les livraisons</legend>
                <table class="table table-bordered table-responsive-lg">
                    <thead>
                    <th>
                        N°
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        Demande
                    </th>
                    <th>
                        Quantité
                    </th>
                    <th>
                        Livreur
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdlivraison = new BdLivraison();
                        $livraisons = $bdlivraison->getLivraisonAllDesc();
                        foreach ($livraisons as $livraison) {
                            if ($livraison['lEtat'] == 1) {
                                $n++;
                                ?>
                                <tr>
                                    <td><?= $livraison['lId'] ?></td>
                                    <td><?= $livraison['lDate'] ?></td>
                                    <td><?= $livraison['dId'] ?> . <?= $livraison['date'] . " / " . $livraison['bDesignation'] . " / " . $livraison['gDesignation'] . " pour " . $livraison['nom'] . " " . $livraison['postnom'] . " " . $livraison['prenom'] . " : " . $livraison['sDesignation'] . " / quantité : " . $livraison['dQuantite'] ?></td>
                                    <td><?= $livraison['lQuantite'] ?></td>
                                    <td><?= $livraison['lNom'] . " " . $livraison['lPostnom'] . " " . $livraison['lPrenom'] ?></td>
                                </tr>
                                <?php
                            }
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

