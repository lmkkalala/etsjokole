<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/categorie/categorie.php';
include '../models/biens/biens.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-database" style="color: darkslategray; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Gestion des catégories de biens/produits</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-file-text-o" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Fiche des biens/produits d'une catégorie</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Fiche de la catégorie</legend>
                <?php
                $bdcategorie=new BdCategorie();
                $categories=$bdcategorie->getCategorieById($_GET['use']);
                foreach ($categories as $categorie) {
                    ?>
                    <table class="table table-bordered table-responsive-lg table-striped">
                        <tr>
                            <td><b>N°</b></td>
                            <td><?= $categorie['id'] ?></td>
                        </tr>
                        <tr>
                            <td><b>Désignation</b></td>
                            <td><?= $categorie['designation'] ?></td>
                        </tr>
                        <tr>
                            <td><b>Etat</b></td>
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
                    </table>
                    <?php
                }
                ?>
            </fieldset>
            <fieldset>
                <legend>Les biens/produits dans cette catégorie</legend>
                <?php
                                include 'liste_biens_by_categorie.php';
                ?>
            </fieldset>
        </div>
    </div>
</div>

