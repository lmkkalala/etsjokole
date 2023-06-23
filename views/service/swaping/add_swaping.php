<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/affectation-service/affectationService.php';
include '../models/swaping/swaping.php';
include '../models/affectation-groupe/affectationGroupe.php';
include '../models/service/service.php';
include '../models/agent/agent.php';
?>
<div class="panel">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-heading">
                <span class="fa fa-credit-card" style="color: darkslategray; font-size: 30px;margin-right: 5px;"></span>
                <span class="h3" style="font-size: 50px;">Swaping</span>
                <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
                <span class="glyphicon glyphicon-asterisk" style="color: red; font-size: 30px;margin-right: 5px;"></span>
                <span class="h4">New</span>
            </div>
        </div>
    </div>

    <div>
        <div>
            <?php
            $state_color = "darkslategray";
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("succes")))) {
                ?>
                <div class="alert alert-success">
                    <span class="glyphicon glyphicon-ok" style="font-size: 15px;margin: 5px;"></span><span>Success</span>
                </div>
                <?php
                $state_color = "forestgreen";
            }
            ?>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("traitement_error")))) {
                ?>
                <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-ban-circle" style="font-size: 15px;margin: 5px;"></span><span>Erreur d'enregistrement</span>
                </div>
                <?php
                $state_color = "red";
            }
            ?>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("remplissage_error")))) {
                ?>
                <div class="alert alert-warning">
                    <span class="glyphicon glyphicon-blackboard" style="font-size: 15px;margin: 5px;"></span><span>Erreur de remplissage, Recommencer SVP</span>
                </div>
                <?php
                $state_color = "orange";
            }
            ?>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("card_error")))) {
                ?>
                <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-ban-circle" style="font-size: 15px;margin: 5px;"></span><span>Unauthorized</span>
                </div>
                <?php
                $state_color = "red";
            }
            ?>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("nombre_repas_error")))) {
                ?>
                <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-ban-circle" style="font-size: 15px;margin: 5px;"></span><span>Quantity overflow</span>
                </div>
                <?php
                $state_color = "red";
            }
            ?>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("doublon_error")))) {
                ?>
                <div class="alert alert-warning">
                    <span class="glyphicon glyphicon-ban-circle" style="font-size: 15px;margin: 5px;"></span><span>Already eat</span>
                </div>
                <?php
                $state_color = "orange";
            }
            ?>
            <form class="form-horizontal" method="POST" action="../contollers/swaping/swapingController.php">
                <div class="form-group-lg">
                    <div class="input-group-lg">
                        <input class="form-control" type="text" name="tb_codebar" autofocus style="text-align: center;">
                    </div>
                    <fieldset>
                        <legend></legend>
                        <div class="input-group-lg">
                            <input class="btn btn-success" type="submit" name="bt_enregistrer" value="Valider">
                        </div>
                    </fieldset>
                </div>

            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" style="background-color: 
        <?php
        echo $state_color;
        ?>; padding: 10px;">
            <table>
                <tr>
                    <td>
                        <?php
                        $nombre_swap = 0;

                        $bdaffectationservice = new BdAffectationService();
                        $affectationservices = $bdaffectationservice->getAffectationServiceByIdSecond($_SESSION['idaffectation']);
                        foreach ($affectationservices as $affectationservice) {
                            $id_service_encours = $affectationservice['Sid'];
                            if (1) {
                                
                            }
                        }

                        $items_date = explode(' ', (date('Y-m-d H:i')));
                        if ($items_date[1] < ('09:00:00')) {
                            $type_repas = "breakfast";
                        } else if ($items_date[1] < ('14:00:00')) {
                            $type_repas = "lunch";
                        } else {
                            $type_repas = "dinner";
                        }

                        $bdswaping = new BdSwaping();
                        $swapings = $bdswaping->getSwapingToday();
                        foreach ($swapings as $swaping) {
                            if ($type_repas == $swaping['typerepas']) {
                                $bdaffectationgroupe = new BdAffectationGroupe();
                                $affectationgroupes = $bdaffectationgroupe->getAffectationGroupeById($swaping['affectationGroupe_id']);
                                foreach ($affectationgroupes as $affectationgroupe) {
                                    $id_affectationgroupe = $affectationgroupe['id'];
                                    $id_service = $affectationgroupe['service_id'];
                                }
                                if (isset($id_service)) {
                                    if ($swaping['service_id'] == $id_service_encours) {
                                        $nombre_swap++;
                                    }
                                }
                            }
                        }
                        ?>
                        <p style="color: white; font-size: 30px; margin: 5px; font-weight: bold;">
                            <?= "Nombre swap : " . $nombre_swap." / ".$type_repas ?>
                        </p>
                        <?php
                        $bdservice = new BdService();
                        $services = $bdservice->getServiceById($id_service_encours);
                        foreach ($services as $service) {
                            $designation_service = $service['designation'];
                        }
                        ?>
                        <p style="color: white; font-size: 20px; margin-right: 5px;">
                            <?= $designation_service ?>
                        </p>
                    </td>
                    <td style="width: 25%;">
                        <?php
                        if (isset($_GET['use_agent'])) {
                            $bdagent = new BdAgent();
                            $agents = $bdagent->getAgentById($_GET['use_agent']);
                            foreach ($agents as $agent) {
                                ?>
                                <table>
                                    <tr>
                                        <td>
                                            <?php
                                            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("nombre_repas_error")))) {
                                                ?>
                                                <p style="font-weight: bold;color: white;font-size: 30px; margin: 10px;">Quantity overflow</p>
                                                <?php
                                            }
                                            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("doublon_error")))) {
                                                ?>
                                                <p style="font-weight: bold;color: white;font-size: 30px; margin: 10px;">Already eat</p>
                                                <?php
                                            }
                                            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("card_error")))) {
                                                ?>
                                                <p style="font-weight: bold;color: white;font-size: 30px; margin: 10px;">Not authorized</p>
                                                <?php
                                            }
                                            ?>
                                            <p style="margin-top: 10px;color: white;font-size: 20px; margin: 10px;"><?= $agent['nom'] . " " . $agent['postnom'] . " " . $agent['prenom'] . " " ?></p>
                                        </td>
                                        <td>
                                            <img src="../media/pictures-agent/<?= $agent['urlPhoto'] ?>" alt="Photo" height="120px" width="120px">
                                        </td>
                                    </tr>
                                </table>
                                <?php
                            }
                        }
                        ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>

</div>


