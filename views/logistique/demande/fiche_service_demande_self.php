<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/service/service.php';
include '../models/demande/demande.php';
include '../models/preparation/preparation.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-cube" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-plus-square-o" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Gestion des demandes</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-briefcase" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-clipboard" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Fiche des demandes pour un service/département</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Le service</legend>
                <?php
                $bdservice = new BdService();
                $services = $bdservice->getServiceById($_GET['use']);
                foreach ($services as $service) {
                    ?>
                    <table class="table table-bordered table-responsive-lg table-striped">
                        <tr>
                            <td><b>N°</b></td>
                            <td><?= $service['id'] ?></td>
                        </tr>
                        <tr>
                            <td><b>Désignation</b></td>
                            <td style="color: #0069d9;"><b><?= $service['designation'] ?></b></td>
                        </tr>
                    </table>
                    <?php
                }
                ?>
            </fieldset>
            <fieldset>
                <legend>Fiche des demandes pour un service/département</legend>
                <form method="post" action="../contollers/demande/demandeController.php">
                    <input type="hidden" name="tb_idservice" value="<?= $_GET['use'] ?>">
                    <button class="btn btn-info pull-right" style="margin-bottom: 10px;" type="submit" name="bt_encours_self_logistique_service">Voir les demandes encours</button>
                </form>
                <?php
                if ((isset($_GET['reponse'])) && ($_GET['reponse'] == sha1("get_encours_self_logistique_service"))) {
                    ?>
                    <h4>Les demandes encours</h4>
                    <?php
                    include 'liste_demande_by_idservice_encours.php';
                } else {
                    include 'liste_demande_by_idservice.php';
                }
                ?>
            </fieldset>
        </div>
    </div>
</div>

