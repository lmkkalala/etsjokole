<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/attribution-biens/attributionBiens.php';
include '../models/fournisseur/fournisseur.php';
include '../models/biens/biens.php';
include '../models/ravitaillement/ravitaillement.php';

?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-cubes" style="color: darkorange; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-plus-square-o" style="color: darkorange; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Entrée</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-asterisk" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Nouvelle</span>
    </div>
    <div class="panel panel-body">
        <div>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("succes")))) {
                ?>
                <div class="alert alert-success">
                    <span class="glyphicon glyphicon-ok" style="font-size: 15px;margin-right: 5px;"></span><span>Enregistrement effectué avec succès</span>
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
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("remplissage_error")))) {
                ?>
                <div class="alert alert-warning">
                    <span class="glyphicon glyphicon-blackboard" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur de remplissage, Recommencer SVP</span>
                </div>
                <?php
            }
            ?>

            <div style="background-color: whitesmoke; padding: 10px;">
                <form class="form-inline" method="POST" action="../contollers/ravitaillement/ravitaillementController.php">
                    <div class="row">
                        <div class="col-6">
                            <label class="control-label">Fournisseur :</label>
                            <select class="form-control select2" name="cb_fournisseur">
                                <option value="0">Choisir le fournisseur</option>
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
                        <div class="col-6">
                            <label for="">Commande: </label>
                            <select class="form-control mt-2 select2" name="cb_numeroOrder">
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
                        <div class="col-6">
                            <label class="control-label">Date début :</label>
                            <input class="form-control mt-1" type="date" name="tb_date1">
                        </div>
                        <div class="col-6">
                            <label class="control-label">Date fin :</label>
                            <input class="form-control mt-1" type="date" name="tb_date2">
                        </div>
                        <div class="col-6">
                            <input class="btn btn-success mt-2" type="submit" name="bt_select_fournisseur_for_add_ravitaillement" value="Selectionner">
                        </div>
                    </div>
                </form>
            </div>

            <div style="margin: 10px;">
                <fieldset>
                    <legend style="margin: 5px; color: dodgerblue;">
                        <?php
                        if (isset($_GET['use_fournisseur'])) {
                            $bdfournisseur = new BdFournisseur();
                            $fournisseurs = $bdfournisseur->getFournisseurById($_GET['use_fournisseur']);
                            foreach ($fournisseurs as $fournisseur) {
                                echo $fournisseur['designation'] ;
                            }
                        }
                        ?>
                    </legend>
                </fieldset>
                <fieldset>
                    <legend style="color: orange; font-weight: bold;">
                        <?php
                        if ((isset($_GET['use_date1'])) && ($_GET['use_date1'] != "")) {
                            echo "Order Date : " . ($_GET['use_date1']) . " to ";
                        }
                        if ((isset($_GET['use_date2'])) && ($_GET['use_date2'] != "")) {
                            echo "" . ($_GET['use_date2']);
                        }

                        if ((isset($_GET['use_numeroOrder'])) && ($_GET['use_numeroOrder'] != "none"))
                            echo "Order number : ".$_GET['use_numeroOrder'];
                        ?>
                    </legend>
                </fieldset>
            </div>

            <?php
            if ((((isset($_GET['use_fournisseur'])) && (isset($_GET['use_date1'])) && (isset($_GET['use_date2']))) && (($_GET['use_date1'] != "") && ($_GET['use_date2'] != ""))) || (isset($_GET['use_numeroOrder']) && ($_GET['use_numeroOrder'] != "none"))) {
                ?>
                <div style="background-color: whitesmoke; padding: 10px;">
                    <fieldset>
                        <legend class="text-uppercase fw-bolder">Pas encore réceptionnées</legend>
                    </fieldset>
                    <table class="table table-bordered table-hover table-responsive">
                        <thead>
                        <th>Commande</th>
                        <th>Qtés reçues</th>
                        <th>Date</th>
                        <th>Qté restante</th>
                        <th>PU entrée stock</th>
                        <th>Date expiration</th>
                        <th>% TVA</th>
                        <th>Ajout</th>
                        </thead>
                        <tbody>
                            <?php
                            $bdattributionbiens = new BdAttributionBiens();

                            if ($_GET['use_numeroOrder'] == "none") {
                                $attributions = $bdattributionbiens->getAttributionBiensByIdFournisseurByDate1ByDate2Second($_GET['use_fournisseur'], $_GET['use_date1'], $_GET['use_date2']);
                            } else {
                                $attributions = $bdattributionbiens->getAttributionBiensByNumeroOrderSecond($_GET['use_numeroOrder']);
                            }

                            $nAtt=0;
                            foreach ($attributions as $attribution) {
                                $nAtt++;
                                ?>
                                <tr>
                            <form class="form-horizontal" method="POST" action="../contollers/ravitaillement/ravitaillementController.php">
                                <td>
                                    <div class="input-group-lg">
                                        <?php
                                        $lesRavitaillements="";
                                        $sommeQuantiteRavit=0;
                                        $u=0;
                                        $bdattributionbiens = new BdAttributionBiens();
                                        $bdravitaillement = new BdRavitaillement();
                                        $ravitaillements=$bdravitaillement->getRavitaillementByIdAttributionBiens($attribution['aId']);
                                        foreach ($ravitaillements as $ravitaillement) {
                                            $u++;
                                            $lesRavitaillements=$lesRavitaillements.$u.". ".$ravitaillement['date']." Qté: ".$ravitaillement['quantite']." \n ";
                                            $sommeQuantiteRavit=$sommeQuantiteRavit+$ravitaillement['quantite'];
                                        }
                                        
                                        $attributions_second = $bdattributionbiens->getAttributionBiensById($attribution['aId']);
                                        foreach ($attributions_second as $attribution_second) {
                                            if (1) {
                                                ?>
                                                <?= $attribution_second['date'] . " / " . $attribution_second['bDesignation'] . " prix unitaire : " . $attribution_second['aPrixUnitaire'] . " USD à " . $attribution_second['fDesignation'] . "/ quantité : " . $attribution_second['quantite_minimale'] ?>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </td>
                                <td>
                                    <?= $lesRavitaillements ?>
                                </td>
                                <td>
                                    <input class="form-control" type="date" name="tb_date" value="<?= $attribution['date'] ?>">
                                </td>
                                <td>
                                    <input class="form-control" type="text" name="tb_quantite" value="<?= ($attribution['quantite_minimale']-$sommeQuantiteRavit) ?>">
                                </td>
                                <td>
                                    <input class="form-control" type="text" name="tb_prix" value="<?= $attribution['aPrixUnitaire'] ?>">
                                </td>
                                <td>
                                    <input class="form-control" type="date" name="tb_dateexpiration">
                                </td>
                                <td>
                                    <input class="form-control" type="text" name="tb_tva" placeholder="% TVA">
                                </td>
                                <td>
                                    <div class="input-group-lg">
                                        <input type="hidden" name="tb_idattributionbiens" value="<?= $attribution['aId'] ?>">
                                        <input type="hidden" name="tb_date1" value="<?= $_GET['use_date1'] ?>">
                                        <input type="hidden" name="tb_date2" value="<?= $_GET['use_date2'] ?>">
                                        <input type="hidden" name="tb_idfournisseur" value="<?= $_GET['use_fournisseur'] ?>">
                                        <input type="hidden" name="tb_numeroOrder" value="<?= $_GET['use_numeroOrder'] ?>">
                                        <input id="ckbControl<?= $nAtt ?>" type="checkbox" name="ckb_control"> <span id="spSure<?= $nAtt ?>">Sure?</span>
                                        <input id="ajouterRav<?= $nAtt ?>" class="btn btn-success" type="submit" name="bt_enregistrer" value="Ajouter">
                                    </div>
                                </td>
                            </form>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                    
                    <input id="nAtt" type="hidden" name="tb_nAtt" value="<?= $nAtt ?>">

                </div>
                <?php
            }
            ?>
        </div>

        <?php
        if (((isset($_GET['use_fournisseur'])) && (isset($_GET['use_date1'])) && (isset($_GET['use_date2']))) && (($_GET['use_date1'] != "") && ($_GET['use_date2'] != ""))) {
            ?>
            <div>
                <fieldset>
                    <legend class="text-uppercase fw-bolder">Réceptionnées</legend>
                </fieldset>
                <table class="table table-bordered table-responsive-lg  table-striped">
                    <thead>
                    <th>N°</th>
                    <th>Date</th>
                    <th>Commande</th>
                    <th>Quantité Reception</th>
                    <th>Reste sur Commande</th>
                    <th>PU entrée stock (USD)</th>
                    <th>Valeur (USD)</th>
                    <th>% TVA</th>
                    <th>Valeur TVA (USD)</th>
                    <th>Date d'expiration</th>
                    </thead>
                    <tbody>
                        <?php
                        $chaine_attribution_biens = "";
                        $bdattributionbiens = new BdAttributionBiens();
                        $attributions = $bdattributionbiens->getAttributionBiensByIdFournisseurByDate1ByDate2($_GET['use_fournisseur'], $_GET['use_date1'], $_GET['use_date2']);
                        foreach ($attributions as $attribution) {
                            $chaine_attribution_biens = $chaine_attribution_biens . $attribution['aId'] . "-";
                        }

                        $n = 0;
                        $cumul_value_ravitaillement = 0;
                        $cumul_tva = 0;
                        $bdravitaillement = new BdRavitaillement();
                        $items_attribution_biens = explode('-', $chaine_attribution_biens);
                        $quantite = 0;
                        $quantite_old = 0;
                        foreach ($items_attribution_biens as $item_attribution_biens) {
                            if ($item_attribution_biens != "") {
                                $ravitaillements = $bdravitaillement->getRavitaillementByIdAttributionBiens($item_attribution_biens);
                                foreach ($ravitaillements as $ravitaillement) {
                                    ?>
                                    <tr>
                                        <td><?= $ravitaillement['id'] ?></td>
                                        <td><?= $ravitaillement['date'] ?></td>
                                        <td>
                                        <?php
                                            $bdattributionbiens = new BdAttributionBiens();
                                            $attributions = $bdattributionbiens->getAttributionBiensById($ravitaillement['attribution_id']);
                                            foreach ($attributions as $attribution) {
                                                
                                        ?>
                                                <?= $attribution['aId'] ?> . <?= $attribution['date'] . " / " . $attribution['bDesignation'] . " à " . $attribution['fDesignation'] . " pour " . $attribution['delai_livraison'] . " jour(s) / quantité : " . $attribution['quantite_minimale'] ?>
                                        <?php
                                            }
                                            $quantite_old = $quantite_old + $ravitaillement['quantite'];

                                            $quantite = $attribution['quantite_minimale'] - $quantite_old;
                                        ?>
                                        </td>
                                        <td><?=$ravitaillement['quantite'] ?></td>
                                        <td><?=$quantite?></td>
                                        <td><?= $ravitaillement['prix'] ?></td>
                                        <td style="font-weight: bold;">
                                            <?php
                                            echo ($ravitaillement['quantite'] * $ravitaillement['prix']);
                                            $cumul_value_ravitaillement = $cumul_value_ravitaillement + ($ravitaillement['quantite'] * $ravitaillement['prix']);
                                            ?>
                                        </td>
                                        <td>
                                            <?= $ravitaillement['pourcentageTVA'] ?>
                                        </td>
                                        <td>
                                            <?php
                                            echo (($ravitaillement['pourcentageTVA'] / 100) * ($ravitaillement['quantite'] * $ravitaillement['prix']));
                                            $cumul_tva = $cumul_tva + (($ravitaillement['pourcentageTVA'] / 100) * ($ravitaillement['quantite'] * $ravitaillement['prix']));
                                            ?>
                                        </td>
                                        <td><?= $ravitaillement['dateExpiration'] ?></td>
                                    </tr>
                                    <?php
                                }
                            }
                            $quantite_old = 0;
                        }
                        ?>
                    </tbody>
                    <tfoot>
                    <td style="font-weight: bold;">
                        <span>Number : </span><span><?= $n ?></span>
                    </td>
                    <td></td>
                    <td style="font-weight: bold; color: forestgreen;">
                        <span>Valeur Total : </span><span><?= $cumul_value_ravitaillement ?> USD </span>
                    </td>
                    <td></td>
                    <td style="font-weight: bold; color: dodgerblue;">
                        <span>Total TVA : </span><span><?= $cumul_tva ?> USD </span>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="font-weight: bold; color : orange;">
                        <span>Total Facture : </span>
                    </td>
                    <td style="font-weight: bold; color : orange;"><span><?= ($cumul_value_ravitaillement + $cumul_tva) ?> USD </span></td>
                    </tfoot>
                </table>
            </div>
            <?php
        }
        ?>
    </div>
</div>

