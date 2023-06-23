<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/promotion/Promotion.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-bandcamp" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span><span class="h3">Promotion</span>
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
                        Date promotion
                    </th>
                    <th>
                        Employe
                    </th>
                    <th>
                        Service
                    </th>
                    <th>
                        Fonction
                    </th>
                    <th>
                        Categorie
                    </th>
                    <th>
                        Type de contrat
                    </th>
                    <th>
                        State
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdpromotion = new BdPromotion();
                        $promotions = $bdpromotion->getPromotionAllDesc();
                        foreach ($promotions as $promotion) {
                            $n++;
                            ?>
                            <tr>
                                <td><?= $promotion['afId'] ?></td>
                                <td><?= $promotion['dateAffectation'] ?></td>
                                <td><?= $promotion['nom']." ".$promotion['postnom']." ".$promotion['prenom']." / sexe : ".$promotion['sexe'] ?></td>
                                <td><?= $promotion['sDesignation'] ?></td>
                                <td><?= $promotion['fDesignation'] ?></td>
                                <td><?= $promotion['ctDesignation'] ?></td>
                                <td><?= $promotion['tcDesignation'] ?></td>
                                <td>
                                    <?php
                                    if ($promotion['afActive'] == 1) {
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

