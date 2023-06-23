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
        <span class="fa fa-list-ol" style="color: darkgrey; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">List</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend><strong>List of sale</strong></legend>
            </fieldset>

            <fieldset>
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
                                <input class="btn btn-success" type="submit" name="bt_select_customer_list" value="Selectionner">
                                
                            </div>
                        </fieldset>
                    </div>
                </form>
            </fieldset>

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
                <table class="table table-striped table-hover">
                    
                        <?php
                        $grand_cumul_HT = 0;
                        $grand_cumul_TTC = 0;
                        $bdSale = new BdSale();
                        if ((isset($_GET['use_customer'])) && ($_GET['use_customer'] != 0)) {
                            $sales = $bdSale->getSaleByCustomer($_GET['use_customer']);
                        } else {
                            $sales = $bdSale->getSaleAll();
                        }
                        foreach ($sales as $sale) {
                            $dateSale = $sale['dateEnreg'];
                            $info_customer_2 = $sale['identite'].' / Phone : '.$sale['telephone'].' / Email : '.$sale['email'].' / Website URL : '.$sale['siteweb']; ?>
                            <thead class="thead-light">
                                <tr>
                                    <th>Reference</th>
                                    <th>Date</th>
                                    <th>Customer</th>
                                </tr>
                                <tr>
                                    <td><?= $sale['id']; ?></td>
                                    <td><?= $dateSale; ?></td>
                                    <td><?= $info_customer_2; ?></td>
                                </tr>
                            </thead>
                            <tbody>
                                <td>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <th>Date</th>
                                        <th>Customer</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Prix</th>
                                        <th>Total HT</th>
                                        <th>TVA percentage</th>
                                        <th>Total TTC</th>
                                        <th></th>
                                        <th></th>

                                    </thead>
                                            <?php

$cumul_HT = 0;
                            $cumul_TTC = 0;

                            $bdLineSale = new BdLineSale();
                            if (1) {
                                $lineSales = $bdLineSale->getlineSaleBySale($sale['id']);
                            }
                            foreach ($lineSales as $lineSale) {
                                ?>
                                                            <tr>
                                                    <td>
                                                    <td>
                                                                                                                
                                                                                                                    
                                                                                                                        <?php
                                                                         $bdProduction = new BdProduction();
                                $productions = $bdProduction->getProductionById($lineSale['productionId']);
                                foreach ($productions as $production) {
                                    ?>
                                                                                                                                                        <p><?= 'Date : '.$production['dateHeurePD'].' / Name : '.$production['designation'].' / Quantité : '.$production['quantite']; ?></p>
                                                                                                                                                    <?php
                                } ?>
                                                                                                
                                                                
                                                                
                                                        </td>
                                                        <td>
                                                            <p><?= $lineSale['quantite']; ?></p>
                                                        </td>
                                                        <td>
                                                            <p><?= $lineSale['prix']; ?></p>
                                                        </td>
                                                        <td>
                                                            <p><?= ($lineSale['quantite'] * $lineSale['prix']); ?></p>
                                                        </td>
                                                        <td>
                                                            <p><?= $lineSale['tauxTVA']; ?></p>
                                                        </td>
                                                        <td>
                                                            <p><?= (1 + ($lineSale['tauxTVA'] / 100)) * ($lineSale['quantite'] * $lineSale['prix']); ?></p>
                                                        </td>
                                                        <td>
                                                            <div class="input-group-lg">
                                                                <input class="btn btn-primary" type="submit" name="bt_update" value="Edit">
                                                                <input class="form-control" type="hidden" name="tb_saleLineId" value="<?= $lineSale['id']; ?>">
                                                                <input class="form-control" type="hidden" name="tb_saleId" value="<?= $_GET['use_sale']; ?>">
                                                                <input class="form-control" type="hidden" name="tb_customerId" value="<?= $_GET['use_customer']; ?>">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group-lg">
                                                                <input class="btn btn-danger" type="submit" name="bt_delete" value="Delete">
                                                                <input class="form-control" type="hidden" name="tb_saleLineId" value="<?= $lineSale['id']; ?>">
                                                                <input class="form-control" type="hidden" name="tb_saleId" value="<?= $_GET['use_sale']; ?>">
                                                                <input class="form-control" type="hidden" name="tb_customerId" value="<?= $_GET['use_customer']; ?>">
                                                            </div>
                                                        </td>
                                                    </tr>
    <?php
    $cumul_HT = $cumul_HT + (($lineSale['quantite'] * $lineSale['prix']));
                                $cumul_TTC = $cumul_TTC + ((1 + ($lineSale['tauxTVA'] / 100)) * ($lineSale['quantite'] * $lineSale['prix']));
                            } ?>
                    <tfoot>
                        <td> Total HT : <strong><?= $cumul_HT; ?> USD</strong></td>
                        <td> Total TTC : <strong><?= $cumul_TTC; ?> USD</strong></td>
                    </tfoot>
                                                 
                                                </table>
                                </td>
                            </tbody>
                            <?php
                            $grand_cumul_HT = $grand_cumul_HT + $cumul_HT;
                            $grand_cumul_TTC = $grand_cumul_TTC + $cumul_TTC;
                        }
                        ?>
                   <tfoot>
                       
                       <tr>
                            <td>
        <strong>Grand total HT <?= $grand_cumul_HT; ?> USD</strong>
                            </td>
                       </tr>
                       <tr>
                            <td>
        <strong>Grand total TTC <?= $grand_cumul_TTC; ?> USD</strong>
                            </td>
                       </tr>

                   </tfoot>
                </table>
            </fieldset>


        </div>
    </div>
</div>