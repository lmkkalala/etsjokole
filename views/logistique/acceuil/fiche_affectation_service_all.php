<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/service/service.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="glyphicon glyphicon-share" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span><span class="h3">Affectation des agents</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-book" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Fiche d'affectation par service</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <fieldset>
                    <legend>Liste des services</legend>
                    <table class="table table-bordered table-responsive-lg">
                        <thead>
                        <th>
                            N°
                        </th>
                        <th>
                            Désignation
                        </th>
                        <th>
                            Entreprise (Institution)
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
                            $bdservice = new BdService();
                            $services = $bdservice->getServiceAllDesc();
                            foreach ($services as $service) {
                                $n++;
                                ?>
                                <tr>
                                    <td><?= $service['id'] ?></td>
                                    <td><?= $service['designation'] ?></td>
                                    <td>
                                        <?php
                                        $bdentreprise = new BdEntreprise();
                                        $entreprises = $bdentreprise->getEntrepriseById($service['entreprise_id']);
                                        foreach ($entreprises as $entreprise) {
                                            echo $entreprise['designation'];
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($service['active'] == 1) {
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

                            <input type = "hidden" name = "tb_idservice" value ="<?= $service['id'] ?>">

                            <td>
                                <form method="post" action="../contollers/affectation-service/affectationServiceController.php">
                                    <input type = "hidden" name = "tb_idservice" value ="<?= $service['id'] ?>">
                                    <button type="submit" class="btn btn-primary" name="bt_view"><span class="fa fa-angle-double-right" style="color: white; font-size: 20px;margin-right: 5px;"></span></button>
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

