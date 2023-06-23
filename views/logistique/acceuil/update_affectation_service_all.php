<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/affectation-service/affectationService.php';
include '../models/agent/agent.php';
include '../models/service/service.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="glyphicon glyphicon-share" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span><span class="h3">Affectation des agents</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>

        <span class="glyphicon glyphicon-pencil" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Mise à jour</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Les affectations enregistrées</legend>
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
                <table class="table table-bordered table-responsive-lg">
                    <thead>
                    <th>
                        N°
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        Agent
                    </th>
                    <th>
                        Service
                    </th>
                    <th>
                        Opération
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdaffectation = new BdAffectationService();
                        $affectations = $bdaffectation->getAffectationServiceAllDesc();
                        foreach ($affectations as $affectation) {
                            $n++;
                            ?>
                        <form class="form-horizontal" method="POST" action="../contollers/affectation-service/affectationServiceController.php">
                            <div class="form-group-lg">
                                <tr>
                                    <td><?= $affectation['Id'] ?></td>
                                    <td><input class="form-control" type="date" name="tb_date" value="<?= $affectation['date'] ?>"></td>
                                    <td>
                                        <div class="input-group-lg">
                                            <select class="form-control" name="cb_agent">
                                                <?php
                                                $bdagent = new BdAgent();
                                                $agents = $bdagent->getAgentAllDesc();
                                                foreach ($agents as $agent) {
                                                    if ($agent['active']) {
                                                        if ($agent['id'] == $affectation['Aid']) {
                                                            ?>
                                                            <option value="<?= $agent['id'] ?>" selected><?= $agent['nom'] . " " . $agent['postnom'] . " " . $agent['prenom'] . " / " . $agent['grade'] ?></option>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <option value="<?= $agent['id'] ?>"><?= $agent['nom'] . " " . $agent['postnom'] . " " . $agent['prenom'] . " / " . $agent['grade'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group-lg">
                                            <select class="form-control" name="cb_service">
                                                <?php
                                                $bdservice = new BdService();
                                                $services = $bdservice->getServiceAllDesc();
                                                foreach ($services as $service) {
                                                    if ($service['active']) {
                                                        if ($service['id'] == $affectation['Sid']) {
                                                            ?>
                                                            <option value="<?= $service['id'] ?>" selected><?= $service['designation'] ?></option>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <option value="<?= $service['id'] ?>"><?= $service['designation'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </td>
                                <input type = "hidden" name = "tb_idaffectation" value ="<?= $affectation['Id'] ?>">
                                <td><button type="submit" class="btn btn-primary" name="bt_modifier"><span class="glyphicon glyphicon-pencil" style="color: white; font-size: 20px;margin-right: 5px;"></span></button></td>                                    
                                </tr>
                            </div>
                        </form>
                        <?php
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <td style="font-size: 20px;">
                        <span>Nombre:</span><span><?= $n ?></span>
                    </td>
                    </tfoot>
                </table>
            </fieldset>
        </div>
    </div>
</div>

