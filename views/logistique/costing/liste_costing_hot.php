<fieldset>
    <legend>Coûts supp.</legend>
    <table class="table table-dark table-striped">
        <thead class="thead-light">
            <tr>
                <th>Date</th>
                <th>Coût supp.</th>
                <th>Quantité</th>
                <th>Prix</th>
                <th>Valeur</th>
                <th>...</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $c = 0;
            $cumul_costing = 0;
            $bdCosting = new BdCosting();
            $costings = $bdCosting->getCostingByRavitaillementId($_GET['use_ravitaillement']);
            foreach ($costings as $costing) {
                $c++;
            ?>
                <tr>
                    <td><?= $costing['dateSet'] ?></td>
                    <td><?= $costing['designation'] ?></td>
                    <td><?= $costing['quantite'] ?></td>
                    <td><?= $costing['prix'] ?> USD</td>
                    <td> <strong><?= ($costing['quantite'] * $costing['prix']) ?> USD</strong></td>
                    <td>
                        <form class="form-horizontal" method="post" action="../contollers/costing/costingController.php">
                            <input type="hidden" name="tb_idcosting" value="<?= $costing['id'] ?>">
                            <input type="hidden" name="tb_quantite" value="<?= $costing['quantite'] ?>">
                            <input type="hidden" name="tb_prix" value="<?= $costing['prix'] ?>">
                            <input type="hidden" name="tb_idravitaillement" value="<?= $_GET['use_ravitaillement'] ?>">
                            <button type="submit" class="btn btn-danger" name="bt_delete"><span class="fa fa-trash-o"></span> Delete</button>
                        </form>
                    </td>
                </tr>
            <?php
                $cumul_costing = $cumul_costing + ($costing['quantite'] * $costing['prix']);
            }
            ?>

        </tbody>
        <tfoot>
            <tr>
                <th><strong> # : <?= $c  ?></strong></th>
                <th><strong style="color: forestgreen;"> Valeur Total : <?= $cumul_costing  ?> USD</strong></th>
            </tr>
        </tfoot>
    </table>
</fieldset>