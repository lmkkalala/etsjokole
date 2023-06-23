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
        <span class="h3">Sale</span>
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
            <form class="form-horizontal" method="POST" action="../contollers/sale/saleController.php">
                <div class="form-group-lg">
                    <div class="input-group-lg">
                        <label class="control-label">Customer :</label>
                       
                          <select class="form-control select2" name="cb_customer" >
                            <option value="0">Choose a customer</option>
                            <?php
                                $bdCustomer = new BdCustomer();
                                $customers = $bdCustomer->getCustomerAllActive();
                                foreach ($customers as $customer) {
                                    ?>
                                <option value="<?= $customer['id']; ?>"><?= $customer['identite'].' / Tél. : '.$customer['telephone'].' / Email : '.$customer['email'].' / Website : '.$customer['siteweb']; ?></option>
                                    <?php
                                }
                            ?>
                            
                          
                          </select>
                    </div>
                    <fieldset>
                        <legend></legend>
                        <div class="input-group-lg">
                            <input class="btn btn-success" type="submit" name="bt_select_customer" value="Selectionner">
                            
                        </div>
                    </fieldset>
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
                        <strong style="color: #0080c0;">Selected customer : <?= $info_customer; ?></strong>
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
                                        <label class="control-label">Sale number :</label>
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
                                                                                    <?php
                    } else {
                        $saleId = $_GET['use_sale']; ?>
                                        <p><strong><?= $saleId; ?></strong>
                                        </p>
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
                                                <input class="btn btn-primary" type="submit" name="bt_valider_sale" value="Valider">
                                                <?php
                                                } else {
                                                    ?>
                                                <input class="btn btn-danger" type="submit" name="bt_reset_sale" value="Réinitialiser">
                                                <?php
                                                } ?>
                                            
                                                
                                                
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
                                                                <label class="control-label">Product to sale : </label>
                                                                <select class="form-control select2" name="cb_production" >
                                                                    <option value="0">Choose a product</option>
                                                                    <?php
                                                                    $bdProduction = new BdProduction();
                    $productions = $bdProduction->getProductionAllSecond();
                    foreach ($productions as $production) {
                        ?>
                                                                                                    <option value="<?= $production['id']; ?>"><?= 'Date : '.$production['dateHeurePD'].' / Name : '.$production['designation'].' / Quantité : '.$production['quantite']; ?></option>
                                                                                                <?php
                    } ?>
                                                                    
                                                                
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group-lg">
                                                                <label class="control-label">Qty to sale :</label>
                                                                <input type="text" class="form-control" name="tb_quantite" value="1">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group-lg">
                                                                <label class="control-label">Price (USD) :</label>
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
                                                                <input class="btn btn-success" type="submit" name="bt_enregistrer" value="Save">
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

