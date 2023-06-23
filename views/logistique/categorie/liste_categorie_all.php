<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/categorie/categorie.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-database" style="color: darkslategray; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Gestion des catégories de biens/produits</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-list-ol" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Liste des catégories</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Liste des catégories</legend>
                <table class="table table-bordered table-responsive-lg">
                    <thead>
                    <th>
                        N°
                    </th>
                    <th>
                        Désignation
                    </th>
                    <th>
                        Etat
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdcategorie=new BdCategorie();
                        $categories=$bdcategorie->getCategorieAllDesc();
                        foreach ($categories as $categorie) {
                            $n++;
                            ?>
                            <tr>
                                <td><?= $categorie['id'] ?></td>
                                <td><?= $categorie['designation'] ?></td>
                                <td>
                                    <?php
                                    if ($categorie['active'] == 1) {
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

