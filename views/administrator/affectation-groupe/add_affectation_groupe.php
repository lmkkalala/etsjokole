<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/agent/agent.php';
include '../models/groupe-swaping/groupeSwaping.php';
include '../models/service/service.php';
include '../models/fonction/fonction.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-cube" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-plus-square-o" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Meal configuration</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-asterisk" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">New</span>
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

            <form class="form-horizontal" method="POST" action="../contollers/affectation-groupe/affectationGroupeController.php">
                <div class="form-group-lg">
                    <div class="input-group-lg">
                        <label class="control-label">Agent :</label>
                        <select class="form-control select2" name="cb_agent">
                            <option value="0">Choose agent</option>
                            <?php
                            $bdagent = new BdAgent();
                            $agents = $bdagent->getAgentAllAlphaActive();
                            foreach ($agents as $agent) {
                                if ($agent['active']) {
                                    if (1) {
                                        ?>
                                        <option value="<?= $agent['id'] ?>"><?= $agent['nom'] . " " . $agent['postnom'] . " " . $agent['prenom'] ?></option>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Category :</label>
                        <select class="form-control select2" name="cb_groupeswaping">
                            <option value="0">Choose category</option>
                            <?php
                            $bdgroupeswaping = new BdGroupeSwaping();
                            $groupeswapings = $bdgroupeswaping->getGroupeSwapingAllDesc();
                            foreach ($groupeswapings as $groupeswaping) {
                                if (1) {
                                    ?>
                                    <option value="<?= $groupeswaping['id'] ?>"><?= $groupeswaping['designation'] . " / " . $groupeswaping['nombrerepas'] . " Repas/jour" ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Department :</label>
                        <select class="form-control select2" name="cb_fonction">
                            <option value="0">Choose department</option>
                            <?php
                            $bdfonction = new BdFonction();
                            $fonctions = $bdfonction->getFonctionAllActiveDesc();
                            foreach ($fonctions as $fonction) {
                                if (1) {
                                    ?>
                                    <option value="<?= $fonction['id'] ?>"><?= $fonction['designation'] ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Restaurant :</label>
                        <select class="form-control select2" name="cb_service">
                            <option value="0">Choose a restaurant</option>
                            <?php
                            $bdservice = new BdService();
                            $services = $bdservice->getServiceAllDesc();
                            foreach ($services as $service) {
                                if (1) {
                                    ?>
                                    <option value="<?= $service['id'] ?>"><?= $service['designation'] ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <br>
                    <div class="input-group-lg">
                        <input type="checkbox" name="chk_alloweverywhere" class="checkbox-inline"><label class="control-label">Allow for all restaurant</label>
                    </div>
                    <br>
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

