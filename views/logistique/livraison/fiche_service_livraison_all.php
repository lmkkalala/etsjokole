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
        <span class="fa fa-cubes" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-share-alt" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Livraison</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-briefcase" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-file-text-o" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Fiche de livraisons pour un service/département</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <fieldset>
                    <legend>Liste des services/départements</legend>
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
                            Opération
                        </th>
                        </thead>
                        <tbody>
                            <?php
                            $n = 0;
                            $bdservice = new BdService();
                            $services = $bdservice->getServiceAllDesc();
                            foreach ($services as $service) {
                                if ($service['active']) {


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
                                <input type = "hidden" name = "tb_idservice" value ="<?= $service['id'] ?>">

                                <td>
                                    <form method="post" action="../contollers/livraison/livraisonController.php">
                                        <input type = "hidden" name = "tb_idservice" value ="<?= $service['id'] ?>">
                                        <button type="submit" class="btn btn-primary" name="bt_view_for_service"><span class="fa fa-angle-double-right" style="color: white; font-size: 20px;margin-right: 5px;"></span></button>
                                    </form>
                                </td>
                                </tr>
                                <?php
                            }
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

