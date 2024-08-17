<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/biens/biens.php';
include '../models/categorie/categorie.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-cube" style="color: #0069d9; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Items</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-edit" style="color: darkorange; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Update</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>List</legend>
                <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("succes")))) {
                    ?>
                    <div class="alert alert-success">
                        <span class="glyphicon glyphicon-ok" style="font-size: 15px;margin-right: 5px;"></span><span>Modification effectué avec succès</span>
                    </div>
                    <?php
                }
                ?>
                <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("traitement_error")))) {
                    ?>
                    <div class="alert alert-danger">
                        <span class="glyphicon glyphicon-ban-circle" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur de traitment</span>
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
                <fieldset>
                    <legend>Rechercher :</legend>
                    <form class="form-inline" method="POST" action="../contollers/biens/biensController.php">
                        <div class="row form-group-lg">
                            <div class="col-6">
                            <select class="form-control select2" name="cb_biens">
                                <option value="0">Choisir un produit</option>
                                <?php
                                $bdbiens = new BdBiens();
                                $biens = $bdbiens->getBiensAllDesc();
                                foreach ($biens as $bien) {
                                    if (1) {
                                        if (1) {
                                            ?>
                                            <option value="<?= $bien['bId'] ?>"><?= $bien['bDesignation'] . " / Marque : " . $bien['marque'] . " / " . $bien['gDesignation'] . " / Codebarre: " . $bien['codebarre'] ?></option>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </select>
                            </div>
                            <div class="col-6">
                            <button type="submit" class="btn btn-success" name="bt_search_for_update"><span class="glyphicon glyphicon-search" style="color: white; font-size: 20px;margin-right: 5px;"></span> Rechercher</button>
                            </div>
                           
                        </div>
                    </form>
                </fieldset>
                <table id="" class="table table-bordered table-responsive-lg table-condensed">
                    <thead>
                        <tr>
                            <th>
                                N°
                            </th>
                            <th>
                                Catégorie, Désignation
                            </th>
                            <th>
                                Marque
                            </th>
                            <th>
                                Gestion
                            </th>
                            <th>
                                Quantité, PU
                            </th>
                            <th>
                                Stock Max,Min,Critique
                            </th>
                            <th>
                                Codebarre
                            </th>
                            <th>
                                Périssable
                            </th>
                            
                            <th>
                                Opération
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdbiens = new BdBiens();
                        if ((isset($_GET['use_biens'])) && ($_GET['use_biens']!=0)) {
                           $biens = $bdbiens->getBiensById($_GET['use_biens']); 
                        } else {
                            $biens = $bdbiens->getBiensAllDesc(); 
                        }
                        
                        foreach ($biens as $bien) {
                            $n++;
                            ?>
                        <form class="form-horizontal" method="POST" action="../contollers/biens/biensController.php">
                            <div class="form-group-lg">
                                <tr>
                                    <td><?=$bien['bId'] ?></td>
                                    <td>
                                        
                                        <select class="form-control" name="cb_categorie">
                                            <?php
                                            $bdcategorie = new BdCategorie();
                                            $categories = $bdcategorie->getCategorieAllDesc();
                                            foreach ($categories as $categorie) {
                                                if ($categorie['id'] == $bien['gId']) {
                                                    ?>
                                                    <option value="<?= $categorie['id'] ?>" selected><?= $categorie['designation'] ?></option>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <option value="<?= $categorie['id'] ?>"><?= $categorie['designation'] ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        <input class="form-control mt-1" type="text" name="tb_designation" value="<?= $bien['bDesignation'] ?>">
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" name="tb_marque" value="<?= $bien['marque'] ?>">
                                    </td>
                                    <td>
                                        <select class="form-control" name="cb_gestion">
                                            <option value="FIFO" 
                                            <?php
                                                if ($bien['technique_gestion'] == "FIFO") {
                                                    echo 'selected';
                                                }
                                            ?>
                                                    >FIFO</option>
                                            <option value="LIFO"
                                            <?php
                                                if ($bien['technique_gestion'] == "LIFO") {
                                                    echo 'selected';
                                                }
                                            ?>
                                                    >LIFO</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" name="tb_quantite" value="<?= $bien['quantite'] ?>">
                                        <input class="form-control mt-1" type="text" name="tb_prixunitaire" value="<?= $bien['prixunitaire'] ?>">
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" name="tb_stockmax" value="<?= $bien['stock_max'] ?>">
                                        <input class="form-control mt-1" type="text" name="tb_stockmin" value="<?= $bien['stock_min'] ?>">
                                        <input class="form-control mt-1" type="text" name="tb_stockcritique" value="<?= $bien['stock_critique'] ?>">
                                    </td>
                                    <td><input class="form-control" type="text" name="tb_codebarre" value="<?= $bien['codebarre'] ?>"></td>
                                    <td>
                                        <?php
                                        if ($bien['type_perissable']) {
                                            ?>
                                            <input class="radio" type="radio" name="rb_typeperissable" value="1" checked>Oui
                                            <input class="radio" type="radio" name="rb_typeperissable" value="0">Non
                                            <?php
                                        } else {
                                            ?>
                                            <input class="radio" type="radio" name="rb_typeperissable" value="1">Oui
                                            <input class="radio" type="radio" name="rb_typeperissable" value="0" checked>Non
                                            <?php
                                        }
                                        ?>

                                    </td>
                                <input type = "hidden" name = "tb_idbiens" value ="<?= $bien['bId'] ?>">
                                <td><button type="submit" class="btn btn-primary" name="bt_modifier"><span class="glyphicon glyphicon-pencil" style="color: white; font-size: 20px;margin-right: 5px;"></span> Modifier</button></td>                                    
                                </tr>
                            </div>
                        </form>
                        <?php
                    }
                    ?>
                    </tbody>
                    <tfoot>

                       <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th style="font-size: 20px;">
                                <span>Nombre:</span><span><?= $n ?></span>
                            </th>
                       </tr>
                    </tfoot>
                </table>
            </fieldset>
        </div>
    </div>
</div>

