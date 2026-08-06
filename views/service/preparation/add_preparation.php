<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//include '../models/affectation-service/affectationService.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-database" style="color: darkslategray; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Activité</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-asterisk" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Ajout</span>
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

            <form class="form-horizontal" method="POST" action="../contollers/preparation/preparationController.php">
                <div class="form-group-lg">
                    <div class="input-group-lg">
                        <label class="control-label">Date :</label>
                        <input class="form-control" type="date" name="tb_dateheure" value="<?= (date('Y-m-d')) ?>">
                    </div>
                    <br>
                    <div class="input-group-lg">
                        <label class="control-label">Type :</label>
                        <select class="form-control select2" name="cb_typerepas">
                            <option value="0">Choisir le type</option>
                            <option value="Input">Entrée / Input</option>
                            <option value="Diesel">Diesel and Fuel</option>
                            <option value="Lubricant">Lubricant</option>
                            <option value="Fleet">Fleet Maintenance</option>
                            <option value="Plant">Plant Maintenance</option>
                            <option value="cleaning">Cleaning</option>
                            <option value="non-consomable">Non-consomable</option>
                            <option value="Office and kitchen equipment">Office and kitchen equipment</option>
                            <option value="Bar">Bar</option>
                            <option value="Spoilage">Spoilage</option>
                            <option value="Transfer">Transfer to</option>
                            <option value="Staff meal">Staff meal</option>
                            <option value="Back to supplier">Back to supplier</option>
                            <option value="Back charge to client">Back charge to client</option>
                            <option value="Fonction">Fonction</option>
                            <option value="PRO">PRO</option>
                        </select>
                    </div>
                    <hr>
                    <fieldset>
                        <legend></legend>
                        <div class="input-group-lg">
                            <input class="btn btn-success" type="submit" name="bt_enregistrer" value="Enregistrer">
                            <input class="btn btn-danger" type="reset" value="Reset">
                        </div>
                    </fieldset>
                </div>
            </form>
        </div>

    </div>
</div>

