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
        <span class="fa fa-bandcamp" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span><span class="h3">Restaurant</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>

        <span class="glyphicon glyphicon-pencil" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Update</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Restaurants</legend>
                <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("succes")))) {
                    ?>
                    <div class="alert alert-success">
                        <span class="glyphicon glyphicon-ok" style="font-size: 15px;margin-right: 5px;"></span><span>Modification effectué avec succès</span>
                    </div>
                    <?php
                }
                ?>
                <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("traitement_error")))) {
                    ?>
                    <div class="alert alert-danger">
                        <span class="glyphicon glyphicon-ban-circle" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur de traitment</span>
                    </div>
                    <?php
                }
                ?>
                <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("remplissage_error")))) {
                    ?>
                    <div class="alert alert-warning">
                        <span class="glyphicon glyphicon-blackboard" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur de remplissage, Recommencer SVP</span>
                    </div>
                    <?php
                }
                ?>
                <table class="table table-bordered table-responsive-lg">
                    <thead>
                    <th>
                        N°
                    </th>
                    <th>
                        Name
                    </th>
                    <th>
                        Price breakfast
                    </th>
                    <th>
                        Price lunch
                    </th>
                    <th>
                        Price dinner
                    </th>
                    <th>
                        Entreprise (Institution)
                    </th>
                    <th>
                        State
                    </th>
                    <th>
                        Action
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
                        <form class="form-horizontal" method="POST" action="../contollers/service/serviceController.php">
                            <div class="form-group-lg">
                                <tr>
                                    <td><?= $service['id'] ?></td>
                                    <td><input class="form-control" type="text" name="tb_designation" value="<?= $service['designation'] ?>"></td>
                                    <td><input class="form-control" type="text" name="tb_prixbreakfast" value="<?= $service['prixBreakfast'] ?>"></td>
                                    <td><input class="form-control" type="text" name="tb_prixlunch" value="<?= $service['prixLunch'] ?>"></td>
                                    <td><input class="form-control" type="text" name="tb_prixdinner" value="<?= $service['prixDinner'] ?>"></td>
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
                                <td><button type="submit" class="btn btn-primary" name="bt_modifier"><span class="glyphicon glyphicon-pencil" style="color: white; font-size: 20px;margin-right: 5px;"></span></button></td>                                    
                                </tr>
                            </div>
                        </form>
                        <?php
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <td style="font-size: 20px;">
                        <span>Number:</span><span><?= $n ?></span>
                    </td>
                    </tfoot>
                </table>
            </fieldset>
        </div>
    </div>
</div>

