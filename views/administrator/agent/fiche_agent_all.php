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
        <span class="glyphicon glyphicon-book" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">View</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Enter the name :</legend>
                <form class="form-inline" method="POST" action="../contollers/agent/agentController.php">
                    <div class="form-group-lg">
                        <button type="submit" class="btn btn-success" name="bt_search"><span class="glyphicon glyphicon-search" style="color: white; font-size: 30px;margin-right: 5px;"></span></button>
                        <input type="text" class="form-control" name="tb_search" placeholder="Mot-clé">                            
                    </div>
                </form>
            </fieldset>
            <fieldset>
                <legend>List</legend>
                <table class="table table-bordered table-responsive-lg">
                    <thead>
                    <th>
                        N°
                    </th>
                    <th>
                        Nom
                    </th>
                    <th>
                        Postnom
                    </th>
                    <th>
                        Prénom
                    </th>
                    <th>
                        Sexe
                    </th>
                    <th>
                        Grade
                    </th>
                    <th>
                        Etat
                    </th>
                    <th>
                        Opération
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdagent = new BdAgent();
                        if ((isset($_GET['use']))) {
                            $agents = $bdagent->getAgentByName($_GET['use']);
                        } else {
                            $agents = $bdagent->getAgentAllDesc();
                        }
                        foreach ($agents as $agent) {
                            $n++;
                            ?>
                            <tr>
                                <td><?= $agent['id'] ?></td>
                                <td><?= $agent['nom'] ?></td>
                                <td><?= $agent['postnom'] ?></td>
                                <td><?= $agent['prenom'] ?></td>
                                <td><?= $agent['sexe'] ?></td>
                                <td><?php echo ucfirst($agent['grade']); ?></td>
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
                                <td>
                                    <form method="POST" action="../contollers/agent/agentController.php">
                                        <input type="hidden" name="tb_idagent" value="<?= $agent['id'] ?>">
                                        <button type="submit" class="btn btn-primary" name="bt_view"><span class="glyphicon glyphicon-file" style="color: white; font-size: 15px;margin-right: 5px;"></span></button>
                                    </form>
                                </td>
                            </tr>
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

