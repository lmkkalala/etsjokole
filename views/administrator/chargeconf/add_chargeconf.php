<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/employe/employe.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-bandcamp" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span><span class="h3">Charge de l'employé</span>
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
                    <span class="glyphicon glyphicon-refresh" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur de doublons, Recommencer SVP</span>
                </div>
                <?php
            }
            ?>

            <form class="form-horizontal" method="POST" action="../contollers/chargeconf/chargeconfController.php">
                <div class="form-group-lg">
                    <div class="input-group-lg">
                        <label class="control-label">date de la configuration :</label>
                        <input class="form-control" type="date" name="tb_dateconf">
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Etat civil :</label>
                        <select class="form-control select2" name="cb_etatcivil">
                            <option value="none" selected>Choisir l'etat civil</option>
                            <option value="celibataire">Celibataire</option>
                            <option value="marie">Marié</option>
                            <option value="divorce">Divorcé</option>                            
                            <option value="veuf">Veuf / Veuve</option>
                        </select>
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Nombre enfant :</label>
                        <input class="form-control" type="number" name="tb_nombreenfant">
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Nombre personne en charge :</label>
                        <input class="form-control" type="number" name="tb_nombrefemme">
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Employé concernée :</label>
                        <select class="form-control select2" name="cb_employe">
                            <option value="0">Choisir l'employé concernée</option>
                            <?php
                            $bdemploye = new BdEmploye();
                            $employes = $bdemploye->getEmployeAllDesc();
                            foreach ($employes as $employe) {
                                if ($employe['active']) {
                                    if (1) {
                                        ?>
                                        <option value="<?= $employe['eId'] ?>"><?= "Matricule: ".$employe['matricule']." / ".$employe['nom']." ".$employe['postnom']." ".$employe['prenom']." / Sexe: ".$employe['sexe'] ?></option>
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

