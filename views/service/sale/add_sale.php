<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/customer/Customer.php';
include '../models/production/production.php';
include '../models/sale/Sale.php';
include '../models/lineSale/LineSale.php';

?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-dollar" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Vente</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-asterisk" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Production</span>
    </div>
    <div class="panel panel-body">
        <div>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1('succes')))) {
                ?>
                <div class="alert alert-success">
                    <span class="glyphicon glyphicon-ok" style="font-size: 15px;margin-right: 5px;"></span><span>Success</span>
                </div>
                <?php
            }
            ?>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1('traitement_error')))) {
                ?>
                <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-ban-circle" style="font-size: 15px;margin-right: 5px;"></span><span>Error</span>
                </div>
                <?php
            }
            ?>
            <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1('remplissage_error')))) {
            ?>
                <div class="alert alert-warning">
                    <span class="glyphicon glyphicon-blackboard" style="font-size: 15px;margin-right: 5px;"></span><span>Data error</span>
                </div>
            <?php
                }
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1('quantite_error')))) {
            ?>
                <div class="alert alert-warning">
                    <span class="glyphicon glyphicon-bars" style="font-size: 15px;margin-right: 5px;"></span><span>Quantité insuffisante</span>
                </div>
            <?php
                }
            ?>
            <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1('already_exist')))) {
            ?>
                <div class="alert alert-warning">
                    <span class="glyphicon glyphicon-check" style="font-size: 15px;margin-right: 5px;"></span><span>Validated</span>
                </div>
            <?php
                }
            ?>

            <a class="btn btn-warning p-1 mt-1 text-white" style="font-size: 20px;" href="/views/home.php?link_up=<?= sha1('home_logistique_customer'); ?>"><span class="fa fa-user fs-5 text-white"></span> Clients</a>
            <form class="form-horizontal" method="POST" action="../contollers/sale/saleController.php">
                <div class="row form-group-lg">
                    <div class="col-8 input-group-lg">
                        <label class="control-label">Client :</label>
                          <select class="form-control select2" name="cb_customer" >
                            <option value="0">Choisir un client</option>
                            <?php
                                $bdCustomer = new BdCustomer();
                                $customers = $bdCustomer->getCustomerAllActive($_SESSION['idutilisateur']);
                                
                                if (count($customer) > 0) {
                                    foreach ($customers as $customer) {
                            ?>
                                <option value="<?= $customer['id']; ?>"><?= $customer['identite'].' / Tél. : '.$customer['telephone'].' / Email : '.$customer['email'].' / Website : '.$customer['siteweb']; ?></option>
                            <?php
                                    }
                                }
                            ?>
                          </select>
                    </div> 
                    <div class="col-4 mt-3">
                        <div class="input-group-lg">
                            <input class="btn btn-success fs-6" type="submit" name="bt_select_customer" value="Sélectionner">
                        </div>
                    </div>
                </div>
            </form>
            <hr>
            <fieldset>
                <legend>
                     
                    <?php
                    if (isset($_GET['use_customer'])) {
                        $customerId = $_GET['use_customer'];
                    } else {
                        $customerId = 0;
                    }
                    $info_customer = '';
                    $bdCustomer = new BdCustomer();
                    $customers = $bdCustomer->getCustomerById($customerId);
                    foreach ($customers as $customer) {
                        $info_customer = $customer['identite'].' / Tél. : '.$customer['telephone'].' / Email : '.$customer['email'].' / Website : '.$customer['siteweb'];
                    }

                    ?>
                    <p>
                        <strong style="color: #0080c0;">Client : <?= $info_customer; ?></strong>
                    </p>
                </legend>
            </fieldset>
