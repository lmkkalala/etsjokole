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
        <span class="h3">Category</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-book" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Fiche des biens/produits d'une catégorie</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Taper la désignation de la catégorie :</legend>
                <form class="form-inline" method="POST" action="../contollers/categorie/categorieController.php">
                    <div class="row form-group-lg">
                        <div class="col-6">
                        <input type="text" class="form-control" name="tb_search" placeholder="Mot-clé">                            
                        </div>
                        <div class="col-6">
                        <button type="submit" class="btn btn-success" name="bt_search"><span class="glyphicon glyphicon-search" style="color: white; font-size: 20px;margin-right: 5px;"></span> Rechercher</button>
                        </div>
                    </div>
                </form>
            </fieldset>
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
                    <th>
                        Opération
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdcategorie = new BdCategorie();
                        if ((isset($_GET['use']))) {
                            $categories=$bdcategorie->getCategorieByName($_GET['use']);
                        } else {
                            $categories = $bdcategorie->getCategorieAllDesc();
                        }
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
                                <td>
                                    <form method="POST" action="../contollers/categorie/categorieController.php">
                                        <input type="hidden" name="tb_idcategorie" value="<?= $categorie['id'] ?>">
                                        <button type="submit" class="btn btn-primary" name="bt_view"><span class="glyphicon glyphicon-file" style="color: white; font-size: 15px;margin-right: 5px;"></span></button>
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

