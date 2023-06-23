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
        Etat
    </th>
    <th>
        Biens/produits
    </th>
    <th>
        Gestion
    </th>
    <th>
        Fournisseur
    </th>
    <th>
        Quantité
    </th>
    <th>
        Délai de livraison
    </th>
</thead>
<tbody>
    <?php
    $n = 0;
    $bdattributionbiens = new BdAttributionBiens();
    $attributions = $bdattributionbiens->getAttributionBiensByIdBiensEncours($_GET['use']);
    foreach ($attributions as $attribution) {
        $n++;
        ?>
        <tr>
            <td><?= $attribution['aId'] ?></td>
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
            <td><?= $attribution['technique_gestion'] ?></td>
            <td><?= $attribution['fDesignation'] . " : " . $attribution['domaine'] ?></td>
            <td><?= $attribution['quantite_minimale'] ?></td>
            <td><?= $attribution['delai_livraison'] ?></td>
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
