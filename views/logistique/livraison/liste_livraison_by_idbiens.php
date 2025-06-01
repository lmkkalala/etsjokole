<?php
include '../models/crud/db.php';
$db = new DB();

?>
<table id="listdatabyid" class="table table-bordered table-responsive-lg">
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
            Quantité Livré
        </th>
         <th>
            Recuperation
        </th>
        <th>
            Reste Reception
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
            $n++;
            $Recuparation = $db->getWhere('recuperation','command_id',''.$livraison['lId'].'');
            $numberRecup = 0;
            foreach ($Recuparation as $value) {
                $numberRecup = $numberRecup + $value['quantite_recuperer'];
            }

            ?>
            <tr>
                <td><?= $livraison['lId'] ?></td>
                <td><?= $livraison['lDate'] ?></td>
                <td><?= $livraison['dId'] ?> . <?= $livraison['date'] . " / " . $livraison['bDesignation'] . " / " . $livraison['gDesignation'] . " pour " . $livraison['nom'] . " " . $livraison['postnom'] . " " . $livraison['prenom'] . " : " . $livraison['sDesignation'] . " / quantité : " . $livraison['dQuantite'] ?></td>
                
                <td><?= $livraison['lQuantite'] ?></td>
                <td><?= $numberRecup ?></td>
                <td><?= $livraison['dQuantite'] - $numberRecup ?></td>
                <td><?= $livraison['lNom'] . " " . $livraison['lPostnom'] . " " . $livraison['lPrenom'] ?></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td><span><?= $n ?></span></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tfoot>
</table>