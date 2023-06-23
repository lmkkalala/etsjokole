<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/composante-imposition/ComposanteImposition.php';
include '../models/categorieM/Categorie.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-bandcamp" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span><span class="h3">Configuration des composantes contribution</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-asterisk" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">New</span>
    </div>
    <div class="panel panel-body">
        <div>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == (sha1("succes"))))) {
                ?>
                <div class="alert alert-success">
                    <span class="glyphicon glyphicon-ok" style="font-size: 15px;margin-right: 5px;"></span><span>Enregistrement effectué avec succès</span>
                </div>
                <?php
            }
            ?>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == (sha1("traitement_error"))))) {
                ?>
                <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-ban-circle" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur d'enregistrement</span>
                </div>
                <?php
            }
            ?>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == (sha1("remplissage_error"))))) {
                ?>
                <div class="alert alert-warning">
                    <span class="glyphicon glyphicon-blackboard" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur de remplissage, Recommencer SVP</span>
                </div>
                <?php
            }
            ?>

            <form class="form-horizontal" method="POST" action="../contollers/conf-imposition/confImpositionController.php">
                <div class="form-group-lg">
                    <div class="input-group-lg">
                        <label class="control-label">Date configuration :</label>
                        <input class="form-control" type="date" name="tb_dateconf">
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Valeur pourcentage (%) :</label>
                        <input class="form-control" type="text" name="tb_pourcentage" placeholder="en %">
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Composante contribution patron concernée :</label>
                        <select class="form-control select2" name="cb_composanteimposition">
                            <option value="0">Choisir composante contribution patron</option>
                            <?php
                            $bdcomposanteimposition = new BdComposanteImposition();
                            $composanteimpositions = $bdcomposanteimposition->getComposanteImpositionAllDesc();
                            foreach ($composanteimpositions as $composanteimposition) {
                                if ($composanteimposition['active']) {
                                    if (1) {
                                        ?>
                                        <option value="<?= $composanteimposition['id'] ?>"><?= $composanteimposition['designation'] . " / " . $composanteimposition['unite'] . " / " . $composanteimposition['type'] ?></option>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Catégorie salariale :</label>
                        <select class="form-control select2" name="cb_categorie">
                            <option value="0">Choisir une categorie salariale</option>
                            <?php
                            $bdcategorie = new BdCategorieM();
                            $categories = $bdcategorie->getCategorieAllDesc();
                            foreach ($categories as $categorie) {
                                if ($categorie['active']) {
                                    if (1) {
                                        ?>
                                        <option value="<?= $categorie['id'] ?>"><?= $categorie['designation'] ?></option>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <fieldset>
                        <legend></legend>
                        <div class="input-group-lg">
                            <input class="btn btn-success" type="submit" name="bt_enregistrer" value="Save">
                            <input class="btn btn-danger" type="reset" value="Reset">
                        </div>
                    </fieldset>
                </div>
            </form>
        </div>

    </div>
</div>

