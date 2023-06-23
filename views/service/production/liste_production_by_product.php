<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/production/production.php';
include '../models/nourriture/nourriture.php';
include '../models/lineSale/LineSale.php';

?>
<div class="panel" style="padding:10px;">
    <div class="panel panel-heading">
        <span class="glyphicon glyphicon-share" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span><span class="h3">Production</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-open-file" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Production par produit</span>
    </div>
    <hr>
    <?php
        $bdNourriture=new BdNourriture();
        $nourritures=$bdNourriture->getNourritureById($_GET['use']);
        $designationNourriture=$nourritures[0]['designation'];
    ?>
    <table class="table table-bordered table-striped">
            <tr>
                <td>Produit : </td>
                <td style="font-weight: 700;"><?= $designationNourriture ?></td>
            </tr>
    </table>

    <hr>
        <fieldset>
            <legend>Search by dates :</legend>
            <form class="form-inline" method="POST" action="../contollers/production/productionController.php">
                <table>
                    <tr>
                        <td>
                            <div class="form-group-lg">
                                <label for="">Date1</label>
                                <input type="date" class="form-control" name="tb_date1">

                            </div>
                        </td>
                        <td style="padding-left: 8px;">
                            <div class="form-group-lg">
                                <label for=""> Date2</label>
                                <input type="date" class="form-control" name="tb_date2">
                                <input type="hidden" class="form-control" name="tb_nourritureId" value="<?= $_GET['use'] ?>">
                                <button type="submit" class="btn btn-success" name="bt_select_dates_by_product"><span class="glyphicon glyphicon-search" style="color: white; font-size: 30px;margin-right: 5px;"></span></button>

                            </div>
                        </td>
                    </tr>
                </table>
                
                
            </form>
            <?php
                if (isset($_GET['date1'])) {
                    ?>
                        <hr>
                        <p style="margin-left: 15px; font-weight: 700; color: dodgerblue; font-size: 18px;"><?= "Date1: ".$_GET['date1']." / Date2: ".$_GET['date2'] ?></p>
                    <?php
                }
            ?>
            
        </fieldset>
    <hr>
    
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Liste</legend>
                <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("succes") ))) {
                    ?>
                    <div class="alert alert-success">
                        <span class="glyphicon glyphicon-ok" style="font-size: 15px;margin-right: 5px;"></span><span>Modification effectuée avec succès</span>
                    </div>
                    <?php
                }
                ?>
                <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("traitement_error") ))) {
                    ?>
                    <div class="alert alert-danger">
                        <span class="glyphicon glyphicon-ban-circle" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur de modification</span>
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
                
                <table class="table table-bordered table-striped table-responsive-lg">
                    <thead>
                    <th>
                        N°
                    </th>
                    <th>
                        Date Time
                    </th>
                    <th>
                        Produit
                    </th>
                    <th>
                        Production
                    </th>
                    <th>
                        Quantite
                    </th><th>
                        Reste
                    </th>
                    <th>
                        Etat
                    </th>
                    
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdproduction = new BdProduction();
                        
                            $productions = $bdproduction->getProductionByNourritureIdByServiceId($_GET['use'],$_SESSION['idservice']);
                        
                            $cumulQuantiteResteTot=0;
                        foreach ($productions as $production) {
                            $reste=0;
                            $dateProduction=explode(' ',$production['dateHeurePD'])[0];
                            // echo $dateProduction;
                            if (!isset($_GET['date1']) || ($_GET['date1']<=$dateProduction && $_GET['date2']>=$dateProduction)) {   
                            
                            $n++;
                            ?>
                            <tr>
                                <td><?= $production['id'] ?></td>
                                <td><?= $production['dateHeurePD'] ?></td>
                                <td><?= $production['designation'] ?></td>
                                <td><?= $production['dateHeurePD'] ?></td>
                                <td><?= $production['quantite'] ?></td>
                                <?php
                                    $cumulQuantiteLS=0;
                                    $bdLineSale=new BdLineSale();
                                    $lineSales=$bdLineSale->getlineSaleByProductionId($production['id']);
                                    foreach ($lineSales as $lineSale) {
                                        $cumulQuantiteLS=$cumulQuantiteLS+$lineSale['quantite'];
                                    }
                                    $reste=($production['quantite']-$cumulQuantiteLS);
                                    $cumulQuantiteResteTot=$cumulQuantiteResteTot+$reste;
                                ?>
                                <td style="font-weight: 700; color: dodgerblue;"><?= ($reste) ?></td>
                                <td>
                                    <?php
                                    if ($production['active'] == 1) {
                                        ?>
                                        <h4 style="color: forestgreen;">Actif</h4>
                                        <?php
                                    } else {
                                        ?>
                                        <h4 style="color: red;">Inactif</h4>
                                        <?php
                                    }
                                    ?>
                                </td>
                                
                            </tr>
                            <?php
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                    <td style="font-size: 20px;">
                        <span>Nombre:</span><span><?= $n ?></span>
                    </td>
                    <td style="font-size: 20px; color: dodgerblue; font-weight: 700;">
                        <span>Total reste: </span><span><?= $cumulQuantiteResteTot ?></span>
                    </td>
                    </tfoot>
                </table>
            </fieldset>
        </div>
    </div>
</div>

