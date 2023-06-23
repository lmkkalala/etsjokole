<fieldset>
    <legend>Configurations</legend>
    <table class="table table-dark table-striped">
        <thead class="thead-light">
            <tr>
                <th>Date Set</th>
                <th>Date debut utilisation</th>
                <th>Prix acquisition (USD)</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $c = 0;
            $amortissementId = "";
            $prixAcquisition = "";
            $dateDebut = "";
            $duree = "";
            $cumul_costing = 0;
            $bdAmortissement = new BdAmortissement();
            $amortissements = $bdAmortissement->getAmortissementByUniteId($_GET['use_unite']);
            foreach ($amortissements as $amortissement) {
                $c++;
                $amortissementId = $amortissement['id'];
                $prixAcquisition = $amortissement['prixAcquisition'];
                $dateDebut = $amortissement['dateDebut'];
                $duree = $amortissement['duree'];
            ?>
                <tr>
                    <td><?= $amortissement['dateSet'] ?></td>
                    <td><?= $amortissement['dateDebut'] ?></td>
                    <td><?= $amortissement['prixAcquisition'] ?></td>
                    <td><?= $amortissement['duree'] ?> years</td>
                    
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