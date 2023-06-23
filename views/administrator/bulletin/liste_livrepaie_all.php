<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/livrepaie/LivrePaie.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-bandcamp" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span><span class="h3">Livre de paie</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-list" style="color: darkslategray; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">List</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Liste</legend>
                <table class="table table-bordered table-responsive-lg table-striped">
                    <thead>
                    <th>
                        #
                    </th>
                    <th>
                        Date création
                    </th>
                    <th>
                        Mois
                    </th>
                    <th>
                        Année
                    </th>
                    <th>
                        State
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdlivrepaie = new BdLivrePaie();
                        $livrepaies = $bdlivrepaie->getLivrePaieAllDesc();
                        foreach ($livrepaies as $livrepaie) {
                            $n++;
                            ?>
                            <tr>
                                <td><?= $livrepaie['id'] ?></td>
                                <td><?= $livrepaie['dateCreation'] ?></td>
                                <td><?= $livrepaie['mois'] ?></td>
                                <td><?= $livrepaie['annee'] ?></td>
                                <td>
                                    <?php
                                    if ($livrepaie['active'] == 1) {
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

