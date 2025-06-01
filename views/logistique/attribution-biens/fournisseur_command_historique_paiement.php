<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/attribution-biens/attributionBiens.php';
include '../models/fournisseur/fournisseur.php';
include '../models/crud/db.php';
$fournisseur_id = '';
$and = '';
$Total_command = 0;
$Total_paiement = 0;

if ((isset($_GET['use_date1'])) && (isset($_GET['use_date2']))) {
    $and = ' AND attribution.date >= "'.htmlspecialchars($_GET['use_date1']).'" AND attribution.date <= "'.htmlspecialchars($_GET['use_date2']).'" ';
    $date_debut = $_GET['use_date1'];
    $date_fin = $_GET['use_date2'];
}else{
    $date_debut = '';
    $date_fin = '';
    $and = ' AND attribution.date LIKE "'.date('Y').'" ';
}

if (isset($_GET['use_numeroOrder'])) {
    $use_numeroOrder = $_GET['use_numeroOrder'];
}

?> 
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-list-alt" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-gift" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Order</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-book" style="color: darkslategray; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Fournisseur Paiement</span>
    </div>
    <div class="panel panel-body">
        <div class="container">
            <fieldset>
                <legend>Le fournisseur</legend>
                <?php
                    $bdfournisseur = new BdFournisseur();
                    $fournisseurs = $bdfournisseur->getFournisseurById($_GET['use']);
                    foreach ($fournisseurs as $fournisseur) {
                        $fournisseur_id = $fournisseur['id'];
                ?>
                    <table class="table table-bordered table-responsive-lg table-striped">
                        <!-- <tr>
                            <td><b>N°</b></td>
                            <td><?= $fournisseur['id'] ?></td>
                        </tr> -->
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
                <legend>Choose interval :</legend>
                <form class="form-inline" method="POST" action="../contollers/attribution-biens/attributionBiensController.php">
                    <div class="row form-group-lg">
                        <div class="col-md-5 col-12 mt-2">
                            <input type="date" class="form-control" name="tb_date1" placeholder="First date" value="<?=$date_debut?>">
                        </div>
                        <div class="col-md-5 col-12 mt-2">
                            <input type="date" class="form-control" name="tb_date2" placeholder="Second date" value="<?=$date_fin?>">
                        </div>
                        <div class="col-md-2 col-12 mt-2">
                            <input type="hidden" name="tb_idfournisseur" value="<?= $_GET['use'] ?>">
                            <button type="submit" class="btn btn-secondary w-100" name="bt_search_attributionbiens_paie_by_date"><span class="glyphicon glyphicon-search" style="color: white; font-size: 15px;margin-right: 5px;"></span> Rechercher</button>
                        </div>
                        
                    </div>
                </form>
            </fieldset>
            <div class="row">
                <div class="col-md-12 overflow-auto mt-3">
                    <table id="listdatabyid" class="table table-bordered table-responsive-lg table-condensed">
                        <thead >
                            <tr>
                                <th>N°</th>
                                <th>Date Commande</th>
                                <th>ARTICLE</th>
                                <th>QUANTITE</th>
                                <th>PRIX U</th>
                                <th>PRIX T</th>
                                <th>PAIEMENT</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $number = 0;
                            $db = new DB();
                            $attributions = $db->getWhereMultipleMore(" *, attribution.id as aID, attribution.date as aDate, attribution.prixunitaire as aPU FROM attribution INNER JOIN biens ON attribution.biens_id = biens.id"," fournisseur_id = ".$fournisseur_id." ".$and." ");
                            foreach ($attributions as $key => $attribution) {
                                $number ++;
                                $prixTotal = $attribution['aPU'] * $attribution['quantite_minimale'];
                                $Total_command = $Total_command + $prixTotal;
                                $paiements = $db->getWhereMultipleMore(" * FROM payement_fournisseur "," attribution_id = ".$attribution['aID']."");
                            ?>
                            <tr>
                                <td><?=$number?></td>
                                <td><?=$attribution['aDate']?></td>
                                <td><?=$attribution['designation']?></td>
                                <td><?=$attribution['quantite_minimale']?></td>
                                <td><?=$attribution['aPU']?></td>
                                <td><?=$prixTotal?> $</td>
                                <td>
                                    <div <?=(!empty(count($paiements))) ? 'style="height: 200px;overflow:auto;"':''?>>
                                        <?php
                                            if (!empty(count($paiements))) {
                                        ?>
                                            <p>
                                                <?php
                                                    foreach ($paiements as $key => $paiement) {
                                                        $Total_paiement = $Total_paiement + $paiement['montant'];
                                                ?>
                                                    <span><?='Date: '.$paiement['date'].', <br> Porteur: '.$paiement['transporteur'].', <br> Receveur: '.$paiement['receveur'].', <br> Monatant: '.$paiement['montant'].'$'?></span><hr>
                                                <?php
                                                    }
                                                ?>
                                            </p>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><?=$Total_command?> $</td>
                                <td><?=$Total_paiement?> $</td>
                            </tr>
                            <tr>
                            <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><?=($Total_command - $Total_paiement) > 0 ? "Reste à payer: ": "Avance : "?></td>
                                <td><?=$Total_command - $Total_paiement?> $</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</div>

