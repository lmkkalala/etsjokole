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
            Code
        </th>
        <th>
            Biens
        </th>
        <th>
            Date achat
        </th>
        <th>
            Date expiration
        </th>
        <th>
            Etat
        </th>
        <th>
            Op.
        </th>
    </thead>
    <tbody>
        <?php
        $n = 0;
        $bdunite = new BdUnite();
        $unites = $bdunite->getUniteByIdBiens($_GET['use']);
        foreach ($unites as $unite) {
            $n++;
            $bdbiens = new BdBiens();
            $biens = $bdbiens->getBiensById($unite['biens_id']);
            foreach ($biens as $bien) {
                $info_biens = $bien['bDesignation'] . " / " . $bien['gDesignation'] . " / Marque : " . $bien['marque'];
            }
        ?>
            <tr>
                <td><?= $unite['id'] ?></td>
                <td><?= $unite['code'] ?></td>
                <td><?= $info_biens ?></td>
                <td><?= $unite['date_achat'] ?></td>
                <td><?= $unite['date_expiration'] ?></td>
                <td>
                    <?php
                    if ($unite['active'] == 1) {
                    ?>
                        <h4 style="color: forestgreen;">Actif</h4>
                    <?php
                    } else {
                    ?>
                        <h4 style="color: red;">Inactif</h4>
                    <?php
                    }
                    ?>
                </td>
                <td>
                    <form action="../contollers/amortissement/amortissementController.php" method="post">
                        <input type="hidden" name="tb_idunite" value="<?= $unite['id'] ?>">
                        <button class="btn btn-success" type="submit" name="bt_for_amortissement"><i class="fa fa-bars" aria-hidden="true"></i> Amortissement</button>
                    </form>
                </td>
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