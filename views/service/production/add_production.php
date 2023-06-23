<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/preparation/preparation.php';
include '../models/nourriture/nourriture.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-cube" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-plus-square-o" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Gestion des productions</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-asterisk" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">New</span>
    </div>
    <div class="panel panel-body">
        <div>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1('succes')))) {
                ?>
                <div class="alert alert-success">
                    <span class="glyphicon glyphicon-ok" style="font-size: 15px;margin-right: 5px;"></span><span>Enregistrement effectué avec succès</span>
                </div>
                <?php
            }
            ?>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1('traitement_error')))) {
                ?>
                <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-ban-circle" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur d'enregistrement</span>
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

            <form class="form-horizontal" method="POST" action="../contollers/production/productionController.php">
                <div class="form-group-lg">
                    
                
                    <div class="input-group-lg">
                        <label class="control-label">Produit :</label>
                        <select class="form-control select2" name="cb_nourriture">
                            <option value="0">Choisir un produit</option>
                            <?php
                            $bdnourriture = new BdNourriture();
                            $nourritures = $bdnourriture->getNourritureAllActive();
                            foreach ($nourritures as $nourriture) {
                                if (1) {
                                    ?>
                                        <option value="<?= $nourriture['id']; ?>"><?= $nourriture['designation']; ?></option>
                                        <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Date Time : </label>
                        <p style="font-size: 20px; color: dodgerblue;"><?= (date('Y-m-d H:i')); ?></p>
                        <input class="form-control" type="hidden" name="tb_dateheure" value="<?= (date('Y-m-d H:i')); ?>">
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Quantité produite :</label>
                        <input class="form-control" type="text" name="tb_quantite" placeholder="Quantité">
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Prix unitaire vente :</label>
                        <input class="form-control" type="text" name="tb_prixUnitaireVente" placeholder="en USD">
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

