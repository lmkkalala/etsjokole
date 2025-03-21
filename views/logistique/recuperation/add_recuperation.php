<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/attribution-biens/attributionBiens.php';
include '../models/demande/demande.php';
include '../models/livraison/livraison.php';
include '../models/preparation/preparation.php';
include '../models/service/service.php';
include '../models/affectation-service/affectationService.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-cubes" style="color: #0069d9; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-recycle" style="color: #0069d9; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Récuperation</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-asterisk" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Nouvelle récuperation</span>
    </div>
    <div class="panel panel-body">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("succes")))) {
                    ?>
                        <div class="alert alert-success">
                            <span class="glyphicon glyphicon-ok" style="font-size: 15px;margin-right: 5px;"></span><span>Enregistrement effectué avec succès</span>
                        </div>
                    <?php
                    }

                    if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("traitement_error")))) {
                    ?>
                        <div class="alert alert-danger">
                            <span class="glyphicon glyphicon-ban-circle" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur d'enregistrement</span>
                        </div>
                    <?php
                    }
        
                    if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("remplissage_error")))) {
                    ?>
                        <div class="alert alert-warning">
                            <span class="glyphicon glyphicon-blackboard" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur de remplissage, Recommencer SVP</span>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
                
            <div class="row" style="background-color: whitesmoke; padding: 10px;">
                <div class="col-md-12">
                    <form class="form-horizontal" method="POST" action="../contollers/recuperation_logistique/recuperationController.php">
                        <div class="row form-group-lg">
                            <div class="col-md-6 mt-2 input-group-lg">
                                <label class="control-label">Chercher par réquisition :</label>
                                <select class="form-control select2" name="cb_preparation">
                                    <option value="0">Choisir une activité</option>
                                    <?php
                                    $use_preparation = (isset($_GET['use_preparation'])) ? ' AND preparation.id = "'.htmlspecialchars($_GET['use_preparation']).'" ' : ' ';
                                    
                                    $bdpreparation = new BdPreparation();

                                    $preparations = $bdpreparation->getPreparationAllDesc('INNER JOIN demande ON demande.preparation_id = preparation.id INNER JOIN distrubution on distrubution.demande_id = demande.id WHERE distrubution.quantite_actuelle != 0 '.$use_preparation.' ','preparation.dateHeure','preparation.id, preparation.active, preparation.mutation_id, preparation.typerepas, preparation.dateHeure');
                                    $current_prep_id = '';
                                    $N = 0;
                                    foreach ($preparations as $preparation) {
                                        if ($preparation['active'] == 1 and $current_prep_id != $preparation['id']) {

                                                $current_prep_id = $preparation['id'];
                                                $bdaffectationservice = new BdAffectationService();
                                                $affectationservices = $bdaffectationservice->getAffectationServiceById($preparation['mutation_id']);
                                                foreach ($affectationservices as $affectationservice) {
                                                    $bdservice = new BdService();
                                                    $services = $bdservice->getServiceById($affectationservice['service_id']);
                                                    foreach ($services as $service) {
                                                        $designation_service = $service['designation'];
                                                    }
                                                }
                                                $N++;
                                    ?>
                                                <option value="<?= $preparation['id'] ?>"><?= $preparation['typerepas'] ." / ". $designation_service." / " . $preparation['dateHeure'] ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>                    
                            <div class="col-md-6 mt-2">
                                <div class="input-group-lg">
                                    <input class="btn btn-secondary w-100 fs-6 mt-3" type="submit" name="bt_select_preparation_for_add_recuperation" value="Selectionner">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            
                <div class="col-md-12">
                    <legend style="margin: 5px; color: dodgerblue;">
                        <?php
                        if (isset($_GET['use_preparation'])) {
                            $bdpreparation = new BdPreparation();
                            $preparations = $bdpreparation->getPreparationById($_GET['use_preparation']);
                            foreach ($preparations as $preparation) {
                                $bdaffectationservice = new BdAffectationService();
                                $affectationservices = $bdaffectationservice->getAffectationServiceById($preparation['mutation_id']);
                                foreach ($affectationservices as $affectationservice) {
                                    $bdservice = new BdService();
                                    $services = $bdservice->getServiceById($affectationservice['service_id']);
                                    foreach ($services as $service) {
                                        $designation_service = $service['designation'];
                                    }
                                }
                                ?>
                                <?=  $designation_service . " / " . $preparation['typerepas']." / " .$preparation['dateHeure'] ?>

                                <?php
                                
                            }
                        }
                        ?>
                    </legend>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <h4>Les livraisons</h4>
                </div>
                <div class="col-md-12">
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <td>
                                    N°
                                </td>
                                <td>
                                    Date
                                </td>
                                <td>
                                    Demande
                                </td>
                                <td>
                                    Qté restante
                                </td>
                                <td>
                                    Livreur
                                </td>
                                <td>
                                    Opération
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($_GET['response'])) {
                                echo $_GET['response'];
                            }
                            
                            $n = 0;
                            $bdlivraison = new BdLivraison();
                            if (isset($_GET['use_preparation'])) {
                                $livraisons = $bdlivraison->getLivraisonByPreparationId($_GET['use_preparation']);
                            } else {
                                $livraisons = [];
                            }
                            
                            foreach ($livraisons as $livraison) {
                                //if (($livraison['lQuantite'] == $livraison['lQuantiteActuelle']) && ($livraison['lEtat']==0)) {
                                if (($livraison['lQuantiteActuelle']>0) && (1)) {
                                    $n++;
                                    ?>
                                    <tr>
                                        <td><?= $livraison['lId'] ?></td>
                                        <td><?= $livraison['lDate'] ?></td>
                                        <td widtd="200"><?= $livraison['dId'] ?> . <?= $livraison['date'] . " / " . $livraison['bDesignation'] . " / " . $livraison['gDesignation'] . " pour " . $livraison['nom'] . " " . $livraison['postnom'] . " " . $livraison['prenom'] . " : " . $livraison['sDesignation'] . " / Qté : " . $livraison['dQuantite'] ?></td>
                                        <td><?= $livraison['lQuantiteActuelle'] ?></td>
                                        <td><?= $livraison['lNom'] . " " . $livraison['lPostnom'] . " " . $livraison['lPrenom'] ?></td>
                                        <td>
                                            
                                            <form method="post" action="../contollers/recuperation_logistique/recuperationController.php">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <textarea name="description" id="description" placeholder="Note la raison de la recuperation ..." class="form-control"></textarea>
                                                    </div>
                                                    <div class="col-md-6 mt-1">
                                                        <input type="text" name="tb_quantite_recupere" class="form-control" value="<?= $livraison['lQuantiteActuelle'] ?>">
                                                        <input type="hidden" name="tb_quantite_actuelle" class="form-control" value="<?= $livraison['lQuantiteActuelle'] ?>">
                                                        <input type="hidden" name="tb_idlivraison" value="<?= $livraison['lId'] ?>">
                                                        <input type="hidden" name="tb_idagent" value="<?= $livraison['agId'] ?>">
                                                        <input type="hidden" name="tb_idbien" value="<?= $livraison['bId'] ?>">
                                                    </div>
                                                    <div class="col-md-6 mt-1">
                                                        <button type="button" class="btn btn-primary w-100 bt_recuperer_low_validate" name="bt_recuperer_low_validate" id="bt_recuperer_low_validate_<?= $livraison['lId'] ?>">
                                                            <span class="fa fa-recycle" style="font-size: 25px;margin-right: 5px;"></span>
                                                        </button>
                                                        <button type="submit" class="btn btn-primary w-100 bt_recuperer_low" name="bt_recuperer_low" id="bt_recuperer_low_<?= $livraison['lId'] ?>">
                                                            <span class="fa fa-recycle" style="font-size: 25px;margin-right: 5px;"></span>Valider
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                            
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td style="font-size: 20px;">
                                    <span><?= $n ?></span>
                                </td>
                                <td>
                                    <span>Nombre</span>
                                </td>
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

