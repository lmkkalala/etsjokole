<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/unite/unite.php';
include '../models/biens/biens.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-archive" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">les unités</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-list-ol" style="color: darkgray; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Liste de toutes les unités</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Liste des unités</legend>
                <table class="table table-bordered table-responsive-lg">
                    <thead>
                    <th>
                        N°
                    </th>
                    <th>
                        Code
                    </th>
                    <th>
                        Biens
                    </th>
                    <th>
                        Date achat
                    </th>
                    <th>
                        Date expiration
                    </th>
                    <th>
                        Etat
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdunite = new BdUnite();
                        //$unites = $bdunite->getUniteAllDesc();
                        $unites = $bdunite->getUniteAllLimit('1000');
                        foreach ($unites as $unite) {
                            $n++;
                            $bdbiens = new BdBiens();
                            $biens = $bdbiens->getBiensById($unite['biens_id']);
                            foreach ($biens as $bien) {
                                $info_biens = $bien['bDesignation'] . " / " . $bien['gDesignation']. " / Marque : " . $bien['marque'];
                            }
                            ?>
                            <tr> 
                                <td><?= $unite['id'] ?></td>
                                <td><?= $unite['code'] ?></td>
                                <td><?= $info_biens ?></td>
                                <td><?= $unite['date_achat'] ?></td>
                                <td><?= $unite['date_expiration'] ?></td>
                                <td>
                                    <?php
                                    if ($unite['active'] == 1) {
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

