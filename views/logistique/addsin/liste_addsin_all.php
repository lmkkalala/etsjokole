<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/addsin/AddsIn.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-usd" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-plus-square-o" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Nature de coûts supp.</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-list-ol" style="color: darkgrey; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Liste</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <table class="table table-bordered table-responsive-lg table-striped">
                    <thead>
                        <th>
                            N°
                        </th>
                        <th>
                            Désignation
                        </th>
                        <th>
                            Sit.
                        </th>
                        <th>
                            Op. 1
                        </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdAddsin = new BdAddsIn();
                        $addsins = $bdAddsin->getAddsInAll();
                        foreach ($addsins as $addsin) {
                            if (1) {
                                $n++;
                        ?>
                                <tr>
                                    <td><?= $addsin['id'] ?></td>
                                    <td><?= $addsin['designation'] ?></td>
                                    <td>
                                        <?php
                                        if ($addsin['active'] == 1) {
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
                                    <td>
                                        <form method="post" action="../contollers/addsin/addsinController.php">
                                            <input type="hidden" name="tb_idaddsin" value="<?= $addsin['id'] ?>">
                                            <?php
                                            if ($addsin['active'] == "1") {
                                            ?>
                                                <input type="hidden" name="tb_operation" value="desactive">
                                                <button type="submit" name="bt_active" class="btn btn-danger"><span class="fa fa-lock" style="color: white; font-size: 15px;margin-right: 5px;"></span></button>
                                            <?php
                                            } else if ($addsin['active'] == "0") {
                                            ?>
                                                <input type="hidden" name="tb_operation" value="active">
                                                <button type="submit" name="bt_active" class="btn btn-success"><span class="fa fa-unlock" style="color: white; font-size: 15px;margin-right: 5px;"></span></button>
                                            <?php
                                            }
                                            ?>


                                        </form>
                                    </td>
                                    <td>
                                        <form method="post" action="../contollers/addsin/addsinController.php">
                                            <input type="hidden" name="tb_idaddsin" value="<?= $addsin['id'] ?>">
                                            <button type="submit" name="bt_for_update" class="btn btn-info"><span class="fa fa-pencil" style="color: white; font-size: 15px;margin-right: 5px;"></span></button>
                                        </form>
                                    </td>
                                    <td>
                                        <form method="post" action="../contollers/addsin/addsinController.php">
                                            <input type="hidden" name="tb_idaddsin" value="<?= $addsin['id'] ?>">
                                            <button type="submit" name="bt_for_statistics" class="btn btn-warning"><span class="fa fa-bars" style="color: white; font-size: 15px;margin-right: 5px;"></span> Statistics</button>
                                        </form>
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