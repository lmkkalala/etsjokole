<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/nourriture/nourriture.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-database" style="color: darkslategray; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Gestion des produits</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-edit" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Mise à jour</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Les produits enregistrées</legend>
                <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1('succes')))) {
                    ?>
                    <div class="alert alert-success">
                        <span class="glyphicon glyphicon-ok" style="font-size: 15px;margin-right: 5px;"></span><span>Modification effectué avec succès</span>
                    </div>
                    <?php
                }
                ?>
                <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1('traitement_error')))) {
                    ?>
                    <div class="alert alert-danger">
                        <span class="glyphicon glyphicon-ban-circle" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur de traitment</span>
                    </div>
                    <?php
                }
                ?>
                <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1('remplissage_error')))) {
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
                        Désignation
                    </th>
                    <th>
                        Opération
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdnourriture = new BdNourriture();
                        $nourritures = $bdnourriture->getNourritureAllDesc();
                        foreach ($nourritures as $nourriture) {
                            ++$n; ?>
                        <form class="form-horizontal" method="POST" action="../contollers/nourriture/nourritureController.php">
                            <div class="form-group-lg">
                                <tr>
                                    <td><?= $nourriture['id']; ?></td>
                                    <td><input class="form-control" type="text" name="tb_designation" value="<?= $nourriture['designation']; ?>"></td>
                                <input type = "hidden" name = "tb_idnourriture" value ="<?= $nourriture['id']; ?>">
                                <td><button type="submit" class="btn btn-primary" name="bt_modifier"><span class="glyphicon glyphicon-pencil" style="color: white; font-size: 20px;margin-right: 5px;"></span></button></td>                                    
                                </tr>
                            </div>
                        </form>
                        <?php
                        }
                    ?>
                    </tbody>
                    <tfoot>
                    <td style="font-size: 20px;">
                        <span>Nombre:</span><span><?= $n; ?></span>
                    </td>
                    </tfoot>
                </table>
            </fieldset>
        </div>
    </div>
</div>

