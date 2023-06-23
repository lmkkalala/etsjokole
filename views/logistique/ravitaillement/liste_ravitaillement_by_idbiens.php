<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
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
        Commande
    </th>
    <th>
        Quantité
    </th>
    <th>
        Prix unitaire
    </th>
    <th>
        Prix total
    </th>
    <th>
        Délai réalisé (en jour)
    </th>
    <th>
        Date d'expiration
    </th>
    <th>
        Type
    </th>
</thead>
<tbody>
    <?php
    $n = 0;
    $bdravitaillement = new BdRavitaillement();
    $ravitaillements = $bdravitaillement->getRavitaillementAllDesc();
    foreach ($ravitaillements as $ravitaillement) {
        ?>
        <tr>
            <?php
            $bdattributionbiens = new BdAttributionBiens();
            $attributions = $bdattributionbiens->getAttributionBiensById($ravitaillement['attribution_id']);
            foreach ($attributions as $attribution) {
                if ($attribution['bId'] == $_GET['use']) {
                    $n++;
                    ?>
                    <td><?= $ravitaillement['id'] ?></td>
                    <td><?= $ravitaillement['date'] ?></td>
                    <td>
                        <?php
                        $bdattributionbiens = new BdAttributionBiens();
                        $attributions = $bdattributionbiens->getAttributionBiensById($ravitaillement['attribution_id']);
                        foreach ($attributions as $attribution) {
                            ?>
                            <?= $attribution['aId'] ?> . <?= $attribution['date'] . " / " . $attribution['bDesignation'] . " à " . $attribution['fDesignation'] . " pour " . $attribution['delai_livraison'] . " jour(s) / quantité : " . $attribution['quantite_minimale'] ?>
                            <?php
                        }
                        ?>
                    </td>
                    <td><?= $ravitaillement['quantite'] ?></td>
                    <td><?= $ravitaillement['prix'] ?></td>
                    <td><?= $ravitaillement['quantite'] * $ravitaillement['prix'] ?></td>
                    <td><?= $ravitaillement['delai_realise'] ?></td>
                    <td><?= $ravitaillement['dateExpiration'] ?></td>
                    <td><?= $ravitaillement['type'] ?></td>
                    <?php
                }
            }
            ?>
        </tr>
        <?php
    }
    ?>
</tbody>
<tfoot>
<td style="font-size: 20px;">
    <span>Nombre:</span><span><?= $n ?></span>
</td>
</tfoot>
</table>