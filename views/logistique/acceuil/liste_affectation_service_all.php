<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/affectation-service/affectationService.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="glyphicon glyphicon-share" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span><span class="h3">Affectation des agents</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-list" style="color: #0069d9; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Liste des affectation</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Liste des services</legend>
                <table class="table table-bordered table-responsive-lg">
                    <thead>
                    <th>
                        N°
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        Agent
                    </th>
                    <th>
                        Service
                    </th>
                    <th>
                        Etat
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdaffectation=new BdAffectationService();
                        $affectations = $bdaffectation->getAffectationServiceAllDesc();
                        foreach ($affectations as $affectation) {
                            $n++;
                            ?>
                            <tr>
                                <td><?= $affectation['Id'] ?></td>
                                <td><?= $affectation['date'] ?></td>
                                <td><?= $affectation['nom']." ".$affectation['postnom']." ".$affectation['prenom'] ?></td>
                                <td><?= $affectation['designation'] ?></td>
                                <td>
                                    <?php
                                    if ($affectation['active'] == 1) {
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

