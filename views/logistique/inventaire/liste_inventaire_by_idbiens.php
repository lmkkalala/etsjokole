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
        N°
    </th>
    <th>
        Date
    </th>
    <th>
        Biens/produit
    </th>
    <th>
        Quantité virtuelle
    </th>
    <th>
        Quantité physique
    </th>
    <th>
        Ecart
    </th>
    <th>
        Réalisé par
    </th>
    <th>
        Commentaire
    </th>
    <th>
        Operation
    </th>
</thead>
<tbody>
    <?php
    $n = 0;
    $bdinventaire = new BdInventaire();
    $inventaires = $bdinventaire->getInventaireAllDesc();
    foreach ($inventaires as $inventaire) {
        if (1) {
            $n++;
            ?>
            <tr>
                <td><?= $n ?></td>
                <td><?= $inventaire['iDate'] ?></td>
                <td><?= $inventaire['bDesignation'] . " / " . $inventaire['gDesignation'] . " / Marque : " . $inventaire['marque'] ?></td>
                <td><?= $inventaire['quantite'] ?></td>
                <td><?= $inventaire['iQuantite'] ?></td>
                <td>
                    <?php
                    if ($inventaire['iEcart'] < 0) {
                        ?>
                        <h4 style="color: red;"><?= $inventaire['iEcart'] ?> </h4>
                        <?php
                    } else {
                        ?>
                        <h4 style="color: forestgreen;"><?= $inventaire['iEcart'] ?> </h4>
                        <?php
                    }
                    ?>
                </td>
                <td><?= $inventaire['nom'] . " " . $inventaire['postnom'] . " " . $inventaire['prenom'] ?></td>
                <td><?= $inventaire['commentaire'] ?></td>
                <td>
                    <?php
                    if ($inventaire['validation'] == 0) {
                        ?>
                        <form method="POST" action="../contollers/inventaire/inventaireController.php">
                            <input type="hidden" name="tb_idbiens" value="<?= $inventaire['bId'] ?>">
                            <input type="hidden" name="tb_idinventaire" value="<?= $inventaire['iId'] ?>">
                            <input type="hidden" name="tb_quantite_reelle" value="<?= $inventaire['iQuantite'] ?>">
                            <button type="submit" class="btn btn-primary" name="bt_valide_inventaire"><span class="fa fa-check" style="color: white; font-size: 15px;margin-right: 5px;"></span></button>
                        </form>
                        <?php
                    } else {
                        ?>
                        <p style="font-weight: bold; color: forestgreen;">Equalized</p>
                        <?php
                    }
                    ?>

                </td>
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