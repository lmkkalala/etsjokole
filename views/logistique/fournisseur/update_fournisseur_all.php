<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/fournisseur/fournisseur.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-archive" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-user" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Supplier</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-edit" style="color: #0069d9; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Update</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>List</legend>
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
                        Désignation
                    </th>
                    <th>
                        Domaine
                    </th>
                    <th>
                        Adresse
                    </th>
                    <th>
                        Ville
                    </th>
                    <th>
                        Province
                    </th>
                    <th>
                        Pays
                    </th>
                    <th>
                        Tel.
                    </th>
                    <th>
                        Email
                    </th>
                    <th>
                        Opération
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdfournisseur=new BdFournisseur();
                        $fournisseurs=$bdfournisseur->getFournisseurAllDesc();
                        foreach ($fournisseurs as $fournisseur) {
                            $n++;
                            ?>
                        <form class="form-horizontal" method="POST" action="../contollers/fournisseur/fournisseurController.php">
                            <div class="form-group-lg">
                                <tr>
                                    <td><?= $fournisseur['id'] ?></td>
                                    <td><input class="form-control" type="text" name="tb_designation" value="<?= $fournisseur['designation'] ?>"></td>
                                    <td><input class="form-control" type="text" name="tb_domaine" value="<?= $fournisseur['domaine'] ?>"></td>
                                    <td><input class="form-control" type="text" name="tb_adresse" value="<?= $fournisseur['adresse'] ?>"></td>
                                    <td><input class="form-control" type="text" name="tb_ville" value="<?= $fournisseur['ville'] ?>"></td>
                                    <td><input class="form-control" type="text" name="tb_province" value="<?= $fournisseur['province'] ?>"></td>
                                    <td><input class="form-control" type="text" name="tb_pays" value="<?= $fournisseur['pays'] ?>"></td>
                                    <td><input class="form-control" type="text" name="tb_telephone" value="<?= $fournisseur['telephone'] ?>"></td>
                                    <td><input class="form-control" type="text" name="tb_email" value="<?= $fournisseur['email'] ?>"></td>
                                <input type = "hidden" name = "tb_idfournisseur" value ="<?= $fournisseur['id'] ?>">
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
                        <span>Nombre:</span><span><?= $n ?></span>
                    </td>
                    </tfoot>
                </table>
            </fieldset>
        </div>
    </div>
</div>

