<table class="table table-bordered table-striped">

    <thead>

        <th>

            Code

        </th>

        <th>

            Item

        </th>

        <th>

            Prix acquisition

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
        if (!isset($_GET['use_unite'])) {
            $unites = $bdunite->getUniteAllLimit('1000');
        }else{
            $unites = $bdunite->getUniteById($_GET['use_unite']);
        }
        $count = 0;
        foreach ($unites as $unite) {

            if ($count <= 100) {

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

                        $prix_unitaire = $ravitaillement['prix'];

                    }



                    ?>

                    <td>

                        <?= $unite['valueActuelle'] . " USD" ?>

                    </td>

                    <td>

                        <?= $date_acquisition ?>

                    </td>



                </tr>

        <?php

                $prix_unitaire = $unite['valueActuelle'];
                    $count++;
            }

        }

        ?>

    </tbody>

    <tfoot>

        <tr>

        </tr>

    </tfoot>

</table>