<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/production/production.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="glyphicon glyphicon-share" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span><span class="h3">Production nourriture</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-edit" style="color: dodgerblue; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Update</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Liste</legend>
                <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("succes") ))) {
                    ?>
                    <div class="alert alert-success">
                        <span class="glyphicon glyphicon-ok" style="font-size: 15px;margin-right: 5px;"></span><span>Modification effectuée avec succès</span>
                    </div>
                    <?php
                }
                ?>
                <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("traitement_error") ))) {
                    ?>
                    <div class="alert alert-danger">
                        <span class="glyphicon glyphicon-ban-circle" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur de modification</span>
                    </div>
                    <?php
                }
                ?>
                <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("remplissage_error")))) {
                    ?>
                    <div class="alert alert-warning">
                        <span class="glyphicon glyphicon-blackboard" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur de remplissage, Recommencer SVP</span>
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
                        Date Time
                    </th>
                    <th>
                        Nourriture
                    </th>
                    <th>
                        Preparation
                    </th>
                    <th>
                        Quantite
                    </th>
                    <th>
                        Etat
                    </th>
                    <th>
                        Opération
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdproduction = new BdProduction();
                        $productions = $bdproduction->getProductionByServiceId($_SESSION['idservice']);
                        foreach ($productions as $production) {
                            $n++;
                            ?>
                            <tr>
                                <td><?= $production['id'] ?></td>
                                <td><?= $production['dateHeurePD'] ?></td>
                                <td><?= $production['designation'] ?></td>
                                <td><?= $production['dateHeurePD'] ?></td>
                                <td><?= $production['quantite'] ?></td>
                                <td>
                                    <?php
                                    if ($production['active'] == 1) {
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
                                <td>
                                    <form class="form-inline" method="post" action="../contollers/production/productionController.php">
                                        <table>
                                            <tr>
                                                <td>
                                                    <input class="form-control" type="text" name="tb_quantite" value="<?= $production['quantite'] ?>">
                                                    <input type="hidden" name="tb_idproduction" value="<?= $production['id'] ?>">
                                                </td>
                                                <td>
                                                    <button style="margin-left: 10px;" class="btn btn-primary" type="submit" name="bt_modifier"><span style="color: white;" class="glyphicon glyphicon-pencil"></span></button>
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
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

