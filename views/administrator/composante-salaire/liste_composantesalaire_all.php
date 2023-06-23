<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/composante-salaire/ComposanteSalaire.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-bandcamp" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span><span class="h3">Composante salaire</span>
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
                        Code
                    </th>
                    <th>
                        Name
                    </th>
                    <th>
                        Unité de mesure
                    </th>
                    <th>
                        Type
                    </th>
                    <th>
                        Nature
                    </th>
                    <th>
                        Quantité par defaut
                    </th>
                    <th>
                        State
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdcomposantesalaire = new BdComposanteSalaire();
                        $composantesalaires = $bdcomposantesalaire->getComposanteSalaireAllDesc();
                        foreach ($composantesalaires as $composantesalaire) {
                            $n++;
                            ?>
                            <tr>
                                <td><?= $composantesalaire['id'] ?></td>
                                <td><?= $composantesalaire['code'] ?></td>
                                <td><?= $composantesalaire['designation'] ?></td>
                                <td><?= $composantesalaire['unite'] ?></td>
                                <td><?= $composantesalaire['type'] ?></td>
                                <td><?= $composantesalaire['nature'] ?></td>
                                <td><?= $composantesalaire['defaultQuantite'] ?></td>
                                <td>
                                    <?php
                                    if ($composantesalaire['active'] == 1) {
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

