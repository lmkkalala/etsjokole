<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<fieldset>
    <legend>Liste des biens/produits</legend>
    <table class="table table-bordered table-responsive-lg">
        <thead>
        <th>
            N°
        </th>
        <th>
            Catégorie
        </th>
        <th>
            Désignation
        </th>
        <th>
            Marque
        </th>
        <th>
            Périssable
        </th>          
        <th>
            Sélectionner
        </th>
        </thead>
        <tbody>
            <?php
            $n = 0;
            $bdbiens = new BdBiens();
            $biens = $bdbiens->getBiensByNameActive($_GET['use']);
            foreach ($biens as $bien) {
                $n++;
                ?>
                <tr>
                    <td><?= $bien['bId'] ?></td>
                    <td><?= $bien['gDesignation'] ?></td>
                    <td><?= $bien['bDesignation'] ?></td>
                    <td><?= $bien['marque'] ?></td>
                    <td>
                        <b>
                            <?php
                            if ($bien['type_perissable']) {
                                echo 'Oui';
                            } else {
                                echo 'Non';
                            }
                            ?>
                        </b>
                    </td>
                    <td>
                        <form method="POST" action="../contollers/acceuil-service/acceuilServiceController.php">
                            <input type="hidden" name="tb_idbiens" value="<?= $bien['bId'] ?>">
                            <button type="submit" class="btn btn-danger" name="bt_view_for_biens"><span class="fa fa-send-o" style="color: white; font-size: 15px;margin-right: 5px;"></span></button>
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
</fieldset>

