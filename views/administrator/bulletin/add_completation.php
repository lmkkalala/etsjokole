<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/livrepaie/LivrePaie.php';
include '../models/promotion/Promotion.php';
include '../models/chargeconf/ChargeConf.php';
include '../models/compte/Compte.php';
include '../models/conf-salaire/ConfSalaire.php';
include '../models/conf-imposition/ConfImposition.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-bandcamp" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span><span class="h3">Bulletin de paie</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-asterisk" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Remplissage</span>
    </div>
    <div class="panel panel-body">
        <div>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == (sha1("succes"))))) {
                ?>
                <div class="alert alert-success">
                    <span class="glyphicon glyphicon-ok" style="font-size: 25px;margin-right: 5px;"></span><span>Enregistrement effectué avec succès</span>
                </div>
                <?php
            }
            ?>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == (sha1("traitement_error"))))) {
                ?>
                <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-ban-circle" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur d'enregistrement</span>
                </div>
                <?php
            }
            ?>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == (sha1("remplissage_error"))))) {
                ?>
                <div class="alert alert-warning">
                    <span class="glyphicon glyphicon-blackboard" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur de remplissage, Recommencer SVP</span>
                </div>
                <?php
            }
            ?>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == (sha1("doublons_error"))))) {
                ?>
                <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-refresh" style="font-size: 25px;margin-right: 5px;"></span><span>Doublons, Bulletin de paie de ce mois et de l'agent déjà enregistré</span>
                </div>
                <?php
            }
            ?>

            <fieldset>
                <legend>Information empoloyé</legend>
                <table class="table table-striped table-bordered table-hover">
                    <?php
                    $bdpromotion = new BdPromotion();
                    $promotions = $bdpromotion->getPromotionById($_GET['use_affectationservice']);
                    foreach ($promotions as $promotion) {
                        if ($promotion['afActive']) {
                            ?>
                            <tr>
                                <td>Matricule : </td>
                                <td style="font-weight: bold;"><?= $promotion['matricule'] ?></td>

                                <td>Identité : </td>
                                <td style="font-weight: bold;"><?= $promotion['nom'] . " " . $promotion['postnom'] . " " . $promotion['prenom'] . " / Sexe: " . $promotion['sexe'] ?></td>

                                <td>Catégorie : </td>
                                <td style="font-weight: bold;"><?= $promotion['ctDesignation'] ?></td>

                                <td>Service : </td>
                                <td style="font-weight: bold;"><?= $promotion['sDesignation'] ?></td>
                            </tr>
                            <tr>
                                <td>Fonction : </td>
                                <td style="font-weight: bold;"><?= $promotion['fDesignation'] ?></td>

                                <?php
                                $idchargeconf = 0;
                                $bdchargeconf = new BdChargeConf();
                                $chargeconfs = $bdchargeconf->getChargeConfByEmploye($promotion['eId']);
                                foreach ($chargeconfs as $chargeconf) {
                                    if ($chargeconf['ccActive']) {
                                        ?>
                                        <td>Etat civil : </td>
                                        <td style="font-weight: bold;"><?= $chargeconf['etatCivil'] . "  / Nbre enfant: " . $chargeconf['nombreEnfant'] . "  / Personne en charge: " . $chargeconf['nombreFemme'] ?></td>
                                        <?php
                                        $idchargeconf = $chargeconf['ccId'];
                                        $nombre_enfant = $chargeconf['nombreEnfant'];
                                    }
                                }
                                ?>

                                <td>Date engagement : </td>
                                <td style="font-weight: bold;"><?= $promotion['dateRecrutement'] ?></td>

                                <td>Type de contrat : </td>
                                <td style="font-weight: bold;"><?= $promotion['tcDesignation'] ?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>

                </table>
            </fieldset>

            <fieldset>
                <?php
                $bdlivrepaie = new BdLivrePaie();
                $livrepaies = $bdlivrepaie->getLivrePaieById($_GET['use_livrepaie']);
                foreach ($livrepaies as $livrepaie) {
                    if ($livrepaie['active']) {
                        ?>
                        <legend style="color: blue;font-size: 20px; font-weight: bold;">Livre de paie : <?= $livrepaie['mois'] . " / " . $livrepaie['annee'] ?> </legend>
                        <?php
                    }
                }
                ?>
            </fieldset>
            <fieldset>
                <legend></legend>
                <table class="table table-striped table-bordered table-hover">
                    <th>Code</th>
                    <th>Libelle du mouvement</th>
                    <th>Temps</th>
                    <th>Unité</th>
                    <th>Taux</th>
                    <th>Montant à payer</th>
                    <th>Montant à rétenir</th>
                    <tbody>
                        <?php
                        $chaine_composantesalaire_selectionnee = "";
                        $bdconfsalaire = new BdConfSalaire();
                        $cumul_nature_salaire = 0;
                        $cumul_nature_retention = 0;
                        $impot_CNSS = 0;
                        $brut_imposable = 0;
                        $item_retenir = 0;
                        $impot_IPR = 0;
                        $items_composantesalaire = explode('/', $_GET['use_chaine_composantesalaire']);
                        foreach ($items_composantesalaire as $item_composantesalaire) {
                            if ($item_composantesalaire != "") {
                                $items_contenue = explode('-', $item_composantesalaire);

                                $id_confsalaire_item = $items_contenue[0];
                                $chaine_composantesalaire_selectionnee = $chaine_composantesalaire_selectionnee . $id_confsalaire_item . "-";
                                $quantite_item = $items_contenue[1];
                                $confsalaires = $bdconfsalaire->getConfSalaireById($id_confsalaire_item);
                                foreach ($confsalaires as $confsalaire) {
                                    if ($confsalaire['active']) {
                                        ?>
                                    <form class="form-horizontal" method="POST" action="../contollers/bulletin/bulletinController.php">

                                        <tr>
                                            <td><?= $confsalaire['code'] ?></td>
                                            <td><?= $confsalaire['designation'] ?></td>
                                            <td><?= $quantite_item ?></td>
                                            <td><?= $confsalaire['unite'] ?></td>
                                            <td>
                                                <?php
                                                if ($confsalaire['designation'] == "CNSS" || $confsalaire['designation'] == "Impot") {
                                                    echo "0.00";
                                                } else {
                                                    echo $confsalaire['taux'];
                                                }
                                                ?>
                                            </td>
                                            <?php
                                            if ($confsalaire['nature'] == "salaire") {
                                                ?>
                                                <td><?= ($confsalaire['taux'] * $quantite_item) ?></td>
                                                <td><?= 0 ?></td>
                                                <?php
                                            } else if ($confsalaire['nature'] == "retention") {
                                                if ($confsalaire['designation'] == "CNSS") {
                                                    ?>
                                                    <td><?= 0 ?></td>
                                                    <td><?= ($confsalaire['taux'] * $quantite_item * $brut_imposable) ?></td>
                                                    <?php
                                                    $item_retenir = $item_retenir + ($confsalaire['taux'] * $quantite_item * $brut_imposable);
                                                } else if ($confsalaire['designation'] == "Impot") {
                                                    $net_imposable = (($brut_imposable) - ($impot_CNSS * $brut_imposable));
                                                    $valeur_brut_IPR = ($net_imposable * ($confsalaire['taux'] * $quantite_item));
                                                    $impot_IPR = $valeur_brut_IPR - ($valeur_brut_IPR * ((2 / 100) * $nombre_enfant));
                                                    ?>
                                                    <td><?= 0 ?></td>
                                                    <td><?= ($impot_IPR) ?></td>
                                                    <?php
                                                    $item_retenir = $item_retenir + ($impot_IPR);
                                                } else {
                                                    ?>
                                                    <td><?= 0 ?></td>
                                                    <td><?= ($confsalaire['taux'] * $quantite_item) ?></td>
                                                    <?php
                                                    $item_retenir = $item_retenir + ($confsalaire['taux'] * $quantite_item);
                                                }
                                            }
                                            ?>

                                            <td>
                                                <input type="hidden" name="tb_idconfsalaire" value="<?= $confsalaire['id'] ?>">
                                                <input type="hidden" name="tb_use_livrepaie" value="<?= $_GET['use_livrepaie'] ?>">
                                                <input type="hidden" name="tb_quantite" value="<?= $quantite_item ?>">
                                                <input type="hidden" name="tb_use_affectationservice" value="<?= $_GET['use_affectationservice'] ?>">
                                                <input type="hidden" name="tb_use_chaine_composantesalaire" value="<?= $_GET['use_chaine_composantesalaire'] ?>">
                                                <button type="submit" class="btn btn-danger" name="bt_remove_composantesalaire"><span class="fa fa-remove"></span></button>
                                            </td>
                                        </tr>

                                    </form>
                                    <?php
                                    if ($confsalaire['designation'] == "CNSS") {
                                        $impot_CNSS = ($confsalaire['taux'] * $quantite_item);
                                    }
                                    if ($confsalaire['designation'] == "Impot") {
                                        $net_imposable = (($brut_imposable) - ($impot_CNSS * $brut_imposable));
                                        $valeur_brut_IPR = ($net_imposable * ($confsalaire['taux'] * $quantite_item));
                                        $impot_IPR = $valeur_brut_IPR - ($valeur_brut_IPR * ((2 / 100) * $nombre_enfant));
//                                        $impot_IPR = ($net_imposable * ($confsalaire['taux'] * $quantite_item)) * ((2 / 100) * $nombre_enfant);
                                    }
                                    if ($confsalaire['designation'] == "Salaire de base") {
                                        $brut_imposable = ($confsalaire['taux'] * $quantite_item);
                                    }
                                    if ($confsalaire['nature'] == "salaire") {
                                        if ($confsalaire['type'] == "positif") {
                                            $cumul_nature_salaire = $cumul_nature_salaire + ($confsalaire['taux'] * $quantite_item);
                                        } else if ($confsalaire['type'] == "negatif") {
                                            $cumul_nature_salaire = $cumul_nature_salaire - ($confsalaire['taux'] * $quantite_item);
                                        }
                                    }
                                    if (($confsalaire['nature'] == "retention") && ($confsalaire['designation'] != "CNSS")) {
                                        $cumul_nature_retention = $cumul_nature_retention + ($confsalaire['taux'] * $quantite_item);
                                    }
                                }
                            }
                        }
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <td style="color: orange;font-size: 18px;font-weight: bold;">Total Brut : <?= $cumul_nature_salaire ?> USD </td>
                    <td style="color: dodgerblue;font-size: 18px;font-weight: bold;">Brut imposable : <?= $brut_imposable ?> USD </td>
                    <td style="color: dodgerblue;font-size: 18px;font-weight: bold;">Net imposable : <?= (($brut_imposable) - ($impot_CNSS * $brut_imposable)) ?> USD </td>

                    <td style="color: orange;font-size: 18px;font-weight: bold;">Total à retenir : <?= $item_retenir ?> USD </td>
                    <td style="color: forestgreen;font-size: 18px;font-weight: bold;">Net à payer : <?= (($cumul_nature_salaire) - ($item_retenir)) ?> USD </td>
                    <?php
                    $net_a_payer = (($cumul_nature_salaire) - ($item_retenir));
                    $net_imposable = (($brut_imposable) - ($impot_CNSS * $brut_imposable));
                    ?>
                    </tfoot>
                </table>
            </fieldset>
            <fieldset>
                <legend>

                </legend>
                <table class="table table-striped table-bordered table-hover">
                    <th>Libelle</th>
                    <th>Pourcentage</th>
                    <th>Valeur</th>
                    <tbody>
                        <?php
                        $bdconfimposition = new BdConfImposition();
                        $cumul_contribution = 0;
                        $chaine_composante_imposition = "";
                        $confimpositions = $bdconfimposition->getConfImpositionByCategorie($promotion['ctId']);
                        foreach ($confimpositions as $confimposition) {

                            if ($confimposition['active']) {
//                          
                                if (1) {
                                    ?>
                                <form class="form-horizontal" method="POST" action="../contollers/bulletin/bulletinController.php">
                                    <tr>
                                        <td><?= $confimposition['designation'] ?></td>
                                        <td><?= $confimposition['pourcentage'] . " % " ?></td>
                                        <td><?= (($confimposition['pourcentage'] / 100) * $brut_imposable) . " USD " ?></td>
                                    </tr>
                                </form>
                                <?php
                                $chaine_composante_imposition = $chaine_composante_imposition . $confimposition['id'] . "-";
                                $cumul_contribution = $cumul_contribution + (($confimposition['pourcentage'] / 100) * $brut_imposable);
                            }
                        }
                    }
                    ?> 
                    </tbody>
                    <tfoot>
                    <td style="color:red;font-size: 18px;font-weight: bold;">Total charges : <?= ($cumul_contribution + $net_a_payer) ?> USD</td>
                    </tfoot>
                </table>
            </fieldset>
            <fieldset>
                <legend>

                </legend>
                <table class="table table-striped table-bordered table-hover">
                    <th>Code</th>
                    <th>Libelle du mouvement</th>
                    <th>Temps</th>
                    <th>Unité</th>
                    <th>Taux</th>
                    <?php
                    $trouve = false;
                    $bdconfsalaire = new BdConfSalaire();
                    $confsalaires = $bdconfsalaire->getConfSalaireByCategorie($promotion['ctId']);
                    foreach ($confsalaires as $confsalaire) {
                        $trouve = false;
                        if ($confsalaire['active']) {
//                            echo $chaine_composantesalaire_selectionnee;
                            $items_selected = explode('-', $chaine_composantesalaire_selectionnee);
                            foreach ($items_selected as $item_selected) {
                                if ($item_selected != "") {
                                    if ($item_selected == $confsalaire['id']) {
                                        $trouve = true;
                                    }
                                }
                            }
                            if (!$trouve) {
                                ?>
                                <form class="form-horizontal" method="POST" action="../contollers/bulletin/bulletinController.php">
                                    <tr>
                                        <td><?= $confsalaire['code'] ?></td>
                                        <td><?= $confsalaire['designation'] ?></td>
                                        <td><input class="form-control" type="number" name="tb_quantite" value="<?= $confsalaire['defaultQuantite'] ?>"></td>
                                        <td><?= $confsalaire['unite'] ?></td>
                                        <td><?= $confsalaire['taux'] ?></td>
                                        <td>
                                            <input type="hidden" name="tb_idconfsalaire" value="<?= $confsalaire['id'] ?>">
                                            <input type="hidden" name="tb_use_livrepaie" value="<?= $_GET['use_livrepaie'] ?>">
                                            <input type="hidden" name="tb_use_affectationservice" value="<?= $_GET['use_affectationservice'] ?>">
                                            <input type="hidden" name="tb_use_chaine_composantesalaire" value="<?= $_GET['use_chaine_composantesalaire'] ?>">
                                            <button type="submit" class="btn btn-primary" name="bt_select_composantesalaire"><span class="fa fa-check"></span></button>
                                        </td>
                                    </tr>
                                </form>
                                <?php
                            }
                        }
                    }
                    ?>
                </table>
            </fieldset>

            <form class="form-horizontal" method="POST" action="../contollers/bulletin/bulletinController.php">
                <div class="input-group-lg">
                    <label class="control-label">Caisse : </label>
                    <select class="form-control select2" name="cb_compte">
                        <option value="0">Choisir le compte</option>
                        <?php
                        $bdcompte = new BdCompte();
                        $comptes = $bdcompte->getCompteByEmploye($promotion['eId']);
                        foreach ($comptes as $compte) {
                            if ($compte['coActive']) {
                                if (1) {
                                    ?>
                                    <option value="<?= $compte['coId'] ?>"><?= "Etablissement : " . $compte['etablissement'] . " / Numero : " . $compte['coNumero'] . " / Date creation : " . $compte['dateCreation'] ?></option>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="input-group-lg">
                    <label class="control-label">Date : </label>
                    <input class="form-control" type="date" name="tb_datecreation">
                </div>

                <fieldset>
                    <legend></legend>
                    <div class="input-group-lg">
                        <input type="hidden" name="tb_use_livrepaie" value="<?= $_GET['use_livrepaie'] ?>">
                        <input type="hidden" name="tb_idchargeconf" value="<?= $idchargeconf ?>">
                        <input type="hidden" name="tb_chaine_composanteimposition" value="<?= $chaine_composante_imposition ?>">
                        <input type="hidden" name="tb_use_affectationservice" value="<?= $_GET['use_affectationservice'] ?>">
                        <input type="hidden" name="tb_use_chaine_composantesalaire" value="<?= $_GET['use_chaine_composantesalaire'] ?>">
                        <input class="btn btn-success" type="submit" name="bt_enregistrer" value="Save">
                        <input class="btn btn-danger" type="reset" value="Reset">
                    </div>
                </fieldset>
                <br>                
                <fieldset >
                    <?php
                    if ((isset($_GET['use_printable'])) && (($_GET['use_printable']) == "yes")) {
                        ?>
                        <a style="font-size: 20px;" href='../views/administrator/bulletin/pdf_bulletinpaie_self.php?use_livrepaie=<?= $_GET['use_livrepaie'] . '&use_chaine_composantesalaire=' . $_GET['use_chaine_composantesalaire'] . '&use_affectationservice=' . $_GET['use_affectationservice'] . '&use_compte=' . $_GET['use_compte'] . '&use_datecreation=' . $_GET['use_datecreation'] ?>' class="btn btn-primary pull-left">Print in PDF</a>
                        <?php
                    } else {
                        ?>
                        <br>
                        <p style="color: orange;font-size: 20px;font-weight: bold;">Save first before to print</p>
                        <?php
                    }
                    ?>

                </fieldset>
            </form>
        </div>

    </div>

</div>
</div>

