<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/fournisseur/fournisseur.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-archive" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-user" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Supplier</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-check-square-o" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Activation</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>List</legend>
                <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("succes")))) {
                    ?>
                    <div class="alert alert-success">
                        <span class="glyphicon glyphicon-ok" style="font-size: 15px;margin-right: 5px;"></span><span>Activation effectuée avec succès</span>
                    </div>
                    <?php
                }
                ?>
                <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("traitement_error") ))) {
                    ?>
                    <div class="alert alert-danger">
                        <span class="glyphicon glyphicon-ban-circle" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur d'activation</span>
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
                        Name
                    </th>
                    <th>
                        Domaine d'activité
                    </th>
                    <th>
                        Adresse
                    </th>
                    <th>
                        Ville
                    </th>
                    <th>
                        Province
                    </th>
                    <th>
                        Pays
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
                        $bdfournisseur = new BdFournisseur();
                        $fournisseurs = $bdfournisseur->getFournisseurAllDesc();
                        foreach ($fournisseurs as $fournisseur) {
                            $n++;
                            ?>
                            <tr>
                                <td><?= $fournisseur['id'] ?></td>
                                <td><?= $fournisseur['designation'] ?></td>
                                <td><?= $fournisseur['domaine'] ?></td>
                                <td><?= $fournisseur['adresse'] ?></td>
                                <td><?= $fournisseur['ville'] ?></td>
                                <td><?= $fournisseur['province'] ?></td>
                                <td><?= $fournisseur['pays'] ?></td>
                                <td>
                                    <?php
                                    if ($fournisseur['active'] == 1) {
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
                                    <?php
                                    if ($fournisseur['active'] == 1) {
                                        ?>
                                        <form method="post" action="../contollers/fournisseur/fournisseurController.php">
                                            <input type="hidden" name="tb_idfournisseur" value="<?= $fournisseur['id'] ?>">
                                            <input type="hidden" name="tb_operation" value="desactive">
                                            <button type="submit" name="bt_active" class="btn btn-danger"><span class="glyphicon glyphicon-lock" style="color: white; font-size: 15px;margin-right: 5px;"></span></button>
                                        </form>
                                        <?php
                                    } else {
                                        ?>
                                        <form method="post" action="../contollers/fournisseur/fournisseurController.php">
                                            <input type="hidden" name="tb_idfournisseur" value="<?= $fournisseur['id'] ?>">
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
                        <span>Nombre:</span><span><?= $n ?></span>
                    </td>
                    </tfoot>
                </table>
            </fieldset>
        </div>
    </div>
</div>

