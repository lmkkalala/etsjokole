<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/demande/demande.php';
include '../models/preparation/preparation.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-cube" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-plus-square-o" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Gestion des demandes</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-list-ol" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-time" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Liste des demandes finalisées en interne</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Demandes encours</legend>
                <table class="table table-bordered table-responsive-lg">
                    <thead>
                    <th>
                        N°
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        Biens/produit
                    </th>
                    <th>
                        Preparation
                    </th>
                    <th>
                        Demandeur
                    </th>
                    <th>
                        Quantité
                    </th>
                    <th>
                        Etat
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bddemande = new BdDemande();
                        $demandes = $bddemande->getDemandeAllDescFinaliseInterne();
                        foreach ($demandes as $demande) {
                            if (($demande['sId'] == $_SESSION['idservice'])) {

                                $n++;
                                ?>
                                <tr>
                                    <td><?= $demande['dId'] ?></td>
                                    <td><?= $demande['date'] ?></td>
                                    <td><?= $demande['bDesignation'] . " / " . $demande['gDesignation'] ?></td>
                                    <td>
                                        <?php
                                        $bdpreparation = new BdPreparation();
                                        $preparations = $bdpreparation->getPreparationById($demande['preparation_id']);
                                        foreach ($preparations as $preparation) {
                                            echo $preparation['dateHeure'] . " / " . $preparation['typerepas'];
                                        }
                                        ?>
                                    </td>
                                    <td><?= $demande['nom'] . " " . $demande['postnom'] . " " . $demande['prenom'] ?></td>
                                    <td><?= $demande['dQuantite'] ?></td>
                                    <td>
                                        <?php
                                        if ($demande['etatDistribution'] == 0) {
                                            ?>
                                            <h4 style="color: forestgreen;">Encours en interne</h4>
                                            <?php
                                        } else {
                                            ?>
                                            <h4 style="color: red;">Finalisée en interne</h4>
                                            <?php
                                        }
                                        ?>
                                    </td>
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

