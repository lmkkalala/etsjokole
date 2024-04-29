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
        <span class="glyphicon glyphicon-list" style="color: darkslategray; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">List</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Search :</legend>
                <form class="form-inline" method="POST" action="../contollers/agent/agentController.php">
                    <div class="row form-group-lg">
                        <div class="col-md-8">
                            <select class="form-control select2" name="cb_agent">
                                <option value="0">Choose a agent</option>
                                <?php
                                $bdagent = new BdAgent();
                                $agents = $bdagent->getAgentAll();
                                foreach ($agents as $agent) {
                                    if (1) {
                                        if (1) {
                                            ?>
                                            <option value="<?= $agent['id'] ?>"><?= $agent['nom'] . " " . $agent['postnom'] . " " . $agent['prenom'] . " / " . $agent['codebar'] . " / " . $agent['grade'] ?></option>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-success" name="bt_search_for_all"><span class="glyphicon glyphicon-search"></span> Rechercher</button>
                        </div>
                    </div>
                </form>
            </fieldset>
            <fieldset>
                <legend>List</legend>
                <table class="table table-bordered table-striped table-responsive-lg">
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
                        Photo
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdagent = new BdAgent();
                        if ((isset($_GET['use_agent'])) && ($_GET['use_agent'])) {
                            $agents = $bdagent->getAgentById($_GET['use_agent']);
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
                                    <img src="../media/pictures-agent/<?= $agent['urlPhoto'] ?>" alt="No picture" height="100px" width="100px">
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

