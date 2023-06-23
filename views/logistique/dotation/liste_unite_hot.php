<table class="table table-bordered table-striped">
    <thead>
        <th>
            Code
        </th>
        <th>
            Item
        </th>
        <th>
            Valeur actuelle
        </th>
        <th>
            Date acquisition
        </th>
    </thead>
    <tbody>
        <?php
        $cumul_total_fournisseur = 0;
        $cumul_TVA_fournisseur = 0;
        $n = 0;
        $bdunite = new BdUnite();
        $unites = $bdunite->getUniteById($_GET['use_unite']);
        foreach ($unites as $unite) {
            if (1) {
                $n++;
                $chaine_part_ravitaillement_sortie = "";
                $chaine_part_ravitaillement_reste = "";
        ?>
                <tr>
                    <td><?= $unite['code'] ?></td>
                    <td>
                        <?php
                        $items_code = explode('-', $unite['code']);

                        $bdattributionbiens = new BdAttributionBiens();
                        $attributions = $bdattributionbiens->getAttributionBiensById($items_code[1]);
                        foreach ($attributions as $attribution) {
                        ?>
                            <?= $attribution['bDesignation'] ?>
                        <?php
                            $id_attributionbiens = $attribution['aId'];
                            $quantite_biens = $attribution['quantite'];
                        }
                        ?>
                    </td>

                    <?php
                    $bdravitaillement = new BdRavitaillement();
                    $ravitaillements = $bdravitaillement->getRavitaillementByIdAttributionBiens($id_attributionbiens);
                    foreach ($ravitaillements as $ravitaillement) {
                        $date_acquisition = $ravitaillement['date'];
                        $prix_unitaire = $unite['valueActuelle'];
                    }
                    
                    ?>
                    <td>
                        <strong style="color: forestgreen;"><?= $prix_unitaire." USD" ?></strong>
                    </td>
                    <td>
                        <?= $date_acquisition ?>
                    </td>

                </tr>
        <?php

            }
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
        </tr>
    </tfoot>
</table>