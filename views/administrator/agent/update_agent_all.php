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

        <span class="glyphicon glyphicon-pencil" style="color: darkorange; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Update</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>List</legend>
                <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == "succes"))) {
                    ?>
                    <div class="alert alert-success">
                        <span class="glyphicon glyphicon-ok" style="font-size: 15px;margin-right: 5px;"></span><span>Modification effectué avec succès</span>
                    </div>
                    <?php
                }
                ?>
                <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == "traitement_error"))) {
                    ?>
                    <div class="alert alert-danger">
                        <span class="glyphicon glyphicon-ban-circle" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur de traitment</span>
                    </div>
                    <?php
                }
                ?>
                <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == "remplissage_error"))) {
                    ?>
                    <div class="alert alert-warning">
                        <span class="glyphicon glyphicon-blackboard" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur de remplissage, Recommencer SVP</span>
                    </div>
                    <?php
                }
                ?>
                <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("format_error")))) {
                    ?>
                    <div class="alert alert-warning">
                        <span class="glyphicon glyphicon-blackboard" style="font-size: 15px;margin-right: 5px;"></span><span>Format error, Recommencer SVP</span>
                    </div>
                    <?php
                }
                ?>
                <fieldset>
                    <legend>Search :</legend>
                    <form class="form-inline" method="POST" action="../contollers/agent/agentController.php">
                        <div class="form-group-lg">
                            <select class="form-control select2" name="cb_agent">
                                <option value="0">Choisisser un agent</option>
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
                            <button type="submit" class="btn btn-success mt-2" name="bt_search_for_update"><span class="glyphicon glyphicon-search" style="color: white; font-size: 30px;margin-right: 5px;"></span> Rechercher</button>
                        </div>
                    </form>
                </fieldset>
                <fieldset>
                    <legend>

                    </legend>
                </fieldset>
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
                        Photo
                    </th>
                    <th>
                        Sexe
                    </th>
                    <th>
                        Grade
                    </th>
                    <th>
                        Opération
                    </th>
                    <th>
                        Modifier
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdagent = new BdAgent();
                        if ((isset($_GET['use_agent'])) && ($_GET['use_agent'] != 0)) {
                            $agents = $bdagent->getAgentById($_GET['use_agent']);
                        } else {
                            $agents = $bdagent->getAgentAllDesc();
                        }

                        foreach ($agents as $agent) {
                            $n++;
                            ?>
                        <form class="form-horizontal" method="POST" action="../contollers/agent/agentController.php" enctype="multipart/form-data">
                            <div class="form-group-lg">
                                <tr>
                                    <td><?= $agent['id'] ?></td>
                                    <td><input class="form-control" type="text" name="tb_nom" value="<?= $agent['nom'] ?>"></td>
                                    <td><input class="form-control" type="text" name="tb_postnom" value="<?= $agent['postnom'] ?>"></td>
                                    <td><input class="form-control" type="text" name="tb_prenom" value="<?= $agent['prenom'] ?>"></td>
                                    <td><input class="form-control" type="file" name="tb_file"></td>
                                    <td>
                                        <div class="input-group">
                                            <?php
                                            if ($agent['sexe'] == "h") {
                                                ?>
                                                <input class = "radio" type = "radio" name = "rb_sexe" value = "h" checked>H<br>
                                                <input class = "radio" type = "radio" name = "rb_sexe" value = "f">F
                                                <?php
                                            }
                                            if ($agent['sexe'] == "f") {
                                                ?>
                                                <input class = "radio-inline" type = "radio" name = "rb_sexe" value = "h">H<br>
                                                <input class = "radio-inline" type = "radio" name = "rb_sexe" value = "f" checked>F
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </td>
                                    <td><input class="form-control" type="text" name="tb_grade" value="<?= $agent['grade'] ?>"></td>
                                    <td><input class="form-control" type="text" name="tb_codebar" value="<?= $agent['codebar'] ?>"></td>
                                    <td>
                                        <input type = "hidden" name = "tb_idagent" value ="<?= $agent['id'] ?>">
                                        <button type="submit" class="btn btn-primary" name="bt_modifier"><span class="glyphicon glyphicon-pencil" style="color: white; font-size: 20px;margin-right: 5px;"></span></button>
                                    </td>                                    
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

