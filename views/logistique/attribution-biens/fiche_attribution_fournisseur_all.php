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
        <span class="fa fa-list-alt" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-gift" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Order</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-file-text-o" style="color: darkslategray; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Commande par Fournisseur / Order per supplier</span>
    </div>
    <div class="panel panel-body">
        <div>
            <div class="row">
                <h4>Taper le mot-clé de la recherche :</h4>
                <form class="form-inline" method="POST" action="../contollers/attribution-biens/attributionBiensController.php">
                    <div class="row">
                        <div class="col-md-8 col-12 mt-1 form-group-lg">
                            <input type="text" class="form-control" name="tb_search" placeholder="Mot-clé">                            
                        </div>
                        <div class="col-md-4 col-12 mt-1">
                            <button type="submit" class="btn btn-secondary w-100" name="bt_search"><span class="glyphicon glyphicon-search" style="color: white; font-size: 20px;margin-right: 5px;"></span> Rechercher</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row">
                <h4>Liste des fournisseurs</h4>
                <div class="col-md-12 overflow-auto">
                <table id="list_attribution_biens_all" class="table table-bordered table-responsive-lg table-striped">
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
                                    <form method="POST" action="../contollers/attribution-biens/attributionBiensController.php">
                                        <input type="hidden" name="tb_idattribution" value="<?= $fournisseur['id'] ?>">
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
                            <span><?= $n ?></span>
                        </td>
                        <td style="font-size: 20px;">
                            <span>Nombre</span>
                        </td>
                        <td></td>
                        <td></td>
                    </tfoot>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>

