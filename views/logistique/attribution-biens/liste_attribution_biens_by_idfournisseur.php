<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<table class="table table-bordered table-responsive-lg table-striped">
    <thead>
    <th>
        #
    </th>
    <th>
        Date
    </th>
    <th>
        Status
    </th>
    <th>
        Item
    </th>
    <th>
        Quantity
    </th>
    <th>
        Unit price
    </th>
    <th>
        Value
    </th>
    <th>
        Order number
    </th>
</thead>
<tbody>
    <?php
    $n = 0;
    $bdattributionbiens = new BdAttributionBiens();
    if (((isset($_GET['use_date1'])) && (isset($_GET['use_date2']))) && ((($_GET['use_date1']) != "") && (($_GET['use_date2']) != ""))) {
        $attributions = $bdattributionbiens->getAttributionBiensByIdFournisseurByDate($_GET['use'], $_GET['use_date1'], $_GET['use_date2']);
    } else if ((isset ($_GET['use_numeroOrder'])) && ($_GET['use_numeroOrder']!="none")) {
        $attributions = $bdattributionbiens->getAttributionBiensByNumeroOrder($_GET['use_numeroOrder']);
    } else {
        $attributions = $bdattributionbiens->getAttributionBiensByIdFournisseur($_GET['use']);
    }
    $cumul_value = 0;
    foreach ($attributions as $attribution) {
        $n++;
        ?>
        <tr>
            <td><?= $attribution['numeroOrder'] ?></td>
            <td><?= $attribution['date'] ?></td>
            <td>
                <b>
                    <?php
                    if ($attribution['etat']) {
                        echo 'Finalisée';
                    } else {
                        echo 'En cours';
                    }
                    ?>
                </b>
            </td>
            <td><?= $attribution['bDesignation'] . " : " . $attribution['gDesignation'] ?></td>
            <td><?= $attribution['quantite_minimale'] ?></td>
            <td><?= $attribution['aPrixUnitaire'] ?></td>
            <td>
                <?php
                echo ($attribution['quantite_minimale'] * $attribution['aPrixUnitaire']);
                $cumul_value = $cumul_value + ($attribution['quantite_minimale'] * $attribution['aPrixUnitaire']);
                ?>
            </td>
            <td><?= $attribution['aPrixUnitaire'] ?></td>
            <td><?= $attribution['numeroOrder'] ?></td>
        </tr>
        <?php
    }
    ?>
</tbody>
<tfoot>
<td style="font-weight: bold;">
    <span>Nbre : </span><span><?= $n ?></span>
</td>
<td style="font-weight: bold; color: orange;">
    <span>Total value : </span><span><?= $cumul_value ?></span>
</td>
</tfoot>
</table>
