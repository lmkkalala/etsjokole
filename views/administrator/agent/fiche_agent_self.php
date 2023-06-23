<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/agent/agent.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="glyphicon glyphicon-user" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span><span class="h3">Agent</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-file" style="color: #0069d9; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">View</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Information sheet</legend>
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
        </div>
    </div>
</div>

