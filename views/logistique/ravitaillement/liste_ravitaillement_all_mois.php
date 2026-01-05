<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/ravitaillement/ravitaillement.php';

include '../models/attribution-biens/attributionBiens.php';
include '../models/crud/db.php';
$dateStart = '';
$dateEnd = '';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-list-alt" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-gift" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Reception</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-list-ol" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">List</span>
    </div>
    <?php
        $date = date('Y-m',time());
        $n = 0;

        $bdravitaillement = new BdRavitaillement();
        $produit = '';
        if (!empty($_POST['dateStart']) && !empty($_POST['dateEnd'])) {
            $dateStart = htmlspecialchars($_POST['dateStart']);
            $dateEnd = htmlspecialchars($_POST['dateEnd']);
            if (isset(($_POST['produit'])) && !empty($_POST['produit'])) {
                $produit=htmlspecialchars($_POST['produit']);
                die($produit);
                $ravitaillements = $bdravitaillement->getRavitaillementAllData(' INNER JOIN attribution AB ON(S.attribution_id=AB.id) INNER JOIN biens B ON(B.id=AB.biens_id) INNER JOIN fournisseur F ON(F.id=AB.fournisseur_id) WHERE B.designation LIKE "%'.$produit.'%" AND S.date >= "'.$dateStart.'" AND S.date <= "'.$dateEnd.'"');
            }else{
               
                $ravitaillements = $bdravitaillement->getRavitaillementAllData(' INNER JOIN attribution AB ON(S.attribution_id=AB.id) INNER JOIN biens B ON(B.id=AB.biens_id) INNER JOIN fournisseur F ON(F.id=AB.fournisseur_id) WHERE S.date >= "'.$dateStart.'" AND S.date <= "'.$dateEnd.'" ');
            }
        } else {
            $ravitaillements = $bdravitaillement->getRavitaillementAllData(' INNER JOIN attribution AB ON(S.attribution_id=AB.id) INNER JOIN biens B ON(B.id=AB.biens_id) INNER JOIN fournisseur F ON(F.id=AB.fournisseur_id) WHERE S.date LIKE "%'.date('Y').'%"');
        }

    
    ?>
    <form action="../views/home.php?link=592b5a6099d8b3c20bb91ff890d6cee19de202ba&link_up=a68d4eda4922619142fdfa364458d99e132ad279" method="post">
        <div class="row mt-3">
            <div class="col-md-3 col-12 mt-1">
                <input class="form-control w-100" type="text" name="produit" id="" value="<?=$produit?>" placeholder="...">
            </div>
            <div class="col-md-3 col-12 mt-1">
                <input class="form-control w-100" type="date" name="dateStart" id="" value="<?=$dateStart?>">
            </div>
            <div class="col-md-3 col-12 mt-1">
                <input class="form-control w-100" type="date" name="dateEnd" id="" value="<?=$dateEnd?>">
            </div>
            <div class="col-md-3 col-12 mt-1">
                <input class="btn btn-secondary w-100" type="submit" name="rechercher" id="rechercher" value="Rechercher">
            </div>
        </div>
    </form>
    <div class="panel panel-body">
        <div class="row">
            <div class="col-md-12 overflow-auto">
                <h4>Orders</h4>
                <table id="list_attribution_biens_all" class="table table-bordered table-responsive-lg table-condensed">
                    <thead>
                    <th>
                        N° Reception
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        Biens/produits
                    </th>
                    <th>
                        Fournisseur
                    </th>
                    <th>
                        Quantité
                    </th>
                    <th>
                        PAU
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        
                        foreach ($ravitaillements as $ravitaillement) {
                            // var_dump($ravitaillements);
                            $n++;
                        ?>
                           <tr>
                                <td><?= $ravitaillement['Sid'] ?></td>
                                <td><?= $ravitaillement['Sdate'] ?></td>
                                <td><?= $ravitaillement['Bdesignation'] ?></td>
                                <td><?= $ravitaillement['Fdesignation'] ?></td>
                                <td><?= 'Command: '.$ravitaillement['Qmin']." | Recu: ".$ravitaillement['Squatite'] ?></td>
                                <td><?='Command: '.$ravitaillement['ABprix'].' | Recu: '.$ravitaillement['Sprix'] ?></td>
                            </tr> 
                        <?php 
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td style="font-size: 20px;">
                                <span><?= $n ?></span>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>