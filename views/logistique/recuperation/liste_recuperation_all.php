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
?>
<div class="panel">
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
                    if (isset($_POST['dateStart']) and isset($_POST['dateEnd'])) {
                        if(!empty($_POST['dateStart']) and !empty($_POST['dateEnd'])){
                            $dateStart = htmlspecialchars($_POST['dateStart']);
                            $dateEnd = htmlspecialchars($_POST['dateEnd']);
                            $livraisons = $bdlivraison->getRecuperationAllData($dateStart,$dateEnd);
                        }else if(!empty($_POST['dateStart'])){
                            $dateStart = htmlspecialchars($_POST['dateStart']);
                            $livraisons = $bdlivraison->getRecuperationAllData($dateStart);
                        }else{
                            $livraisons = $bdlivraison->getRecuperationAllData();
                        }
                    }else{
                        $livraisons = $bdlivraison->getRecuperationAllData();
                    }
                ?>
                <form action="../views/home.php?link=cc29d915e0aff03b7668cb8dd7aa96ff33efcb0f&link_up=4802ab2ed36a6a26e9ece959716b6af785eeb218" method="post">
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
                <legend>Les Recuperations</legend>
                <table class="table table-bordered table-responsive-lg">
                    <thead>
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
                        Quantité
                    </th>
                    <th>
                        Effectuer Par
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        
                        
                        foreach ($livraisons as $livraison) {
                            //if ($livraison['lEtat'] == 1) {
                                $n++;
                                ?>
                                <tr>
                                    <td><?= $n ?></td>
                                    <td><?= $livraison['date'] ?></td>
                                    <td><?= $livraison['snom'] . " " . $livraison['spostnom'] . " " . $livraison['sprenom'] ?></td>
                                    <td><?= $livraison['designation'] ?></td>
                                    <td><?= 'Sur '.$livraison['quantite_old'].' on Recuperer '.$livraison['quantite_recuperer'] ?></td>
                                    <td><?= $livraison['pnom'] . " " . $livraison['ppostnom'] . " " . $livraison['pprenom'] ?></td>
                                </tr>
                                <?php
                            //}
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

