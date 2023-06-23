<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/participation/participation.php';
include '../models/demande/demande.php';
include '../models/livraison/livraison.php';

?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="glyphicon glyphicon-share" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span><span class="h3">Consommation pour fabrication</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-list" style="color: dodgerblue; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Liste</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Liste</legend>
                <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1('succes')))) {
                    ?>
                    <div class="alert alert-success">
                        <span class="glyphicon glyphicon-ok" style="font-size: 15px;margin-right: 5px;"></span><span>Activation effectuée avec succès</span>
                    </div>
                    <?php
                }
                ?>
                <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1('traitement_error')))) {
                    ?>
                    <div class="alert alert-danger">
                        <span class="glyphicon glyphicon-ban-circle" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur d'activation</span>
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
                <table class="table table-bordered table-responsive-lg">
                    <thead>
                    <th>
                        N°
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        Production
                    </th>
                    <th>
                        Preparation
                    </th>
                    <th>
                        Valeur consommation
                    </th>
                    
                    
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $cumulPart=0;
                        $bdParticipation = new BdParticipation();
                        $participations = $bdParticipation->getParticipationByMutationDesc($_SESSION['idaffectation']);
                        foreach ($participations as $participation) {
                            ++$n; ?>
                            <tr>
                                <td><?= $participation['id']; ?></td>
                                <td><?= $participation['ptDate']; ?></td>
                                <td><?= 'Date : '.$participation['pdDateHeure'].' / Produit : '.$participation['designation'].' / Quantité : '.$participation['quantite']; ?></td>
                                <td><?= 'Categorie : '.$participation['typerepas'].' / Date : '.$participation['prDateHeure']; ?></td>
                                
                                <td>
                                    <?php
                                    $valeur = 0;
                                    $bdDemande = new BdDemande();
                                    $bdLivraison = new BdLivraison();
                                    $demandes = $bdDemande->getDemandeByPreparation($participation['prId']);
                                    foreach ($demandes as $demande) {
                                        $livraisons = $bdLivraison->getLivraisonByDemande($demande['dId']);
                                        foreach ($livraisons as $livraison) {
                                            $valeur = $valeur + ($livraison['quantite_actuelle'] * $livraison['lPrix']);
                                        }
                                    }
                             ?>
                            <strong>

                                 <p style="color: orange;">
                                     <?php

                                            $itemsPortion=explode('--',$participation['portionPreparation']);
                                                                            
                                            $calcP=[''];


                                            foreach($itemsPortion as $part) {
                                                if ($part!='') {
                                                    $livP=explode(':',$part);
                                                    if ($livP[0]==$livraison['lId']) {
                                                        $calcP=explode('*',$livP[1]);
                                                    }
                                                }
                                                
                                            }

                                            if (($calcP[0]!='') && is_numeric($calcP[0])) {
                                                echo $calcP[0].'*'.$calcP[1].'$ = '.($calcP[0]*$calcP[1]).'$';
                                                $cumulPart=$cumulPart+($calcP[0]*$calcP[1]);

                                            }
                                            ?>
                                 </p>
                                
                            </strong>
                            </td>
                                
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                    <tfoot>
                    <td style="font-size: 20px;">
                        <span>Nombre:</span><span><?= $n; ?></span>
                    </td>
                    <td style="font-weight:bold; color: forestgreen;">
                        <span>Total: </span><span><?= $cumulPart.' USD'; ?></span>
                    </td>
                    </tfoot>
                </table>
            </fieldset>
        </div>
    </div>
</div>

