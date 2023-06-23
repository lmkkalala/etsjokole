<div class="form-group-lg" style="background-color: #d3d3d3; padding: 5px; color: whitesmoke;">

    <table class="table table-striped">
        <thead class="">
            <tr>
                <th>Year</th>
                <th>Number of days</th>
                <th>Amount</th>
                <th>...</th>
                <th>...</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $items_dateDebut = explode('-', $dateDebut);
            $dateFin = ($items_dateDebut[0] + $duree) . "-" . $items_dateDebut[1] . "-" . ($items_dateDebut[2]);
            $ecart = 0;
            // echo $dateDebut;
            $last_date = $dateDebut;
            $cumul_dotation = 0;
            // echo $duree;
            for ($i = 0; $i < $duree + 1; $i++) {

                if ((0) || ($i == ($duree))) {

                    // echo "\n";
                    $date1 = strtotime($last_date);
                    $date2 = strtotime(($items_dateDebut[0] + $i) . "-" . ($items_dateDebut[1]) . "-" . ($items_dateDebut[2]));
                    $ecart = abs($date1 - $date2);
                    // echo ($items_dateDebut[0] + $i) . "-" . ($items_dateDebut[1]) . "-" . ($items_dateDebut[2]);
                    $last_date = ($items_dateDebut[0] + $i) . "-" . ($items_dateDebut[1]) . "-" . ($items_dateDebut[2]);
                    // echo "\n";
                    // echo ("***" . ($ecart / 3600 / 24) . "***");
                    $valueur_temps = ($ecart / 3600 / 24);
                } else {
                    if (1) {
                        // echo "\n";
                        $date1 = strtotime($last_date);
                        $date2 = strtotime(($items_dateDebut[0] + $i) . "-" . (12) . "-" . (31));
                        $ecart = abs($date1 - $date2);
                        // echo ($items_dateDebut[0] + $i) . "-" . (12) . "-" . (31);
                        $last_date = ($items_dateDebut[0] + $i) . "-" . (12) . "-" . (31);
                        // echo "\n";
                        $valueur_temps = ($ecart / 3600 / 24);
                    }
                }
                $d = 0;
                $bdDotation = new BdDotation();
                $dotations = $bdDotation->getDotationByAmortissementIdByAnnee($amortissementId, $items_dateDebut[0] + $i);
                foreach ($dotations as $dotation) {
                    $d++;
                }


            ?>
                <tr>
                    <td>
                        <?= ($items_dateDebut[0] + $i) . " : Year " . ($i) ?>
                    </td>
                    <td>
                        <?= round($valueur_temps) ?>
                    </td>
                    <td>
                        <?php
                        $cumul_dotation = $cumul_dotation + (($prixAcquisition * ((100 / $duree) / 100) * (((round($valueur_temps)) / 365))));
                        $dotation_amount = round(($prixAcquisition * ((100 / $duree) / 100) * (((round($valueur_temps)) / 365))), 2);
                        echo $dotation_amount . " USD";
                        ?>
                    </td>
                    <td>

                        <?php
                        if ($d == 0) {
                        ?>
                            <form class="form-horizontal" method="POST" action="../contollers/dotation/dotationController.php">
                                <div class="input-group-lg">
                                    <input type="hidden" name="tb_idamortissement" value="<?= $amortissementId ?>">
                                    <input type="hidden" name="tb_montant" value="<?= $dotation_amount ?>">
                                    <input type="hidden" name="tb_annee" value="<?= $items_dateDebut[0] + $i ?>">
                                    <input type="hidden" name="tb_idunite" value="<?= $_GET['use_unite'] ?>">
                                    <input class="btn btn-success" type="submit" name="bt_enregistrer" value="Apply">
                                </div>
                            </form>
                        <?php
                        } else {
                            ?>
                            <form class="form-horizontal" method="POST" action="../contollers/dotation/dotationController.php">
                                <div class="input-group-lg">
                                    <input type="hidden" name="tb_idamortissement" value="<?= $amortissementId ?>">
                                    <input type="hidden" name="tb_annee" value="<?= $items_dateDebut[0] + $i ?>">
                                    <input type="hidden" name="tb_montant" value="<?= $dotation_amount ?>">
                                    <input type="hidden" name="tb_idunite" value="<?= $_GET['use_unite'] ?>">
                                    <button class="btn btn-info" type="submit" name="bt_delete"><i class="fa fa-refresh" aria-hidden="true"></i></button>
                                </div>
                            </form>
                        <?php
                        }
                        ?>
                        
                    </td>
                </tr>
            <?php
            }
            // date_diff();
            ?>

        </tbody>
        <tfoot>
            <tr>
                <th><?= ("Total dotation : ") . round($cumul_dotation, 2) . " USD" ?></th>
                <?php
                $cumul_dotation_realisee=0;
                $bdDotation = new BdDotation();
                $dotations = $bdDotation->getDotationByAmortissementId($amortissementId);
                foreach ($dotations as $dotation) {
                    $cumul_dotation_realisee=$cumul_dotation_realisee+$dotation['montant'];
                }

                ?>
                <th style="color: dodgerblue;"><?= ("Total enregistré : ") . ($cumul_dotation_realisee) . " USD" ?></th>
                <th style="color: #ff0080;"><?= ("Valeur restante : ") . ($prixAcquisition-$cumul_dotation_realisee)." USD"?></th>
            </tr>
        </tfoot>
    </table>
</div>