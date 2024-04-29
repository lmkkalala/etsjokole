<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/attribution-biens/attributionBiens.php';
include '../models/crud/db.php';
$dateStart = '';
$dateEnd = '';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-list-alt" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-gift" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Order</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-list-ol" style="color: tomato; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-time" style="color: tomato; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Waiting order</span>
    </div>
    <?php
                    $date = date('Y-m',time());
                    $n = 0;
                    $bdattributionbiens = new BdAttributionBiens();
                    $attributions = $bdattributionbiens->getAttributionBiensAllDescEncours();
                    if (isset($_POST['dateStart']) and isset($_POST['dateEnd'])) {
                        if(!empty($_POST['dateStart']) and !empty($_POST['dateEnd'])){
                            $dateStart = htmlspecialchars($_POST['dateStart']);
                            $dateEnd = htmlspecialchars($_POST['dateEnd']);
                            $attributions = $bdattributionbiens->getAttributionBiensAllDescEncours($dateStart,$dateEnd);
                        }else{
                            $attributions = $bdattributionbiens->getAttributionBiensAllDescEncours($date);
                        }
                    }else{
                        $attributions = $bdattributionbiens->getAttributionBiensAllDescEncours();
                    }

                    $db = new DB();

                    if (isset($_POST['attr_id'])) {
                        $etat = htmlspecialchars($_POST['etat']);
                        $attr_id = htmlspecialchars($_POST['attr_id']);
                        $update = $db->update('attribution','etat = ?','id = ?',[''.$etat.'',''.$attr_id.'']);
                    }
                ?>
                <form action="../views/home.php?link=bc6749372a792df7e3460135262bf41aad976c1f&link_up=1f920fef6c620c4660a748aae5dd44da9e74ba9b" method="post">
                    <div class="row">
                        <div class="col-4">
                            <input class="form-control" type="date" name="dateStart" id="" value="<?=$dateStart?>">
                        </div>
                        <div class="col-4">
                            <input class="form-control" type="date" name="dateEnd" id="" value="<?=$dateEnd?>">
                        </div>
                        <div class="col-4">
                            <input class="btn btn-info" type="submit" name="rechercher" id="rechercher" value="Rechercher">
                        </div>
                    </div>
                </form>
    <div class="panel panel-body">
        <div class="mt-3">
            <fieldset>
                <legend>Biens</legend>
                <table id="list_attribution_biens_encours_all" class="table table-bordered table-responsive-lg table-condensed">
                    <thead>
                    <th>
                        N°
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        Etat
                    </th>
                    <th>
                        Biens/produits
                    </th>
                    <th>
                        Gestion
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
                    <th>
                        Délai de livraison
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $qte = 0;
                        foreach ($attributions as $attribution) {
                            $n++;
                            $stocks = $db->getWhereMultipleMore(" * FROM stockage "," attribution_id = ".$attribution['aId']."");
                            foreach ($stocks as $key => $stock) {
                                $qte = $qte + $stock['quantite']; 
                            }
                            ?>
                            <tr>
                                <td><?= $attribution['numeroOrder'] ?></td>
                                <td><?= $attribution['date'] ?></td>
                                <td>
                                    <b>
                                        <?php
                                        if ($attribution['etat']) {
                                            $etat = 'Finalisée';
                                            $etat_val = 0;
                                            $btnStyle = 'info';
                                        } else {
                                            $etat_val = 1;
                                            $etat = 'En cours';
                                            $btnStyle = 'danger';
                                        }
                                        ?>
                                        <form action="../views/home.php?link=bc6749372a792df7e3460135262bf41aad976c1f&link_up=1f920fef6c620c4660a748aae5dd44da9e74ba9b" method="post">
                                            <input type="hidden" name="attr_id" value="<?=$attribution['aId']?>">
                                            <input type="hidden" name="etat" value="<?=$etat_val?>">
                                            <button type="submit" name="changer_etat" class="btn btn-<?=$btnStyle?>"><?=$etat?></button>
                                        </form>
                                    </b>
                                </td>
                                <td><?= $attribution['bDesignation']." : ".$attribution['gDesignation'] ?></td>
                                <td><?= $attribution['technique_gestion'] ?></td>
                                <td><?= $attribution['fDesignation']." : ".$attribution['domaine'] ?></td>
                                <td>
                                    Commande: <?= $attribution['quantite_minimale'] ?><br>
                                    Reception: <span class="fw-bolder text-success"><?= $qte ?></span><br>
                                    Reste: <span class="fw-bolder text-info"><?= $attribution['quantite_minimale'] - $qte ?> </span>
                                </td>
                                <td><?= $attribution['aPrixUnitaire'] ?></td>
                                <td><?= $attribution['delai_livraison'] ?></td>
                            </tr>
                            <?php
                            $qte = 0 ;
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

