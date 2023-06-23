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
        <span class="fa fa-usd" style="color: darkslategray; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Currency</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-check-square-o" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Activation</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>List of currency</legend>
                <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("succes")))) {
                    ?>
                    <div class="alert alert-success">
                        <span class="glyphicon glyphicon-ok" style="font-size: 15px;margin-right: 5px;"></span><span>Success</span>
                    </div>
                    <?php
                }
                ?>
                <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("traitement_error") ))) {
                    ?>
                    <div class="alert alert-danger">
                        <span class="glyphicon glyphicon-ban-circle" style="font-size: 15px;margin-right: 5px;"></span><span>Error</span>
                    </div>
                    <?php
                }
                ?>
                <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("remplissage_error")))) {
                    ?>
                    <div class="alert alert-warning">
                        <span class="glyphicon glyphicon-blackboard" style="font-size: 15px;margin-right: 5px;"></span><span>Data error</span>
                    </div>
                    <?php
                }
                ?>
                <table class="table table-bordered table-responsive-lg">
                    <thead>
                    <th>
                        N°
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        Value
                    </th>
                    <th>
                        Sit.
                    </th>
                    <th>
                        Operation
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdtaux=new BdTaux();
                        $taux=$bdtaux->getTauxAll();
                        foreach ($taux as $tau) {
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
                                <td>
                                    <?php
                                    if ($tau['active'] == 1) {
                                        ?>
                                        <form method="post" action="../contollers/taux/tauxController.php">
                                            <input type="hidden" name="tb_idtaux" value="<?= $tau['id'] ?>">
                                            <input type="hidden" name="tb_operation" value="desactive">
                                            <button type="submit" name="bt_active" class="btn btn-danger"><span class="glyphicon glyphicon-lock" style="color: white; font-size: 15px;margin-right: 5px;"></span></button>
                                        </form>
                                        <?php
                                    } else {
                                        ?>
                                        <form method="post" action="../contollers/taux/tauxController.php">
                                            <input type="hidden" name="tb_idtaux" value="<?= $tau['id'] ?>">
                                            <input type="hidden" name="tb_operation" value="active">
                                            <button type="submit" name="bt_active" class="btn btn-success"><span class="glyphicon glyphicon-check" style="color: white; font-size: 15px;margin-right: 5px;"></span></button>
                                        </form>
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

