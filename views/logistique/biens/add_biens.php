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
        <span class="fa fa-cube" style="color: #0069d9; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Items</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-asterisk" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">New</span><a style="font-size: 20px;" href='../views/home.php?link=<?= sha1("logistique_biens_add") . '&link_up=' . sha1("home_logistique_biens") ?>' class="btn btn-info pull-right"><span class="fa fa-refresh"></span></a>
    </div>
    <div class="panel panel-body">
        <div>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("succes")))) {
                ?>
                <div class="alert alert-success">
                    <span class="glyphicon glyphicon-ok" style="font-size: 15px;margin-right: 5px;"></span><span>Enregistrement effectué avec succès</span>
                </div>
                <?php
            }
            ?>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("traitement_error")))) {
                ?>
                <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-ban-circle" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur d'enregistrement</span>
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
                <a style="font-size: 20px;" href='../views/home.php?link=<?= sha1("logistique_categorie_add").'&link_up='. sha1("home_logistique_categorie") ?>' class="btn btn-danger pull-right">New Group</a>
            </fieldset>

            <form class="form-horizontal" method="POST" action="../contollers/biens/biensController.php">
                <div class="form-group-lg">
                    <div class="input-group-lg">
                        <label class="control-label">Catégorie :</label>
                        <select class="form-control select2" name="cb_categorie">
                            <option value="0">Choisir une catégorie</option>
                            <?php
                            $bdcategorie = new BdCategorie();
                            $categories = $bdcategorie->getCategorieAllDesc();
                            foreach ($categories as $categorie) {
                                if ($categorie['active']) {
                                    ?>
                            <option value="<?= $categorie['id'] ?>"><?= $categorie['designation'] ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label" style="color: red;">Perissable ? :</label>
                        <input class="radio-inline" type="radio" name="rb_typeperissable" value="1">Yes
                        <input class="radio-inline" type="radio" name="rb_typeperissable" value="0" checked>No
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Name :</label>
                        <input class="form-control" type="text" name="tb_designation" placeholder="Désignation">
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Unit price :</label>
                        <input class="form-control" type="text" name="tb_prixunitaire" placeholder="Prix unitaire">
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Quantity :</label>
                        <input class="form-control" type="text" name="tb_quantite" placeholder="Quantité">
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Crisis level :</label>
                        <input class="form-control" type="text" name="tb_stockcritique" placeholder="Niveau du Stock critique">
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Codebarre :</label>
                        <input class="form-control" type="text" name="tb_codebarre" placeholder="Scanner codebarre">
                    </div>
                    <fieldset>
                        <legend></legend>
                        <div class="input-group-lg">
                            <input class="btn btn-success" type="submit" name="bt_enregistrer" value="Enregistrer">
                            <input class="btn btn-danger" type="reset" value="Initialiser">
                        </div>
                    </fieldset>
                </div>
            </form>
        </div>

    </div>
</div>

