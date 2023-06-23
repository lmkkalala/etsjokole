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
        <span class="fa fa-cubes" style="color: darkorange; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-plus-square-o" style="color: darkorange; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Ravitaillement</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-file-text-o" style="color: #0069d9; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Fiche des ravitaillements par fournisseur</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Taper le mot-clé de la recherche :</legend>
                <form class="form-inline" method="POST" action="../contollers/ravitaillement/ravitaillementController.php">
                    <div class="form-group-lg">
                        <button type="submit" class="btn btn-success" name="bt_search"><span class="glyphicon glyphicon-search" style="color: white; font-size: 30px;margin-right: 5px;"></span></button>
                        <input type="text" class="form-control" name="tb_search" placeholder="Mot-clé">                            
                    </div>
                </form>
            </fieldset>
            <fieldset>
                <legend>Liste des fournisseurs</legend>
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
                        Opération
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdfournisseur=new BdFournisseur();
                        if ((isset($_GET['use']))) {
                            $fournisseurs=$bdfournisseur->getFournisseurByName($_GET['use']);
                        } else {
                            $fournisseurs=$bdfournisseur->getFournisseurAllDesc();
                        }
                        foreach ($fournisseurs as $fournisseur) {
                            $n++;
                            ?>
                            <tr>
                                <td><?= $fournisseur['id'] ?></td>
                                <td><?= $fournisseur['designation'] ?></td>
                                <td><?= $fournisseur['domaine'] ?></td>
                                <td>
                                    <form method="POST" action="../contollers/ravitaillement/ravitaillementController.php">
                                        <input type="hidden" name="tb_idravitaillement" value="<?= $fournisseur['id'] ?>">
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

