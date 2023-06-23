<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/service/service.php';
include '../models/livraison/livraison.php';
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
                <legend>Fiche des livraisons pour un service/département</legend>
                <?php
                    include 'liste_livraison_by_idservice.php';
                ?>
            </fieldset>
        </div>
    </div>
</div>

