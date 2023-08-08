<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/ravitaillement/ravitaillement.php';
include '../models/attribution-biens/attributionBiens.php';
include '../models/unite/unite.php';
include '../models/biens/biens.php';
include '../models/fournisseur/fournisseur.php';
include '../models/costing/Costing.php';

?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-cubes" style="color: darkorange; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-plus-square-o" style="color: darkorange; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Entrée</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-list-ol" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Toutes</span>
    </div>
    <?php
    if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("succes_edited")))) {
    ?>
        <div class="alert alert-success">
            <span class="glyphicon glyphicon-ok" style="font-size: 15px;margin-right: 5px;"></span><span>Success edited</span>
        </div>
    <?php
    }
    ?>
    <?php
    if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("succes_deleted")))) {
    ?>
        <div class="alert alert-success">
            <span class="glyphicon glyphicon-ok" style="font-size: 15px;margin-right: 5px;"></span><span>Success edited</span>
        </div>
    <?php
    }
    ?>
    <?php
    if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("traitement_error")))) {
    ?>
        <div class="alert alert-danger">
            <span class="glyphicon glyphicon-ban-circle" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur d'enregistrement</span>
        </div>
    <?php
    }
    ?>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Recherche par date :</legend>
                <form class="form-inline" method="POST" action="../contollers/ravitaillement/ravitaillementController.php">
                    <div class="row form-group-lg">
                        <div class="col-6 mt-1">
                            <input type="date" class="form-control mt-2" name="tb_date1">
                        </div>
                        <div class="col-6 mt-1">
                            <input type="date" class="form-control mt-2" name="tb_date2">
                        </div>
                        <div class="col-6 mt-1">
                        <select class="form-control select2" name="cb_biens">
                            <option value="0">Choisir un item</option>
                            <?php
                            $bdbiens = new BdBiens();
                            $biens = $bdbiens->getBiensAllDesc();
                            foreach ($biens as $bien) {
                                if (1) {
                                    if (1) {
                            ?>
                                        <option value="<?= $bien['bId'] ?>"><?= $bien['bDesignation'] . " / Marque : " . $bien['marque'] . " / " . $bien['gDesignation'] ?></option>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                        </div>
                        <div class="col-6 mt-1">
                        <select class="form-control select2" name="cb_fournisseur">
                            <option value="0">Choisir un fourn.</option>
                            <?php
                            $bdfournisseur = new BdFournisseur();
                            $fournisseurs = $bdfournisseur->getFournisseurAllDesc();
                            foreach ($fournisseurs as $fournisseur) {
                                if ($fournisseur['active']) {
                                    if (1) {
                            ?>
                                        <option value="<?= $fournisseur['id'] ?>"><?= $fournisseur['designation'] ?></option>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                        </div>
                        <div class="col-6 mt-1">
                        <select class="form-control select2" name="cb_numeroOrder">
                            <option value="none">Choisir Num. Commande</option>
                            <?php
                            $bdattributionbiens = new BdAttributionBiens();
                            $attributions = $bdattributionbiens->getAttributionBiensDistinctNumeroOrder();
                            foreach ($attributions as $attribution) {
                            ?>
                                <option value="<?= $attribution['numero_order'] ?>"><?= $attribution['numero_order'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        </div>
                        <div class="col-6 mt-1">
                            <button type="submit" class="btn btn-success" name="bt_search_by_2dates"><span class="glyphicon glyphicon-search" style="color: white; font-size: 20px;margin-right: 5px;"></span> Rechercher</button>
                        </div>
                    </div>
                </form>
            </fieldset>
            <fieldset>
                <legend style="color: orange; font-weight: bold;">
                    <?php
                    if ((isset($_GET['use_date1'])) && ($_GET['use_date1'] != "")) {
                        echo "Date : " . ($_GET['use_date1']) . " to ";
                    }
                    if ((isset($_GET['use_date2'])) && ($_GET['use_date2'] != "")) {
                        echo "" . ($_GET['use_date2']);
                    }
                    if ((isset($_GET['use_biens'])) && ($_GET['use_biens'] != 0)) {
                        $bdbiens = new BdBiens();
                        $biens = $bdbiens->getBiensById($_GET['use_biens']);
                        foreach ($biens as $bien) {
                            echo " - Produit : " . ($bien['bDesignation']) . " Marque : " . ($bien['marque']) . " / " . ($bien['gDesignation']);
                        }
                    }

                    if ((isset($_GET['use_numeroOrder'])) && ($_GET['use_numeroOrder'] != "none"))
                        echo "Num. Commande : " . $_GET['use_numeroOrder'];

                    $designation_fournisseur = "";
                    $bdfournisseur = new BdFournisseur();
                    if (isset($_GET['use_fournisseur'])) {
                        $fournisseurs = $bdfournisseur->getFournisseurById($_GET['use_fournisseur']);
                    } else {
                        $fournisseurs = $bdfournisseur->getFournisseurById(0);
                    }

                    foreach ($fournisseurs as $fournisseur) {
                        $designation_fournisseur = $fournisseur['designation'];
                    }

                    if ($designation_fournisseur == "") {
                        $designation_fournisseur = "...";
                    }
                    echo " / Fournisseur : " . $designation_fournisseur;
                    ?>
                </legend>
            </fieldset>
            <fieldset>
                <?php
                if ((isset($_GET['use_date1']))) {
                ?>
                    <a style="font-size: 20px;" href='../views/logistique/ravitaillement/pdf_ravitaillement_open_simple.php?use_date1=<?= $_GET['use_date1'] . '&use_date2=' . $_GET['use_date2'] . '&use_biens=' . $_GET['use_biens'] . '&use_numeroOrder=' . $_GET['use_numeroOrder'] . '&use_fournisseur=' . $_GET['use_fournisseur'] ?>' class="btn btn-primary pull-left">Print in PDF</a>
                    <a style="font-size: 20px; margin-left: 10px;" href='../views/logistique/ravitaillement/excel_list_ravitaillement_all.php?use_date1=<?= $_GET['use_date1'] . '&use_date2=' . $_GET['use_date2'] . '&use_biens=' . $_GET['use_biens'] . '&use_numeroOrder=' . $_GET['use_numeroOrder'] . '&use_fournisseur=' . $_GET['use_fournisseur'] ?>' class="btn btn-success pull-left">Export in Excel</a>
                    <?php ?>

                    <a style="font-size: 20px; margin-left: 10px;" href='../views/logistique/ravitaillement/excel_list_ravitaillement_all_summary.php?use_date1=<?= $_GET['use_date1'] . '&use_date2=' . $_GET['use_date2'] . '&use_biens=' . $_GET['use_biens'] . '&use_numeroOrder=' . $_GET['use_numeroOrder'] . '&use_fournisseur=' . $_GET['use_fournisseur'] ?>' class="btn btn-success pull-right">Export in Excel</a>
                    <a style="font-size: 20px;" href='../views/logistique/ravitaillement/pdf_ravitaillement_open_simple_summary.php?use_date1=<?= $_GET['use_date1'] . '&use_date2=' . $_GET['use_date2'] . '&use_biens=' . $_GET['use_biens'] . '&use_numeroOrder=' . $_GET['use_numeroOrder'] . '&use_fournisseur=' . $_GET['use_fournisseur'] ?>' class="btn btn-primary pull-right">Print Summary</a>
                <?php
                } else {
                }
                ?>

            </fieldset>
            <br>
            <fieldset>
                <legend>Entrées</legend>
                <?php
                if (isset($_GET['use_date1'])) {
                ?>
                    <table class="table table-bordered table-responsive-lg table-striped table-hover">
                        <thead>
                            <th>
                                #
                            </th>
                            <th>
                                Date
                            </th>
                            <th>
                                Commande
                            </th>
                            <th>
                                Quantité
                            </th>
                            <th>
                                Valeur sortie
                            </th>
                            <th>
                                Valeur actuelle
                            </th>
                            <th>
                                Prix unitaire
                            </th>
                            <th>
                                Valeur entrée
                            </th>
                            <th>
                                Date expiration
                            </th>
                            <th>
                                % TVA
                            </th>
                            <th>
                                Valeur TVA
                            </th>
                            <th>
                                Coûts supp.
                            </th>
                        </thead>
                        <tbody>
                            <?php
                            $n = 0;
                            $cumul_total_sortie = 0;
                            $cumul_total_reste = 0;
                            $cumul_total = 0;
                            $bdravitaillement = new BdRavitaillement();
                            if ((isset($_GET['use_biens'])) && ($_GET['use_biens'] != 0)) {
                                echo $_GET['use_biens'];
                                if ((isset($_GET['use_date1'])) && ($_GET['use_date1'] != "")) {
                                    $ravitaillements = $bdravitaillement->getRavitaillementBetween2DatesByIdBiens($_GET['use_date1'], $_GET['use_date2'], $_GET['use_biens']);
                                } else {
                                    $ravitaillements = $bdravitaillement->getRavitaillementByIdBiens($_GET['use_biens']);
                                }
                            } else {
                                if ((isset($_GET['use_date1'])) && ($_GET['use_date1'] != "")) {
                                    $ravitaillements = $bdravitaillement->getRavitaillementBetween2Dates($_GET['use_date1'], $_GET['use_date2']);
                                } else {
                                    $ravitaillements = $bdravitaillement->getRavitaillementAllDesc();
                                }
                            }

                            if ((isset($_GET['use_numeroOrder'])) && ($_GET['use_numeroOrder'] != "none")) {
                                $ravitaillements = $bdravitaillement->getRavitaillementByNumeroOrder($_GET['use_numeroOrder']);
                            }

                            $bdfournisseur = new BdFournisseur();

                            if ((isset($_GET['use_fournisseur'])) && ($_GET['use_fournisseur'] != 0)) {
                                $fournisseurs = $bdfournisseur->getFournisseurById($_GET['use_fournisseur']);
                            } else {
                                $fournisseurs = $bdfournisseur->getFournisseurAllDesc();
                            }

                            if ((isset($_GET['use_numeroOrder'])) && ($_GET['use_numeroOrder'] != "none")) {
                                $bdattributionbiens = new BdAttributionBiens();
                                $attributions = $bdattributionbiens->getAttributionBiensByNumeroOrder($_GET['use_numeroOrder']);
                                foreach ($attributions as $attribution) {
                                    $id_fournisseur = $attribution['fId'];
                                }
                                $bdfournisseur = new BdFournisseur();
                                $fournisseurs = $bdfournisseur->getFournisseurById($id_fournisseur);
                            }

                            $cumul_total_all = 0;
                            $cumul_TVA_all = 0;
                            $cumul_costing_all=0;

                            foreach ($fournisseurs as $fournisseur) {
                            ?>
                                <tr style="background-color: whitesmoke;">
                                    <td style="color: forestgreen; font-weight: bold;"><?= $fournisseur['designation'] ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <?php
                                $cumul_total_fournisseur = 0;
                                $cumul_TVA_fournisseur = 0;
                                $cumul_costing_fournisseur=0;
                                foreach ($ravitaillements as $ravitaillement) {
                                    if ($ravitaillement['fournisseur_id'] == $fournisseur['id']) {
                                        $n++;
                                        $chaine_part_ravitaillement_sortie = "";
                                        $chaine_part_ravitaillement_reste = "";
                                ?>
                                        <tr>
                                            <td>
                                                <strong><?= $ravitaillement['id'] ?></strong>
                                                <hr>
                                                <form class="form-horizontal" method="post" action="../contollers/ravitaillement/ravitaillementController.php">
                                                    <input type="hidden" name="tb_date1" value="<?= $_GET['use_date1'] ?>">
                                                    <input type="hidden" name="tb_date2" value="<?= $_GET['use_date2'] ?>">
                                                    <input type="hidden" name="tb_quantite" value="<?= $ravitaillement['quantite'] ?>">
                                                    <input type="hidden" name="tb_idfournisseur" value="<?= $_GET['use_fournisseur'] ?>">
                                                    <input type="hidden" name="tb_idbiens" value="<?= $_GET['use_biens'] ?>">
                                                    <input type="hidden" name="tb_idravitaillement" value="<?= $ravitaillement['id'] ?>">
                                                    <button style="margin-left: 5px;" type="submit" class="btn btn-danger" name="bt_delete_ravitaillement"><span class="fa fa-times"></span>Delete</button>
                                                </form>
                                                <form class="form-horizontal" method="post" action="../contollers/ravitaillement/ravitaillementController.php">
                                                    <input type="hidden" name="tb_idravitaillement" value="<?= $ravitaillement['id'] ?>">
                                                    <button style="margin-left: 5px;" type="submit" class="btn btn-success" name="bt_for_costing"><span class="fa fa-list"></span> Cost add-ins</button>
                                                </form>
                                            </td>
                                            <td>
                                                <form class="form-horizontal" method="post" action="../contollers/ravitaillement/ravitaillementController.php">

                                                    <input type="hidden" name="tb_date1" value="<?= $_GET['use_date1'] ?>">
                                                    <input type="hidden" name="tb_date2" value="<?= $_GET['use_date2'] ?>">
                                                    <input type="hidden" name="tb_idfournisseur" value="<?= $_GET['use_fournisseur'] ?>">
                                                    <input type="hidden" name="tb_idbiens" value="<?= $_GET['use_biens'] ?>">
                                                    <input type="hidden" name="tb_idravitaillement" value="<?= $ravitaillement['id'] ?>">
                                                    <table>
                                                        <tr>
                                                            Actual date : <?= $ravitaillement['date'] ?> 
                                                            <td>
                                                                <input type="date" class="form-control" name="tb_newdate" value=" <?= $ravitaillement['date'] ?>">
                                                            </td>
                                                            <td>
                                                                <button style="margin-left: 5px;" type="submit" class="btn btn-primary" name="bt_update_date"><span class="fa fa-pencil"></span></button>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </form>
                                            </td>
                                            <td>
                                                <?php
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

                                            <td style="color:blue;font-size: 20px;font-weight: bold;">
                                                <?php
                                                //                                      $chaine_part_ravitaillement;
                                                $items_ravitaillement = explode('-', $chaine_part_ravitaillement_sortie);
                                                $n_same_ravitaillement = 0;
                                                $cumule_prix = 0;
                                                foreach ($items_ravitaillement as $item) {
                                                    if ((strlen($item)) == 1) {
                                                        $bdravitaillement_second = new BdRavitaillement();
                                                        $ravitaillements_second = $bdravitaillement_second->getRavitaillementById($item);
                                                        $last = 0;
                                                        $i = 0;
                                                        $j = 0;
                                                        $prix_item = 0;
                                                        foreach ($ravitaillements_second as $ravitaillement_second) {
                                                            $i++;
                                                            //                                                    echo $item;
                                                        }
                                                        foreach ($ravitaillements_second as $ravitaillement_second) {
                                                            $cumule_prix = $cumule_prix + $ravitaillement_second['prix'];
                                                            $j++;
                                                        }
                                                    }
                                                }
                                                echo $cumule_prix . " USD";
                                                $cumul_total_sortie = $cumul_total_sortie + $cumule_prix;
                                                ?>
                                            </td>
                                            <td style="color:blue;font-size: 20px;font-weight: bold;">
                                                <?php
                                                //                                      $chaine_part_ravitaillement;
                                                $items_ravitaillement = explode('-', $chaine_part_ravitaillement_reste);
                                                $n_same_ravitaillement = 0;
                                                $cumule_prix = 0;
                                                foreach ($items_ravitaillement as $item) {
                                                    if ((strlen($item)) == 1) {
                                                        $bdravitaillement_second = new BdRavitaillement();
                                                        $ravitaillements_second = $bdravitaillement_second->getRavitaillementById($item);
                                                        $last = 0;
                                                        $i = 0;
                                                        $j = 0;
                                                        $prix_item = 0;
                                                        foreach ($ravitaillements_second as $ravitaillement_second) {
                                                            $i++;
                                                            //                                                    echo $item;
                                                        }
                                                        foreach ($ravitaillements_second as $ravitaillement_second) {
                                                            $cumule_prix = $cumule_prix + $ravitaillement_second['prix'];
                                                            $j++;
                                                        }
                                                    }
                                                }
                                                echo $cumule_prix . " USD";
                                                $cumul_total_reste = $cumul_total_reste + $cumule_prix;
                                                ?>
                                            </td>
                                            <td><?= $ravitaillement['prix'] . " USD" ?></td>
                                            <td style="color: green; font-weight: bold;"><?= ($ravitaillement['quantite'] * $ravitaillement['prix']) . " USD" ?></td>
                                            <td><?= $ravitaillement['dateExpiration'] ?></td>
                                            <td>
                                                <?php
                                                if (isset($ravitaillement['pourcentageTVA'])) {
                                                    echo $ravitaillement['pourcentageTVA'];
                                                }
                                                 ?>
                                            </td>
                                            <td>
                                                <?php
                                                if (isset($ravitaillement['pourcentageTVA'])) {
                                                    echo (($ravitaillement['pourcentageTVA'] / 100) * ($ravitaillement['quantite'] * $ravitaillement['prix'])) . " USD";
                                                    $cumul_TVA_fournisseur = $cumul_TVA_fournisseur + (($ravitaillement['pourcentageTVA'] / 100) * ($ravitaillement['quantite'] * $ravitaillement['prix']));
                                                }
                                                
                                                ?>
                                            </td>
                                            <td>
                                                <strong style="color: forestgreen;">
                                                    <?php
                                                    $cumul_costing = 0;
                                                    $bdCosting = new BdCosting();
                                                    $costings = $bdCosting->getCostingByRavitaillementId($ravitaillement['id']);
                                                    foreach ($costings as $costing) {
                                                        $cumul_costing = $cumul_costing + ($costing['quantite'] * $costing['prix']);
                                                    }
                                                    echo $cumul_costing . " USD";
                                                    $cumul_costing_fournisseur=$cumul_costing_fournisseur+$cumul_costing;
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
                                <tr>
                                    <td style="color: red; font-weight: bold;">Total : <?= $cumul_total_fournisseur ?> USD </td>
                                    <td style="color: dodgerblue; font-weight: bold;">Value TVA : <?= $cumul_TVA_fournisseur ?> USD </td>
                                    <td style="color: orange; font-weight: bold;">Total + TVA : <?= ($cumul_total_fournisseur + $cumul_TVA_fournisseur) ?> USD </td>
                                    <td style="color: #b7005b; font-weight: bold;">Value costing : <?= ($cumul_costing_fournisseur) ?> USD </td>
                                    <td style="color: forestgreen; font-weight: bold;">Grand total : <?= (($cumul_total_fournisseur + $cumul_TVA_fournisseur)+($cumul_costing_fournisseur)) ?> USD </td>
                                </tr>
                            <?php
                                $cumul_total_all = $cumul_total_all + $cumul_total_fournisseur;
                                $cumul_TVA_all = $cumul_TVA_all + $cumul_TVA_fournisseur;
                                $cumul_costing_all=$cumul_costing_all+$cumul_costing_fournisseur;
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <td style="font-size: 20px;">
                                <span>Nombre:</span><span><?= $n ?></span>
                            </td>
                            <td style=" color: dodgerblue; font-weight: bold;">
                                <span>Grand total valeur sortie : </span><span><?= $cumul_total_sortie . " USD" ?></span>
                            </td>
                            <td style="color: dodgerblue; font-weight: bold;">
                                <span>Grand total valeur actuelle : </span><span><?= $cumul_total_reste . " USD" ?></span>
                            </td>
                            <td style="color: forestgreen; font-weight: bold;">
                                <span>Grand total valeur entrée : </span><span><?= $cumul_total_all . " USD" ?></span>
                            </td>
                            <td style="color: orange; font-weight: bold;">
                                <span>Valeur TVA : </span><span><?= $cumul_TVA_all . " USD" ?></span>
                            </td>
                            <td style="color: dodgerblue; font-weight: bold;">
                                <span>Total + TVA : </span><span><?= ($cumul_total_all + $cumul_TVA_all) . " USD" ?></span>
                            </td>
                            <td style="color: #b00058; font-weight: bold;">
                                <span>Total valeurs coût supp. : </span><span><?= ($cumul_costing_all) . " USD" ?></span>
                            </td>
                            <td style="color: forestgreen; font-weight: bold;">
                                <span>Grand Total : </span><span><?= (($cumul_total_all + $cumul_TVA_all)+($cumul_costing_all)) . " USD" ?></span>
                            </td>
                        </tfoot>
                    </table>
                <?php
                }
                ?>

            </fieldset>
        </div>
    </div>
</div>