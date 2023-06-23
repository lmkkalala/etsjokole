<fieldset>

    <legend>Configurations</legend>

    <table class="table table-dark table-striped">

        <thead class="thead-light">

            <tr>

                <th>Date Set</th>

                <th>Date debut</th>

                <th>Prix acquisition (USD)</th>

                <th>Time</th>

                <th>...</th>

                <th>...</th>

            </tr>

        </thead>

        <tbody>

            <?php

            $c = 0;

            $cumul_costing = 0;

            $bdAmortissement = new BdAmortissement();

            if (!isset($_GET['use_unite'])) {
                $amortissements = $bdAmortissement->getAmortissementAll();
            }else{
                $amortissements = $bdAmortissement->getAmortissementByUniteId($_GET['use_unite']);
            }

           

            foreach ($amortissements as $amortissement) {
                $c++;
            ?>

                <tr>

                    <td><?= $amortissement['dateSet'] ?></td>

                    <td><?= $amortissement['dateDebut'] ?></td>

                    <td><?= $amortissement['prixAcquisition'] ?></td>

                    <td><?= $amortissement['duree'] ?> years</td>

                    <td>

                        <form class="form-horizontal" method="post" action="../contollers/amortissement/amortissementController.php">

                            <input type="hidden" name="tb_idamortissement" value="<?= $amortissement['id'] ?>">

                            <input type="hidden" name="tb_idunite" value="<?= $_GET['use_unite'] ?>">

                            <button type="submit" class="btn btn-danger" name="bt_delete"><span class="fa fa-trash-o"></span> Delete</button>

                        </form>

                    </td>

                    <td>

                        <form class="form-horizontal" method="post" action="../contollers/amortissement/amortissementController.php">

                            <input type="hidden" name="tb_idamortissement" value="<?= $amortissement['id'] ?>">

                            <input type="hidden" name="tb_idunite" value="<?= $_GET['use_unite'] ?>">

                            <button type="submit" class="btn btn-primary" name="bt_for_dotation"><span class="fa fa-bars"></span> Ajouter une dotation</button>

                        </form>

                    </td>

                </tr>

            <?php



            }

            ?>



        </tbody>

        <tfoot>

            <tr>

                <th><strong> # : <?= $c  ?></strong></th>



            </tr>

        </tfoot>

    </table>

</fieldset>