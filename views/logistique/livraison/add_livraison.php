<?php
/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/
include '../models/attribution-biens/attributionBiens.php';
include '../models/demande/demande.php';
include '../models/preparation/preparation.php';
include '../models/service/service.php';
include '../models/affectation-service/affectationService.php';
include '../models/crud/db.php';
$DB = new DB();
$option = "";
$lieuReceptions = $DB->get('lieureception');
foreach ($lieuReceptions as $key => $lieuReception) {
$option = $option."<option value='".$lieuReception['id']."' class='form-control'>".$lieuReception['lieu']."</option>";
}

$optionReceptionCommand = "";

?>
<div class="panel">
<div class="panel panel-heading">
<span class="fa fa-cubes" style="color: red; font-size: 30px;margin-right: 5px;"></span>
<span class="fa fa-share-alt" style="color: red; font-size: 30px;margin-right: 5px;"></span>
<span class="h3">Livraison</span>
<span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
<span class="glyphicon glyphicon-asterisk" style="color: red; font-size: 30px;margin-right: 5px;"></span>
<span class="h4">New</span>
</div>
<div class="panel panel-body">
<div>
<?php
if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("succes")))) {
    ?>
    <div class="alert alert-success">
        <span class="glyphicon glyphicon-ok" style="font-size: 15px;margin-right: 5px;"></span><span>Enregistrement effectué avec succès</span>
    </div>
<?php
}
?>
<?php
if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("traitement_error")))) {
    ?>
    <div class="alert alert-danger">
        <span class="glyphicon glyphicon-ban-circle" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur d'enregistrement</span>
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
<?php
if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("quantite_error")))) {
    ?>
    <div class="alert alert-danger">
        <span class="glyphicon glyphicon-pencil" style="font-size: 15px;margin-right: 5px;"></span><span>Quantité insuffisante</span>
    </div>
    <?php
}
?>
<div style="background-color: whitesmoke; padding: 10px;">
    <form class="form-horizontal" method="POST" action="../contollers/livraison/livraisonController.php">
        <div class="row form-group-lg">
            <div class="col-6 input-group-lg">
                <label class="control-label">Activity :</label>
                <select class="form-control select2" name="cb_preparation">
                    <option value="0">Choisir une activité</option>
                    <?php
                    $bdpreparation = new BdPreparation();
                    $preparations = $bdpreparation->getPreparationAllDesc();
                    foreach ($preparations as $preparation) {
                        if ($preparation['active']) {
                            if (1) {
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
                                <option value="<?= $preparation['id'] ?>"><?= $preparation['typerepas'] ." / ". $designation_service." / " . $preparation['dateHeure'] ?></option>
                                <?php
                            }
                        }
                    }
                    ?>
                </select>
            </div>                    
            <div class="col-6">
                <legend></legend>
                <div class="input-group-lg">
                    <input class="btn btn-success" type="submit" name="bt_select_preparation_for_add_livraison" value="Selectionner">
                </div>
                </div>
        </div>
    </form>
</div>

<div style="margin: 10px;">
    <fieldset>
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
                    <?= $preparation['dateHeure'] . " / " . $preparation['typerepas'] . " / " . $designation_service ?>

                    <?php
                    $date_tempo = $preparation['dateHeure'];
                }
            }
            ?>
        </legend>
    </fieldset>
</div>

<div>
    <div style="margin: 10px;">
        <fieldset>
            <legend>Requisitions</legend>
            <table class="table table-bordered table-striped table-responsive-lg">
                <thead>
                    <th>
                        #
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        Item
                    </th>
                    <th>
                        Situation stock
                    </th>
                    <th>
                        Quantity
                    </th>
                    <th>
                        Livraison / Lieu Livrer
                    </th>
                    <th>
                        Prix
                    </th>
                    <th>
                        Statut
                    </th>
                </thead>
                <tbody>
                    <?php
                    $n = 0;
                    $bddemande = new BdDemande();
                    if (isset($_GET['use_preparation'])) {
                        $demandes = $bddemande->getDemandeByPreparationEncours($_GET['use_preparation']);
                    } else {
                        $demandes = $bddemande->getDemandeByPreparation(0);
                    }

                    foreach ($demandes as $demande) {
                        if (1) {
                            $n++;
                        $optionReceptions = $DB->getWhereMultipleMore(" *,stockage.id AS Sid, stockage.quantite AS Sq, stockage.date AS Sdate , stockage.prix AS Sprix  FROM stockage INNER JOIN attribution ON stockage.attribution_id = attribution.id INNER JOIN biens ON attribution.biens_id = biens.id "," biens.id = ".$demande['bId']."  ", " ORDER BY stockage.date DESC ");
                        foreach ($optionReceptions as $key => $optionReception) {
                            $optionReceptionCommand = $optionReceptionCommand."<option value='".$optionReception['Sid']."' class='form-control'> Date: ".$optionReception['Sdate']." / Qte: ".$optionReception['Sq']." / Prix reception: ".$optionReception['Sprix']."</option>";
                        }
                    ?>
                            <form class="form-horizontal" method="POST" action="../contollers/livraison/livraisonController.php">
                                <tr>
                                    <td><?= $demande['dId'] ?></td>
                                    <td width="100"><input class="form-control" type="date" name="tb_date" value="<?= $date_tempo ?>"></td>
                                    <td><?= $demande['bDesignation'] . " / " . $demande['gDesignation'] ?></td>
                                    <td><span style="font-weight: 700; color: orange;"><?= " / Qté stock: ". $demande['quantite'] ?></span></td>
                                    <td><input class="form-control" type="text" name="tb_quantite" value="<?= $demande['dQuantite'] ?>"></td>
                                    
                                    <td>
                                        <div>
                                            <select name="stockage_id" id="stockage_id" class="form-control">
                                                <option value="">Par Defaut</option>
                                                <?=$optionReceptionCommand?>
                                            </select>
                                        </div>
                                        <div class="mt-2">
                                            <select name="lieu_id" id="lieu_id" class="form-control">
                                                <option value="">Par Defaut</option>
                                                <?=$option?>
                                            </select>
                                        </div>
                                    </td>
                                    <td><input class="form-control" type="number" step=0.01 name="prix_reception" id="prix_reception" value="0"></td>
                                    <td>
                                        <?php
                                        if ($demande['dEtat'] == 0) {
                                        ?>
                                            <h4 style="color: forestgreen;">Encours</h4>
                                        <?php
                                        } else {
                                        ?>
                                            <h4 style="color: red;">Finalisée</h4>
                                        <?php
                                        }
                                        ?>
                                        <input type="hidden" name="bien_id" value="<?= $demande['bId'] ?>">
                                        <input type="hidden" name="tb_iddemande" value="<?= $demande['dId'] ?>">
                                        <input type="hidden" name="tb_idpreparation" value="<?= $_GET['use_preparation'] ?>">
                                        <button class="btn btn-success" type="submit" name="bt_enregistrer">Send</button>
                                    </td>
                                </tr>
                            </form>

                        <?php
                        $optionReceptionCommand = "";
                    }
                }
                ?>
                </tbody>
                <tfoot>
                <td style="font-weight: bold;">
                    <span>Number :</span><span><?= $n ?></span>
                </td>
                </tfoot>
            </table>
        </fieldset>
    </div>
</div>

</div>

</div>
</div>

