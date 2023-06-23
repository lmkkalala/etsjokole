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
include '../models/bulletin/Bulletin.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-bandcamp" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span><span class="h3">Bulletin de paie</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-asterisk" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Payroll</span>
    </div>
    <div class="panel panel-body col-lg-12">
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
            <table class="table table-striped table-hover table-bordered table-responsive table-condensed">
                <thead>
                <th>
                    #
                </th>
                <th>
                    Matricule
                </th>
                <th>
                    Identité
                </th>
                <th>
                    Catégorie
                </th>
                <th>
                    Service
                </th>
                <th>
                    Fonction
                </th>
                <th>
                    Etat civil
                </th>
                <th>
                    Date Engagement
                </th>
                <th>
                    Type contrat
                </th>

                </thead>
                <tbody>
                    <?php
                    $k = 0;
                    $cumul_impot_IPR = 0;
                    $cumul_impot_CNSS = 0;
                    $cumul_net_a_payer = 0;
                    $cumul_charge_totale = 0;
                    $bdbulletin = new BdBulletin();
                    $bulletins = $bdbulletin->getBulletinAll();
                    foreach ($bulletins as $bulletin) {
                        if ($bulletin['active']) {


                            $k++;
                            ?>
                            <tr>
                                <?php
                                $bdpromotion = new BdPromotion();
                                $promotions = $bdpromotion->getPromotionById($bulletin['affectationServiceId']);
                                foreach ($promotions as $promotion) {
                                    if (1) {
                                        ?>
                                        <td style="font-weight: bold;"><?= $k ?></td>
                                        <td style="font-weight: bold;"><?= $promotion['matricule'] ?></td>


                                        <td style="font-weight: bold;"><?= $promotion['nom'] . " " . $promotion['postnom'] . " " . $promotion['prenom'] . " / Sexe: " . $promotion['sexe'] ?></td>


                                        <td style="font-weight: bold;"><?= $promotion['ctDesignation'] ?></td>


                                        <td style="font-weight: bold;"><?= $promotion['sDesignation'] ?></td>


                                        <td style="font-weight: bold;"><?= $promotion['fDesignation'] ?></td>

                                        <?php
                                        $idchargeconf = 0;
                                        $bdchargeconf = new BdChargeConf();
                                        $chargeconfs = $bdchargeconf->getChargeConfById($bulletin['chargeConfId']);
                                        foreach ($chargeconfs as $chargeconf) {
                                            if ($chargeconf['ccActive']) {
                                                ?>
                                                <td style="font-weight: bold;"><?= $chargeconf['etatCivil'] . "  / Nbre enfant: " . $chargeconf['nombreEnfant'] . "  / Personne en charge: " . $chargeconf['nombreFemme'] ?></td>
                                                <?php
                                                $idchargeconf = $chargeconf['ccId'];
                                                $nombre_enfant = $chargeconf['nombreEnfant'];
                                            }
                                        }
                                        ?>

                                        <td style="font-weight: bold;"><?= $promotion['dateRecrutement'] ?></td>

                                        <td style="font-weight: bold;"><?= $promotion['tcDesignation'] ?></td>

                                        <?php
                                    }
                                }
                                ?>



                                <?php
                                $bdlivrepaie = new BdLivrePaie();
                                $livrepaies = $bdlivrepaie->getLivrePaieById($bulletin['livrePaieId']);
                                foreach ($livrepaies as $livrepaie) {
                                    if ($livrepaie['active']) {
                                        ?>
                                        <td style="color: blue;font-size: 15px; font-weight: bold;"><?= $livrepaie['mois'] . " " . $livrepaie['annee'] ?> </td>
                                        <?php
                                    }
                                }
                                ?>

                                <?php
                                $chaine_composantesalaire_selectionnee = "";
                                $bdconfsalaire = new BdConfSalaire();

                                $cumul_nature_salaire = 0;
                                $cumul_nature_retention = 0;
                                $impot_CNSS = 0;
                                $brut_imposable = 0;
                                $item_retenir = 0;
                                $items_composantesalaire = explode('/', $bulletin['chaineComposanteSalaire']);
                                $bdconfsalaire = new BdConfSalaire();
                                foreach ($items_composantesalaire as $item_composantesalaire) {
                                    if ($item_composantesalaire != "") {
                                        $items_contenue = explode('-', $item_composantesalaire);

                                        $id_confsalaire_item = $items_contenue[0];
                                        $chaine_composantesalaire_selectionnee = $chaine_composantesalaire_selectionnee . $id_confsalaire_item . "-";
                                        $quantite_item = $items_contenue[1];
                                        $confsalaires = $bdconfsalaire->getConfSalaireById($id_confsalaire_item);
                                        $trouve = false;
                                        foreach ($confsalaires as $confsalaire) {
                                            if (1) {
                                                if (1) {
                                                    if ($confsalaire['nature'] == "salaire") {
                                                        if (1) {
                                                            ?>
                                                            <td><?= $confsalaire['designation'] . " : \n " . ($confsalaire['taux'] * $quantite_item) ?> USD </td>
                                                            <?php
                                                        }
                                                        ?>

                                                        <?php
                                                    } else if ($confsalaire['nature'] == "retention") {
                                                        if ($confsalaire['designation'] == "CNSS") {
//                                                    echo ($brut_imposable);
//                                                    echo ($confsalaire['taux'] *  * $brut_imposable);
                                                            if (1) {
                                                                ?>
                                                                <td><?= $confsalaire['designation'] . " : \n " . ($confsalaire['taux'] * $quantite_item * $brut_imposable) ?> USD </td>
                                                                <?php
                                                                $cumul_impot_CNSS = $cumul_impot_CNSS + (($confsalaire['taux'] * $quantite_item * $brut_imposable));
                                                                $item_retenir = $item_retenir + ($confsalaire['taux'] * $quantite_item * $brut_imposable);
                                                            }
                                                        } else if ($confsalaire['designation'] == "Impot") {
                                                            $net_imposable = (($brut_imposable) - ($impot_CNSS * $brut_imposable));
                                                            $valeur_brut_IPR = ($net_imposable * ($confsalaire['taux'] * $quantite_item));
                                                            $impot_IPR = $valeur_brut_IPR - ($valeur_brut_IPR * ((2 / 100) * $nombre_enfant));
//                                                        $impot_IPR = ($net_imposable * ($confsalaireUp['taux'] * $quantite_item)) * ((2 / 100) * $nombre_enfant);
                                                            if (1) {
                                                                ?>
                                                                <td><?= $confsalaire['designation'] . " : \n " . ($impot_IPR) ?> USD </td>
                                                                <?php
                                                                $cumul_impot_IPR = $cumul_impot_IPR + $impot_IPR;
                                                                $item_retenir = $item_retenir + ($impot_IPR);
                                                            }
                                                        } else {
                                                            if (1) {
                                                                ?>
                                                                <td><?= $confsalaire['designation'] . " : \n " . ($confsalaire['taux'] * $quantite_item) ?></td>
                                                                <?php
                                                                $item_retenir = $item_retenir + ($confsalaire['taux'] * $quantite_item);
                                                            }
                                                        }
                                                    }
                                                    ?>

                                                    </form>
                                                    <?php
                                                    if ($confsalaire['designation'] == "CNSS") {
                                                        $impot_CNSS = ($confsalaire['taux'] * $quantite_item);
                                                    }
                                                    if ($confsalaire['designation'] == "Impot") {
                                                        $net_imposable = (($brut_imposable) - ($impot_CNSS * $brut_imposable));
                                                        $valeur_brut_IPR = ($net_imposable * ($confsalaire['taux'] * $quantite_item));
                                                        $impot_IPR = $valeur_brut_IPR - ($valeur_brut_IPR * ((2 / 100) * $nombre_enfant));

//                                                echo  $cumul_impot_IPR;
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
                                                } else {
                                                    ?>

                                                    <?php
                                                }
                                            } else {
                                                
                                            }
                                        }
                                    }
                                }
                                ?>

                                <td style="color: orange;font-size: 18px;font-weight: bold;">Total Brut : <?= $cumul_nature_salaire ?> USD </td>
                                <td style="color: dodgerblue;font-size: 18px;font-weight: bold;">Brut imposable : <?= $brut_imposable ?> USD </td>
                                <td style="color: dodgerblue;font-size: 18px;font-weight: bold;">Net imposable : <?= (($brut_imposable) - ($impot_CNSS * $brut_imposable)) ?> USD </td>
                                <td style="color: orange;font-size: 18px;font-weight: bold;">Total à retenir : <?= $item_retenir ?> USD </td>
                                <td style="color: forestgreen;font-size: 18px;font-weight: bold;">Net à payer : <?= (($cumul_nature_salaire) - ($item_retenir)) ?> USD </td>
                                <?php
                                $net_a_payer = (($cumul_nature_salaire) - ($item_retenir));
                                $net_imposable = (($brut_imposable) - ($impot_CNSS * $brut_imposable));
                                $cumul_net_a_payer = $cumul_net_a_payer + $net_a_payer;
                                ?>


                                <?php
                                $bdconfimposition = new BdConfImposition();
                                $cumul_contribution = 0;
                                $chaine_composante_imposition = "";

                                $items_composanteimposition = explode('-', $bulletin['chaineComposanteImposition']);
                                foreach ($items_composanteimposition as $item_composanteimposition) {

                                    if (($item_composanteimposition != "")) {
                                        $confimpositions = $bdconfimposition->getConfImpositionById($item_composanteimposition);
                                        foreach ($confimpositions as $confimposition) {
                                            if (1) {
                                                ?>
                                                <td><?= $confimposition['designation'] . "  : \n  " . (($confimposition['pourcentage'] / 100) * $brut_imposable) ?></td>
                                                <?php
                                                $chaine_composante_imposition = $chaine_composante_imposition . $confimposition['id'] . "-";
                                                $cumul_contribution = $cumul_contribution + (($confimposition['pourcentage'] / 100) * $brut_imposable);
                                            }
                                        }
                                    }
                                }

                                $cumul_charge_totale = $cumul_charge_totale + ($cumul_contribution + $net_a_payer);
                                ?> 

                                <td style="color:red;font-size: 18px;font-weight: bold;">Total charges : <?= ($cumul_contribution + $net_a_payer) ?> USD</td>
                                <td>
                                    <a style="font-size: 20px;" href='../views/administrator/bulletin/pdf_bulletinpaie_self.php?use_livrepaie=<?= $bulletin['livrePaieId'] . '&use_chaine_composantesalaire=' . $bulletin['chaineComposanteSalaire'] . '&use_affectationservice=' . $bulletin['affectationServiceId'] . '&use_compte=' . $bulletin['compteId'] . '&use_datecreation=' . $bulletin['dateCreation'] ?>' class="btn btn-primary pull-left">Print</a>
                                </td>

                            </tr>
                            <?php
                        }
                    }
                    ?>

                </tbody>
                <tfoot style="color: dodgerblue;font-size: 15px;font-weight: bold;">
                <td><?= "Total CNSS : " . $cumul_impot_CNSS ?> USD </td>
                <td><?= "Total IPR : " . $cumul_impot_IPR ?> USD </td>
                <td><?= "Total Net à payer : " . $cumul_net_a_payer ?> USD </td>
                <td><?= "Totaux charges : " . $cumul_charge_totale ?> USD </td>
                </tfoot>
            </table>

        </div>

    </div>

</div>


