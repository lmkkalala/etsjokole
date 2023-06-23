<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/chargeconf/ChargeConf.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-bandcamp" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span><span class="h3">Charge de l'employé</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-list" style="color: darkslategray; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">List</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Liste</legend>
                <table class="table table-bordered table-responsive-lg">
                    <thead>
                    <th>
                        #
                    </th>
                    <th>
                       Date configuration
                    </th>
                    <th>
                        Employé
                    </th>
                    <th>
                        Etat civil
                    </th>
                    <th>
                        Nombre enfant
                    </th>
                    <th>
                        Nombre personne en charge
                    </th>
                    <th>
                        State
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdchargeconf = new BdChargeConf();
                        $chargeconfs = $bdchargeconf->getChargeConfAllDesc();
                        foreach ($chargeconfs as $chargeconf) {
                            $n++;
                            ?>
                            <tr>
                                <td><?= $chargeconf['ccId'] ?></td>
                                <td><?= $chargeconf['dateConf'] ?></td>
                                <td><?= "Matricule : ".$chargeconf['matricule']." / ".$chargeconf['nom']." ".$chargeconf['postnom']." ".$chargeconf['prenom']." / sexe : ".$chargeconf['sexe'] ?></td>
                                <td><?= $chargeconf['etatCivil'] ?></td>
                                <td><?= $chargeconf['nombreEnfant'] ?></td>
                                <td><?= $chargeconf['nombreFemme'] ?></td>
                                <td>
                                    <?php
                                    if ($chargeconf['ccActive'] == 1) {
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
                        <span>Number:</span><span><?= $n ?></span>
                    </td>
                    </tfoot>
                </table>
            </fieldset>
        </div>
    </div>
</div>

