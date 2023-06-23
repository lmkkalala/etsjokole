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
        Sélectionner
    </th>
</thead>
<tbody>
    <?php
    $paniers = explode("/", $panier_livraison);
    $n = 0;
    $bdunite = new BdUnite();
    $unites = $bdunite->getUniteByIdBiens($idbiens);
    foreach ($unites as $unite) {
        foreach ($paniers as $pan) {
            if (($pan != "") && ($pan == $unite['id']) && ($unite['active_distribution'])) {
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
                        <div  class="input-group-lg">
                            <input type="checkbox" class="checkbox"
                            <?php
                            if ($n <= $quantite_choosen_distribution) {
                                echo ' ' . 'checked' . ' ';
                            }
                            ?> 
                                   name="<?= "chk_" . $unite['id'] ?>" value="<?= $unite['id'] ?>">
                        </div>
                    </td>
                </tr>
                <?php
            }
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