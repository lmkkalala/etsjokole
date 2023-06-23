<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/unite/unite.php';
include '../models/biens/biens.php';
include '../models/ravitaillement/ravitaillement.php';
include '../models/distribution/distribution.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-archive" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">les unités</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-list-ol" style="color: #0069d9; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Liste des unités du ravitaillement</span>
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
                    </thead>
                    <tbody>
                        <?php
                        $paniers = explode("/", $_GET['use']);
                        $n = 0;
                        $bdunite = new BdUnite();
                        $unites = $bdunite->getUniteAllDesc();
                        foreach ($unites as $unite) {
                            foreach ($paniers as $pan) {
                                if (($pan != "") && ($pan == $unite['code']) && (1)) {
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
                                    </tr>
                                    <?php
                                }
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

