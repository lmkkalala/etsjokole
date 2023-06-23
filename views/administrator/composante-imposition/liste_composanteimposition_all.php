<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/composante-imposition/ComposanteImposition.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-bandcamp" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span><span class="h3">Composante contisation patron</span>
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
                        Name
                    </th>
                    <th>
                        Unité de mesure
                    </th>
                    <th>
                        Type
                    </th>
                    <th>
                        State
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdcomposanteimposition = new BdComposanteImposition();
                        $composanteimpositions = $bdcomposanteimposition->getComposanteImpositionAllDesc();
                        foreach ($composanteimpositions as $composanteimposition) {
                            $n++;
                            ?>
                            <tr>
                                <td><?= $composanteimposition['id'] ?></td>
                                <td><?= $composanteimposition['designation'] ?></td>
                                <td><?= $composanteimposition['unite'] ?></td>
                                <td><?= $composanteimposition['type'] ?></td>
                                <td>
                                    <?php
                                    if ($composanteimposition['active'] == 1) {
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

