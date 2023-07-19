<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/attribution-biens/attributionBiens.php';
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
        <div>
            <fieldset>
                <legend>...</legend>
                <table class="table table-bordered table-responsive-lg">
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
                        Délai de livraison
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        
                        foreach ($attributions as $attribution) {
                            $n++;
                            ?>
                            <tr>
                                <td><?= $attribution['numeroOrder'] ?></td>
                                <td><?= $attribution['date'] ?></td>
                                <td>
                                    <b>
                                        <?php
                                        if ($attribution['etat']) {
                                            echo 'Finalisée';
                                        } else {
                                            echo 'En cours';
                                        }
                                        ?>
                                    </b>
                                </td>
                                <td><?= $attribution['bDesignation']." : ".$attribution['gDesignation'] ?></td>
                                <td><?= $attribution['technique_gestion'] ?></td>
                                <td><?= $attribution['fDesignation']." : ".$attribution['domaine'] ?></td>
                                <td><?= $attribution['quantite_minimale'] ?></td>
                                <td><?= $attribution['delai_livraison'] ?></td>
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

