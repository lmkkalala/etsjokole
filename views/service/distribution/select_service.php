<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="row" style="margin: 20px;">
    <form  method="post" action="../contollers/distribution/distributionController.php">
        <div class="row">
            <div class="col-md-6 input-group-lg">
                <select class="form-control select2" name="cb_service">
                    <option value="0">Choisir un POS/Departement/Service</option>
                    <?php
                    $bdservice = new BdService();
                    $services = $bdservice->getServiceAllDesc();
                    foreach ($services as $service) {
                        if (($service['id'] == $_SESSION['idservice']) || ($_SESSION['type']=="logistique")) {
                    ?>
                            <option 
                             <?php
                                if (($service['id'] == $_SESSION['idservice']) && ($_SESSION['type']!="logistique")) {
                                    echo ' selected ';
                                }
                             ?>
                            value="<?= $service['id'] ?>"><?= $service['designation'] ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-6">
                <select class="form-control select2" name="cb_identiteClient">
                    <option value="none">Choisir le client</option>
                    <?php
                    $bdDistribution = new BdDistribution();
                    $distributions = $bdDistribution->getDistributionAllDistinctClient();
                    foreach ($distributions as $distribution) {
                        if (1) {
                    ?>
                            <option value="<?= $distribution['distinctIdentiteClient'] ?>"><?= $distribution['distinctIdentiteClient'] ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-6">
                <label class="control-label">Starting date : </label>
                <input type="date" class="form-control" name="tb_date1">
            </div>
            <div class="col-md-6">
                <label class="control-label">Ending date :</label>
                <input type="date" class="form-control" name="tb_date2">
            </div>
            <div class="col-md-6">
                <label class="control-label">Type :</label>
                <select class="form-control select2" name="cb_typerepas">
                    <option value="0">Choose a type</option>
                    <option value="Transfer" selected>Vente</option>
                    <option value="PRO">PRO</option>
                    <option value="Bar">Bar</option>
                    <option value="Restau">Restau</option>
                    <option value="Spoilage">Spoilage</option>
                    <option value="cleaning">Cleaning</option>
                    <option value="non-consomable">Non-consomable</option>
                    <option value="Transfer to Bukavu">Transfer to Bukavu</option>
                    <option value="Back to supplier">Back to supplier</option>
                    <option value="Back charge to client">Back charge to client</option>
                    <option value="Fonction">Fonction</option>
                </select>
                <input type="hidden" name="tb_link" value="<?= $link ?>">
            </div>
            <div class="col-md-6">
                <?php
                if (isset($_GET['use2'])) {
                ?>
                    <input type="hidden" name="tb_idbiens" value="<?= $_GET['use2'] ?>">
                <?php
                } else {
                ?>
                    <input type="hidden" name="tb_idbiens" value="<?= 0 ?>">
                <?php
                }
                ?>
                <input class="btn btn-primary mt-3" type="submit" name="bt_search_by_service" value="Choisir">
            </div>
        </div>
    </form>
    <div class="row" style="margin: 20px;">
        <legend>Service / Département / Site : </legend>
        <h3>
            <strong style="color: forestgreen;">
                <?php
                if (isset($_GET['use'])) {
                    $bdservice = new BdService();
                    $services = $bdservice->getServiceById($_GET['use']);
                    foreach ($services as $service) {
                        echo $service['designation'];
                    }
                } else {
                    echo "Aucun choix";
                }
                ?>
            </strong>

        </h3>
    </fieldset>
</div>