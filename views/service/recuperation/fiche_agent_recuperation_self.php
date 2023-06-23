<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/biens/biens.php';
include '../models/attribution-biens/attributionBiens.php';
include '../models/demande/demande.php';
include '../models/livraison/livraison.php';
include '../models/recuperation/recuperation.php';
include '../models/distribution/distribution.php';
include '../models/agent/agent.php';
include '../models/affectation-service/affectationService.php';
include '../models/unite/unite.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-cube" style="color: #0069d9; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-recycle" style="color: #0069d9; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Gestion des récuperations</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-user" style="color: orange; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-file-text-o" style="color: orange; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Fiche de récuperations par agent</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Fiche de l'agent</legend>
                <?php
                $bdagent = new BdAgent();
                $agents = $bdagent->getAgentById($_GET['use']);
                foreach ($agents as $agent) {
                    ?>
                    <table class="table table-bordered table-responsive-lg table-striped">
                        <tr>
                            <td><b>N°</b></td>
                            <td><?= $agent['id'] ?></td>
                        </tr>
                        <tr>
                            <td><b>Nom</b></td>
                            <td><?= $agent['nom'] ?></td>
                        </tr>
                        <tr>
                            <td><b>Postnom</b></td>
                            <td><?= $agent['postnom'] ?></td>
                        </tr>
                        <tr>
                            <td><b>Prenom</b></td>
                            <td><?= $agent['prenom'] ?></td>
                        </tr>
                        <tr>
                            <td><b>Sexe</b></td>
                            <td><?= $agent['sexe'] ?></td>
                        </tr>
                        <tr>
                            <td><b>Grade</b></td>
                            <td><?= $agent['grade'] ?></td>
                        </tr>
                        <tr>
                            <td><b>Etat</b></td>
                            <td>
                                <?php
                                if ($agent['active'] == 1) {
                                    ?>
                                    <h4 style="color: forestgreen;">Actif</h4>
                                    <?php
                                } else {
                                    ?>
                                    <h4 style="color: red;">Inactif</h4>
                                    <?php
                                }
                                ?>
                            </td>
                        </tr>
                    </table>
                    <?php
                }
                ?>
            </fieldset>
            <fieldset>
                <legend>Fiche des récupérations pour l'agent</legend>
                <?php
                include 'liste_recuperation_by_idagent.php';
                ?>
            </fieldset>
        </div>
    </div>
</div>

