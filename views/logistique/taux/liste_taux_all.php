<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/taux/taux.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-cube" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-plus-square-o" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Currency</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-list-ol" style="color: darkgrey; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">List of currency</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>List of currency</legend>
                <table class="table table-bordered table-responsive-lg">
                    <thead>
                    <th>
                        N°
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        Value in CDF
                    </th>
                    <th>
                        Sit.
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdtaux=new BdTaux();
                        $taux=$bdtaux->getTauxAll();
                        foreach ($taux as $tau) {
                            if (1) {
                            $n++;
                            ?>
                            <tr>
                                <td><?= $tau['id'] ?></td>
                                <td><?= $tau['datetaux'] ?></td>
                                <td><?= $tau['value'] ?></td>
                                <td>
                                    <?php
                                    if ($tau['active'] == 1) {
                                        ?>
                                        <h4 style="color: forestgreen;">Enabled</h4>
                                        <?php
                                    } else {
                                        ?>
                                        <h4 style="color: red;">Disabled</h4>
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
                        <span>Number:</span><span><?= $n ?></span>
                    </td>
                    </tfoot>
                </table>
            </fieldset>
        </div>
    </div>
</div>

