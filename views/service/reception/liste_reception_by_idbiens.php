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
        Demande
    </th>
    <th>
        Quantité
    </th>
    <th>
        Livreur
    </th>
</thead>
<tbody>
    <?php
    $n = 0;
    $bdlivraison = new BdLivraison();
    $livraisons = $bdlivraison->getLivraisonAllDescByIdBiens($_GET['use']);
    foreach ($livraisons as $livraison) {
        if ($livraison['dIdmutation'] == $_SESSION['idaffectation']) {
            $n++;
            ?>
            <tr>
                <td><?= $livraison['lId'] ?></td>
                <td><?= $livraison['lDate'] ?></td>
                <td><?= $livraison['dId'] ?> . <?= $livraison['date'] . " / " . $livraison['bDesignation'] . " / " . $livraison['gDesignation'] . " pour " . $livraison['nom'] . " " . $livraison['postnom'] . " " . $livraison['prenom'] . " : " . $livraison['sDesignation'] . " / quantité : " . $livraison['dQuantite'] ?></td>
                <td><?= $livraison['lQuantite'] ?></td>
                
                <td><?= $livraison['lNom'] . " " . $livraison['lPostnom'] . " " . $livraison['lPrenom'] ?></td>
            </tr>
            <?php
        }
    }
    ?>
</tbody>
<tfoot>
<td style="font-size: 20px;">
    <span>Nombre:</span><span><?= $n ?></span>
</td>
</tfoot>
</table>

