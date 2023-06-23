<table class="table table-bordered table-striped">
    <thead>
        <th>
            Date
        </th>
        <th>
            Item ordered
        </th>
        <th>
            Qty.
        </th>
        <th>
            Unit Price
        </th>
        <th>
            Value
        </th>
        <th>
            % TVA
        </th>
        <th>
            Value TVA
        </th>
        <th>
            Exp. Date
        </th>
        <th>
            Costing
        </th>
    </thead>
    <tbody>
        <?php
        $cumul_total_fournisseur = 0;
        $cumul_TVA_fournisseur = 0;
        $n = 0;
        $BdRavitaillement = new BdRavitaillement();
        $ravitaillements = $BdRavitaillement->getRavitaillementByIdSecond($_GET['use_ravitaillement']);
        foreach ($ravitaillements as $ravitaillement) {
            if (1) {
                $n++;
                $chaine_part_ravitaillement_sortie = "";
                $chaine_part_ravitaillement_reste = "";
        ?>
                <tr>
                    <td><?= $ravitaillement['date'] ?></td>
                    <td>
                        <?php
                        $date_ravitaillement = $ravitaillement['date'];
                        $bdattributionbiens = new BdAttributionBiens();
                        $attributions = $bdattributionbiens->getAttributionBiensById($ravitaillement['attribution_id']);
                        foreach ($attributions as $attribution) {
                        ?>
                            <?= $attribution['aId'] ?> . <?= $attribution['date'] . " / " . $attribution['bDesignation'] . " à " . $attribution['fDesignation'] . " pour " . $attribution['delai_livraison'] . " jour(s) / quantité : " . $attribution['quantite_minimale'] ?>
                        <?php
                            $id_attributionbiens = $attribution['aId'];
                            $quantite_biens = $attribution['quantite'];
                        }
                        ?>
                    </td>
                    <td><?= $ravitaillement['quantite'] ?></td>

                    <?php
                    $bdunite = new BdUnite();
                    $unites = $bdunite->getUniteByName("-" . $id_attributionbiens . "-");
                    foreach ($unites as $unite) {
                        if (($unite['active'] == 0) && ($unite['active_principal'] == 1)) {
                            $part_code = explode('-', $unite['code']);
                            if ((strlen($part_code[1])) == 1) {
                                $chaine_part_ravitaillement_sortie = $chaine_part_ravitaillement_sortie . $part_code[1] . "-";
                            }
                        }
                    }
                    foreach ($unites as $unite) {
                        if (($unite['active'] == 1) && ($unite['active_principal'] == 1)) {
                            $part_code = explode('-', $unite['code']);
                            if ((strlen($part_code[1])) == 1) {
                                $chaine_part_ravitaillement_reste = $chaine_part_ravitaillement_reste . $part_code[1] . "-";
                            }
                        }
                    }
                    ?>

                    <td><?= $ravitaillement['prix'] . " USD" ?></td>
                    <td style="color: green; font-weight: bold;"><?= ($ravitaillement['quantite'] * $ravitaillement['prix']) . " USD" ?></td>
                    <td>
                        <?= $ravitaillement['pourcentageTVA'] ?>
                    </td>
                    <td>
                        <?php
                        echo (($ravitaillement['pourcentageTVA'] / 100) * ($ravitaillement['quantite'] * $ravitaillement['prix'])) . " USD";
                        $cumul_TVA_fournisseur = $cumul_TVA_fournisseur + (($ravitaillement['pourcentageTVA'] / 100) * ($ravitaillement['quantite'] * $ravitaillement['prix']));
                        ?>
                    </td>
                    <td><?= $ravitaillement['dateExpiration'] ?></td>
                    <td>
                        <strong style="color: forestgreen;">
                            <?php
                            $cumul_costing = 0;
                            $bdCosting = new BdCosting();
                            $costings = $bdCosting->getCostingByRavitaillementId($ravitaillement['id']);
                            foreach ($costings as $costing) {
                                $cumul_costing = $cumul_costing + ($costing['quantite'] * $costing['prix']);
                            }
                            echo $cumul_costing . " USD"
                            ?>
                        </strong>
                    </td>
                    <?php
                    if (1) {
                    ?>

                    <?php
                    }
                    ?>

                </tr>
        <?php
                $cumul_total_fournisseur = $cumul_total_fournisseur + ($ravitaillement['quantite'] * $ravitaillement['prix']);
            }
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td style="color: red; font-weight: bold;">Order value : <?= $cumul_total_fournisseur ?> USD </td>
            <td style="color: dodgerblue; font-weight: bold;">Value TVA : <?= $cumul_TVA_fournisseur ?> USD </td>
            <td style="color: orange; font-weight: bold;">Total + TVA : <?= ($cumul_total_fournisseur + $cumul_TVA_fournisseur) ?> USD </td>
            <td style="color: forestgreen; font-weight: bold;">Cost adds-in value : <?= ($cumul_costing) ?> USD </td>
            <td style="color: #b00058; font-weight: bold;">Grand total : <?= (($cumul_total_fournisseur + $cumul_TVA_fournisseur)+($cumul_costing)) ?> USD </td>
        </tr>
    </tfoot>
</table>