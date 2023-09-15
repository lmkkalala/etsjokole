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
        <span class="fa fa-list" style="color: lightslategray; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">List</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>List</legend>
                <table id="list_fournisseur" class="table table-bordered table-responsive-lg table-condensed">
                    <thead>
                    <th>
                        N°
                    </th>
                    <th>
                        Désignation
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
                        Tel.
                    </th>
                    <th>
                        Email
                    </th>
                    <th>
                        Etat
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdfournisseur=new BdFournisseur();
                        $fournisseurs=$bdfournisseur->getFournisseurAllDesc();
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
                                <td><?= $fournisseur['telephone'] ?></td>
                                <td><?= $fournisseur['email'] ?></td>
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

