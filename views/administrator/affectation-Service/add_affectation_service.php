<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/agent/agent.php';
include '../models/service/service.php';
include '../models/fonction/fonction.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="glyphicon glyphicon-share" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span><span class="h3">Affectation des agents</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-asterisk" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Nouveau affectation</span>
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

            <form class="form-horizontal" method="POST" action="../contollers/affectation-service/affectationServiceController.php">
                <div class="form-group-lg">
                    <div class="input-group-lg">
                        <label class="control-label">Date d'affectation :</label>
                        <input type="date" class="form-control" name="tb_date">
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Agent :</label>
                        <select class="form-control select2" name="cb_agent">
                            <option value="0">Choisir un agent</option>
                            <?php
                            $bdagent = new BdAgent();
                            $agents = $bdagent->getAgentAllDesc();
                            foreach ($agents as $agent) {
                                if ($agent['active']) {
                                    ?>
                                    <option value="<?= $agent['id'] ?>"><?= $agent['nom'] . " " . $agent['postnom'] . " " . $agent['prenom'] . " / " . $agent['grade'] ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Service :</label>
                        <select class="form-control select2" name="cb_service">
                            <option value="0">Choisir un service</option>
                            <?php
                            $bdservice = new BdService();
                            $services = $bdservice->getServiceAllDesc();
                            foreach ($services as $service) {
                                if ($service['active']) {
                                    ?>
                                    <option value="<?= $service['id'] ?>"><?= $service['designation'] ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Fonction :</label>
                        <select class="form-control select2" name="cb_fonction">
                            <option value="0">Choisir une fonction</option>
                            <?php
                            $bdfonction=new BdFonction();
                            $fonctions = $bdfonction->getFonctionAllDesc();
                            foreach ($fonctions as $fonction) {
                                if ($fonction['active']) {
                                    ?>
                                    <option value="<?= $fonction['id'] ?>"><?= $fonction['designation'] ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
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

