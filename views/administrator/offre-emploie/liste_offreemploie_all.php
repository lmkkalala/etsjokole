<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/offre-emploie/OffreEmploie.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-bandcamp" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span><span class="h3">Offre d'emploie</span>
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
                        Numero
                    </th>
                    <th>
                        Libelle
                    </th>
                    <th>
                        Date de lancement
                    </th>
                    <th>
                        Date de cloture
                    </th>
                    <th>
                        State
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdOffreEmploie = new BdOffreEmploie();
                        $offreemploies = $bdOffreEmploie->getOffreEmploieAllDesc();
                        foreach ($offreemploies as $offreemploie) {
                            $n++;
                            ?>
                            <tr>
                                <td><?= $offreemploie['id'] ?></td>
                                <td><?= $offreemploie['numero'] ?></td>
                                <td><?= $offreemploie['libelle'] ?></td>
                                <td><?= $offreemploie['dateLancement'] ?></td>
                                <td><?= $offreemploie['dateCloture'] ?></td>
                                <td>
                                    <?php
                                    if ($offreemploie['active'] == 1) {
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

