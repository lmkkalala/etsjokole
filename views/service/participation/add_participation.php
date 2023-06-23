<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/preparation/preparation.php';
include '../models/nourriture/nourriture.php';
include '../models/production/production.php';
include '../models/livraison/livraison.php';
include '../models/ravitaillement/ravitaillement.php';
include '../models/participation/participation.php';


?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-cube" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-plus-square-o" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Consommation pour fabrication des produits</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-asterisk" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">New</span>
    </div>
    <div class="panel panel-body">
        <div>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1('succes')))) {
                ?>
                <div class="alert alert-success">
                    <span class="glyphicon glyphicon-ok" style="font-size: 15px;margin-right: 5px;"></span><span>Enregistrement effectué avec succès</span>
                </div>
                <?php
            }
            ?>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1('traitement_error')))) {
                ?>
                <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-ban-circle" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur d'enregistrement</span>
                </div>
                <?php
            }
            ?>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1('remplissage_error')))) {
                ?>
                <div class="alert alert-warning">
                    <span class="glyphicon glyphicon-blackboard" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur de remplissage, Recommencer SVP</span>
                </div>
                <?php
            }
            ?>

            
                <div>
                <form class="form-horizontal" method="POST" action="../contollers/participation/participationController.php">
                    <div class="input-group-lg" style="background-color: whitesmoke; padding: 10px;">
                        <table>
                            <tr>
                                <td>
                                    <label class="control-label">Activité: </label>
                                    <select class="form-control select2" name="cb_preparation">
                                        <option value="0">Choisir une activité</option>
                                        <?php
                                        $bdpreparation = new BdPreparation();
                                        $preparations = $bdpreparation->getPreparationByAffectationService($_SESSION['idaffectation']);
                                        foreach ($preparations as $preparation) {
                                            if ($preparation['active']) {
                                                if (1) {
                                                    ?>
                                                    <option value="<?= $preparation['id']; ?>" 
                                                    <?php
                                                        if ((isset($_GET['use_preparation'])) && ($_GET['use_preparation']==$preparation['id'])) {
                                                            echo ' selected ';
                                                        }
                                                        ?>
                                                    ><?= $preparation['typerepas'].' / '.$preparation['dateHeure']; ?></option>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td style="padding-left: 20px;">
                                    <label class="control-label">Production :</label>
                                    <select class="form-control select2" name="cb_production">
                                        <option value="0">Choisir la production</option>
                                        <?php
                                        $bdProduction = new BdProduction();
                                        $productions = $bdProduction->getProductionAllSecond();
                                        foreach ($productions as $production) {
                                            if (1) {
                                                ?>
                                                    <option value="<?= $production['id']; ?>"
                                                     <?php
                                                        if ((isset($_GET['use_production'])) && ($production['id']==$_GET['use_production'])) {
                                                            echo ' selected ';
                                                        }
                                                     ?>
                                                    ><?= 'Date : '.$production['dateHeurePD'].' / Produit : '.$production['designation'].' / Quantité : '.$production['quantite']; ?></option>
                                                    <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                                
                            </tr>
                            <tr>
                                <td>
                                    <br>
                                    <input type="submit" name="bt_select_preparation_et_production" class="btn btn-primary" value="Selectionner">
                                </td>
                            </tr>
                        </table>
                        
                    </div>
                </form>

                <hr>

                <?php
                    if (isset($_GET['use_preparation'])) {
                        ?>
                <form class="form-horizontal" method="POST" action="../contollers/participation/participationController.php">

                    <br>

                    <table class="table table-bordered table-striped table-responsive-lg">
                    <thead>
                        <th>
                            N°
                        </th>
                        <th>
                            Date
                        </th>
                        <th>
                            Produit
                        </th>
                        <th>
                            Quantité reçues
                        </th>
                        <th>
                            Consommation
                        </th>
                        <th>
                            Valeur consommée
                        </th>
                        
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $cumul_value=0;
                        $cumulPart=0;
                        $bdlivraison = new BdLivraison();
                        $bdParticipation = new BdParticipation();
                        $participationId="";
                        $participations=$bdParticipation->getParticipationByPreparationIdByProductionId($_GET['use_preparation'],$_GET['use_production']);
                        $livraisons = $bdlivraison->getLivraisonDescByIdService($_SESSION['idservice']);
                        foreach ($livraisons as $livraison) {
                            if (($livraison['preparation_id']==$_GET['use_preparation'])) {
                                $portionPreparation="";
                                $participationId="";
                                foreach ($participations as $participation) {
                                    $participationId=$participation['id'];
                                    $portionPreparation=$participation['portionPreparation'];
                                }
                                $itemsPortion=explode('--',$portionPreparation);
                                
                                $calcP=[''];
                                

                                foreach($itemsPortion as $part) {
                                    if ($part!='') {
                                        $livP=explode(':',$part);
                                        if ($livP[0]==$livraison['lId']) {
                                            $calcP=explode('*',$livP[1]);
                                        }
                                    }
                                    
                                }

                                $n++;
                                
                        ?>
                                <tr>
                                    <td><?= $livraison['lId'] ?></td>
                                    <td><?= $livraison['lDate'] ?></td>
                                    <td><?= $livraison['bDesignation'] . " / " . $livraison['gDesignation'] ?></td>
                                    <td><?= $livraison['lQuantite'] ?></td>
                                    <td><input type="text" class="form-control" name="<?= "tb_lq".$livraison['lId'] ?>" value="<?= $calcP[0] ?>"></td>
                                    <td>
                                        <?php
                                            if (($calcP[0]!='') && is_numeric($calcP[0])) {
                                                echo $calcP[0].'*'.$calcP[1].'$ = '.($calcP[0]*$calcP[1]).'$';
                                                $cumulPart=$cumulPart+($calcP[0]*$calcP[1]);

                                            }
                                            // $calcP;
                                            // $livraison['lQuantite'];
                                     ?>
                                    </td>
                                    
                                    
                                </tr>
                        <?php
                                $cumul_value = 0;
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <td style="font-size: 15px;">
                            <span>Nombre:</span><span><?= $n ?></span>
                        </td>
                        <td style="font-weight: 700; color: #00aa00;">
                            Total : <?= $cumulPart.' USD' ?>
                        </td>
                    </tfoot>
                </table>
            
                    <fieldset>
                        <legend></legend>
                        <div class="input-group-lg">
                            <input type="hidden" name="tb_preparationId" value="<?= $_GET['use_preparation'] ?>">
                            <input type="hidden" name="tb_productionId" value="<?= $_GET['use_production'] ?>">
                            <?php
                                if (isset($portionPreparation) && ($portionPreparation=='')) {
                                    ?>
                                        <input class="btn btn-success" type="submit" name="bt_enregistrer" value="Enregistrer">
                                    <?php
                                } else {
                                    ?>
                                        <input type="hidden" name="tb_participationId" value="<?= $participationId ?>">
                                        <input class="btn btn-primary" type="submit" name="bt_update" value="Modifier">
                                    <?php
                                }
                            ?>
                            
                        </div>
                    </fieldset>
                </form>
            
                        <?php
                    }
                ?>
                </div>
            
        </div>

    </div>
</div>

