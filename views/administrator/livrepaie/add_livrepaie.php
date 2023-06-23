<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-bandcamp" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span><span class="h3">Livre de paie</span>
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
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == (sha1("doublons_error"))))) {
                ?>
                <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-refresh" style="font-size: 15px;margin-right: 5px;"></span><span>Doublons, Mois et année déjà enregistrés</span>
                </div>
                <?php
            }
            ?>

            <form class="form-horizontal" method="POST" action="../contollers/livrepaie/livrepaieController.php">
                <div class="form-group-lg">
                    <div class="input-group-lg">
                        <label class="control-label">Date creation :</label>
                        <input class="form-control" type="date" name="tb_datecreation">
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Mois: </label>
                        <select class="form-control select2" name="cb_mois">
                            <option value="none">Choisir le mois</option>
                            <option value="Janvier">Janvier</option>
                            <option value="Fevrier">Fevrier</option>
                            <option value="Mars">Mars</option>
                            <option value="Avril">Avril</option>
                            <option value="Mai">Mai</option>
                            <option value="Juin">Juin</option>
                            <option value="Juillet">Juillet</option>
                            <option value="Aout">Aout</option>
                            <option value="Septembre">Septembre</option>
                            <option value="Octobre">Octobre</option>
                            <option value="Novembre">Novembre</option>
                            <option value="Decembre">Decembre</option>
                        </select>
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Année :</label>
                        <input class="form-control" type="text" name="tb_annee">
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

