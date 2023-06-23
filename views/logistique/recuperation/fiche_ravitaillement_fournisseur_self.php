<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/ravitaillement/ravitaillement.php';
include '../models/attribution-biens/attributionBiens.php';
include '../models/fournisseur/fournisseur.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-cubes" style="color: darkorange; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-plus-square-o" style="color: darkorange; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Ravitaillement</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-book" style="color: #0069d9; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Fiche des ravitaillements par fournisseur</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Le fournisseur</legend>
                <?php
                $bdfournisseur = new BdFournisseur();
                $fournisseurs = $bdfournisseur->getFournisseurById($_GET['use']);
                foreach ($fournisseurs as $fournisseur) {
                    ?>
                    <table class="table table-bordered table-responsive-lg table-striped">
                        <tr>
                            <td><b>N°</b></td>
                            <td><?= $fournisseur['id'] ?></td>
                        </tr>
                        <tr>
                            <td><b>Désignation</b></td>
                            <td style="color: #0069d9;"><b><?= $fournisseur['designation'] ?></b></td>
                        </tr>
                        <tr>
                            <td><b>Domaine</b></td>
                            <td><?= $fournisseur['domaine'] ?></td>
                        </tr>
                    </table>
                    <?php
                }
                ?>
            </fieldset>
            <fieldset>
                <legend>Les ravitaillements pour  ce fournisseur</legend>
                <?php
                include 'liste_ravitaillement_by_idfournisseur.php';
                ?>
            </fieldset>
        </div>
    </div>
</div>

