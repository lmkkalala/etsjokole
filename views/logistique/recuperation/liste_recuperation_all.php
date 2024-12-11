<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/livraison/livraison.php';
include '../models/demande/demande.php';
include '../models/recuperation/recuperation.php';
$dateStart = '';
$dateEnd = '';
$produit = '';
include '../models/crud/db.php';
?>
<div class="col-md-12">
    <div class="panel panel-heading">
        <span class="fa fa-cubes" style="color: #0069d9; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-recycle" style="color: #0069d9; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Récuperation</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-list-ol" style="color: darkgray; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">listes de toutes les récuperations</span>
    </div>
    <?php
        $date = date('Y-m',time());
        $n = 0;
        $bdlivraison = new BdRecuperation();
        $produit = (isset($_POST['produit']) and !empty($_POST['produit']))? htmlspecialchars($_POST['produit']) : '';
        if ($_SESSION['type'] == 'logistique') {
            $condition = (empty($_POST['produit'])) ? '' : ' AND b.designation LIKE "%'.htmlspecialchars($_POST['produit']).'%"';
        }else{
            $condition = (empty($_POST['produit'])) ? ' AND agent_id = "'.$_SESSION['agentID'].'"' : ' AND b.designation LIKE "%'.htmlspecialchars($_POST['produit']).'%" AND agent_id = "'.$_SESSION['agentID'].'"';
        }
        
        if (isset($_POST['dateStart']) and isset($_POST['dateEnd']) and isset($_POST['produit']) ) {
            
            if(!empty($_POST['dateStart']) and !empty($_POST['dateEnd'])){
                $dateStart = htmlspecialchars($_POST['dateStart']);
                $dateEnd = htmlspecialchars($_POST['dateEnd']);
                
                $livraisons = $bdlivraison->getRecuperationAllData($dateStart,$dateEnd,$condition);
            }else if(!empty($_POST['dateStart'])){
                $dateStart = htmlspecialchars($_POST['dateStart']);
                $livraisons = $bdlivraison->getRecuperationAllData($dateStart,'',$condition);
            }else{
                $livraisons = $bdlivraison->getRecuperationAllData('','',$condition);
            }
        }else{
            $livraisons = $bdlivraison->getRecuperationAllData('','',$condition);
        }
    ?>
    <form action="../views/home.php?link=cc29d915e0aff03b7668cb8dd7aa96ff33efcb0f&link_up=4802ab2ed36a6a26e9ece959716b6af785eeb218" method="post">
        <div class="row mt-3 mb-3">
            <div class="col-md-3">
                <input class="form-control" type="text" name="produit" id="" value="<?=$produit?>">
            </div>
            <div class="col-md-3">
                <input class="form-control" type="date" name="dateStart" id="" value="<?=$dateStart?>">
            </div>
            <div class="col-md-3">
                <input class="form-control" type="date" name="dateEnd" id="" value="<?=$dateEnd?>">
            </div>
            <div class="col-md-3">
                <input class="btn btn-info" type="submit" name="rechercher" id="rechercher" value="Rechercher">
            </div>
        </div>
    </form>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Les Recuperations</legend>
                <table id="listdatabyid" class="table table-bordered table-responsive-lg">
                    <thead>
                        <tr>
                            <th>
                                N°
                            </th>
                            <th>
                                Date
                            </th>
                            <th>
                                Depot
                            </th>
                            <th>
                                Article
                            </th>
                            <th>
                                Livraison
                            </th>
                            <th>
                                Recuperation
                            </th>
                            <th>
                                Effectuer Par
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                        $db = new DB();

                        foreach ($livraisons as $livraison) {
                            $distribution = $db->getWhere('distrubution','id',$livraison['command_id'],'id');
                            //if ($livraison['lEtat'] == 1) {
                                $n++;
                                ?>
                                <tr>
                                    <td><?= $n ?></td>
                                    <td><?= $livraison['rDATE'] ?></td>
                                    <td><?= $livraison['snom'] . " " . $livraison['spostnom'] . " " . $livraison['sprenom'] ?></td>
                                    <td><?= $livraison['designation'] ?></td>
                                    <td><?= $distribution[0]['quantite'] ?></td>
                                    <!-- <td><?= 'Sur '.$livraison['quantite_old'].' on Recuperer '.$livraison['quantite_recuperer'] ?></td> -->
                                    <td><?= $livraison['quantite_recuperer'] ?></td>
                                    <td><?= $livraison['pnom'] . " " . $livraison['ppostnom'] . " " . $livraison['pprenom'] ?></td>
                                </tr>
                                <?php
                            //}
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th style="font-size: 20px;">
                                <span><?= $n ?></span>
                            </th>
                            <th style="font-size: 20px;">
                                <span>Nombre</span>
                            </th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </fieldset>
        </div>
    </div>
</div>

