<?php

?>
<fieldset>
<table class="table table-striped table-bordered table-hover">
<thead>
    <th>Date</th>
    <th>Client</th>
    <th>Produit</th>
    <th>Quantité</th>
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
if (isset($_GET['use_sale'])) {
    $lineSales = $bdLineSale->getlineSaleBySale($_GET['use_sale']);
} else {
    $lineSales = [];
}

$bdProduction = new BdProduction();

$lesProductionIdService=[];
$prds=$bdProduction->getProductionByServiceId($_SESSION['idservice']);
foreach ($prds as $prd) {
    array_push($lesProductionIdService,$prd['id']);
}



foreach ($lineSales as $lineSale) {
    if (in_array($lineSale['productionId'],$lesProductionIdService)) {

    ?>
<tr>
<?php
$bdSale = new BdSale();
    $dateSale = '';
    $info_customer_2 = '';
    $sales = $bdSale->getSaleById($lineSale['saleId']);
    foreach ($sales as $sale) {
        $dateSale = $sale['dateEnreg'];
        $info_customer_2 = $sale['identite'].' / Phone : '.$sale['telephone'].' / Email : '.$sale['email'].' / Website URL : '.$sale['siteweb'];
    } ?>
<td><?= $dateSale; ?></td>
<td><?= $info_customer_2; ?></td>
<td>
                                                            
                                                                
<?php

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
    <form class="form-horizontal" method="POST" action="../contollers/sale/saleController.php">
        <div class="input-group-lg">
            <input class="btn btn-danger" type="submit" name="bt_delete_lineSale" value="Supprimer">
            <input class="form-control" type="hidden" name="tb_lineSaleId" value="<?= $lineSale['id']; ?>">
            <input class="form-control" type="hidden" name="tb_saleId" value="<?= $_GET['use_sale']; ?>">
            <input class="form-control" type="hidden" name="tb_customerId" value="<?= $_GET['use_customer']; ?>">
        </div>
    </form>
</td>
</tr>
<?php
    $cumul_HT = $cumul_HT + (($lineSale['quantite'] * $lineSale['prix']));
    $cumul_TTC = $cumul_TTC + ((1 + ($lineSale['tauxTVA'] / 100)) * ($lineSale['quantite'] * $lineSale['prix']));
    }

}
?>
<tfoot>
<td> Total HT : <strong><?= $cumul_HT; ?> USD</strong></td>
<td> Total TTC : <strong><?= $cumul_TTC; ?> USD</strong></td>
</tfoot>
    
</table>
</fieldset>