<fieldset>
<?php
if ($info_customer != '') {
?>
<form class="form-horizontal" method="POST" action="../contollers/sale/saleController.php">
    <table class="table">
    <tr>
        <td>
<div class="form-group-lg">
    <div class="input-group-lg">
        <label class="control-label">Numero Vente :</label>
        <?php
        $bdSale = new BdSale();
        $recentId = 0;
        $sales = $bdSale->getSaleRecent();
        foreach ($sales as $sale) {
        $recentId = $sale['recentId'];
        }

        if (!(isset($_GET['use_sale']))) {
        $saleId = ($recentId + 1); ?>
        <input type="text" class="form-control" name="tb_saleId" value="<?= $saleId; ?>">
        <div class="input-group-lg">
            <label class="control-label">Date :</label>
            <input type="date" class="form-control" name="tb_date" value="<?=date('Y-m-d')?>">
        </div>
        <?php
        } else {
        $saleId = $_GET['use_sale']; ?>
        <p><strong><?= $saleId; ?></strong></p>
        <?php
        } ?>    
        <input type="hidden" name="tb_customerId" value="<?= $_GET['use_customer']; ?>">
        
    </div>
</div>
                    </td>
                    <td>
                        <div style="margin: 10px;" class="form-group-sm">
                            <?php
                            if (!(isset($_GET['use_sale']))) {
                                ?>
                            <div>
                                <input class="btn btn-primary" type="submit" name="bt_valider_sale" value="Valider">
                            </div>
                            <?php
                            } else {
                            ?>
                            <input class="btn btn-danger" type="submit" name="bt_reset_sale" value="Réinitialiser">
                            <a style="font-size: 20px;" href='../views/service/sale/pdf_facture.php?use_sale=<?= $_GET['use_sale']?>' class="btn btn-primary pull-right">Imprimer facture</a>
                            <?php
                            } 
                            ?> 
                        </div>
                    </td>
                </tr>
            </table>
    </form>
<?php
}
?>


<hr>
<?php
if (isset($_GET['use_sale'])) {
?>
<form class="form-horizontal" method="POST" action="../contollers/sale/saleController.php">
<div>
<div class="input-group-lg">
        <table class="table table-tripped table-bordered table-hover">
                <tr>
                    <td>
<div class="input-group-lg">
    <label id="selectProduct" class="control-label">Produit : </label>
    <select class="form-control select2" name="cb_production" >
        <option value="0">Choisir un produit</option>
        <?php
        $bdProduction = new BdProduction();
        $bdLineSale=new BdLineSale();
                                                
    $productions = $bdProduction->getProductionAllSecond();
    foreach ($productions as $production) {
        $reste=0;
        $lineSales=$bdLineSale->getlineSaleByProductionId($production['id']);
        $cumulQuantiteLS=0;
        foreach ($lineSales as $lineSale) {
            $cumulQuantiteLS=$cumulQuantiteLS+$lineSale['quantite'];
        }
        $reste=($production['quantite']-$cumulQuantiteLS);
        if (($reste>0) && ($production['serviceId']==$_SESSION['idservice'])) {
            ?>
        <option value="<?= $production['id']; ?>"><?= 'Date : '.$production['dateHeurePD'].' / Name : '.$production['designation'].' / Quantité : '.$production['quantite']; ?><span style="color: red; font-weight: 700;"><?= " / Reste: ".($reste)." / PU Vente: ".($production['prixUnitaireVente']) ?></span></option>
    <?php
        } 
    }
 ?>                                       
    </select>
    </div>
</td>
<td>
    <div class="input-group-lg">
        <label class="control-label">Qté :</label>
        <input type="text" class="form-control" name="tb_quantite" value="1">
    </div>
</td>
<td>
    <div class="input-group-lg">
        <label class="control-label">Prix unitaire (USD) :</label>
        <input type="text" class="form-control" name="tb_prix">
    </div>
</td>

<td>
    <div class="input-group-lg">
        <label class="control-label">TVA Percentage :</label>
        <input type="text" class="form-control" name="tb_tauxTVA" value="0">
    </div>
</td>
<td>
    <div style="margin: 15px;" class="input-group-lg">
        <input class="btn btn-success" type="submit" name="bt_enregistrer" value="Enreg.">
        <input class="form-control" type="hidden" name="tb_saleId" value="<?= $_GET['use_sale']; ?>">
        <input class="form-control" type="hidden" name="tb_customerId" value="<?= $_GET['use_customer']; ?>">
    </div>
</td>
</tr>
</table>

</div>

</div>
</form>
<?php
}
?>

</fieldset>

<hr>

            <?php
include 'list_sale_self.php';
            ?>

        </div>
    </div>

</div>

