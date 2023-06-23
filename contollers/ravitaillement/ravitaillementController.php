<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 session_start();

include '../../models/connexion.php';
include '../../models/connexionF.php';

include '../../models/ravitaillement/ravitaillement.php';
include '../../models/attribution-biens/attributionBiens.php';
include '../../models/biens/biens.php';
include '../../models/unite/unite.php';
include '../../models/operationF/OperationF.php';
include '../../models/crud/db.php';
$db = new DB();
?>
<?php

function securise($donnee) {
    $donnee = trim($donnee);
    $donnee = stripslashes($donnee);
    $donnee = strip_tags($donnee);
    return $donnee;
}

if (isset($_POST['bt_modifier'])) {
    $idattribution = securise($_POST['cb_commande']);
    $date = securise($_POST['tb_date']);
    $quantite = securise($_POST['tb_quantite']);
    $prix = securise($_POST['tb_prix']);
    $dateexpiration = securise($_POST['tb_dateexpiration']);
    $delai = securise($_POST['tb_delai']);
    $type = securise($_POST['cb_type']);
    if ($idattribution != 0 && $date != "" && $quantite > 0 && $prix > 0 && $dateexpiration != "" && $delai >= 0 && $type != 0) {
        $bdravitaillement = new BdRavitaillement();
        // if ($bdravitaillement->addRavitaillement($date, $quantite, $prix, $dateexpiration, $delai, $type, $idattribution)) {
            $error = "succes";
        // } else {
        //     $error = "traitement_error";
        // }
    } else {
        $error = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("logistique_ravitaillement_add") . '&reponse=' . sha1($error) . '&link_up=' . sha1("home_logistique_ravitaillement"));
}

if (isset($_POST['bt_enregistrer'])) {
    $idattribution = securise($_POST['tb_idattributionbiens']);
    $date = securise($_POST['tb_date']);
    $quantite = securise($_POST['tb_quantite']);
    $prix = securise($_POST['tb_prix']);
    $dateexpiration = securise($_POST['tb_dateexpiration']);
    $idfournisseur = securise($_POST['tb_idfournisseur']);
    $date1 = securise($_POST['tb_date1']);
    $date2 = securise($_POST['tb_date2']);
    $numeroOrder = securise($_POST['tb_numeroOrder']);

    $libelle="";
    $type="";
    $responsable="";
    $domaine="";

    if (securise($_POST['tb_tva']) == "") {
        $pourcentageTVA = 0;
    } else {
        $pourcentageTVA = securise($_POST['tb_tva']);
    }
//    echo $date; die;
    if ($idattribution != 0 && $date != "" && $quantite != "0") {

        $stockage_quantity = 0;
            $received_stockage = $db->getWhere('stockage','attribution_id',$idattribution);
            foreach ($received_stockage as $key => $value) {
                $stockage_quantity = $stockage_quantity + $value['quantite'];
            }

            $stockage_quantity = $stockage_quantity + $quantite;

            $quantite_received = $db->getWhere('attribution','id',$idattribution);

            if ($stockage_quantity > $quantite_received[0]['quantite_minimale']) {
                $reponse = "traitement_error";
                header('Location:../../views/home.php?link=' . sha1("logistique_ravitaillement_add") . '&reponse=' . sha1($reponse) . '&use_fournisseur=' . ($idfournisseur) . '&use_numeroOrder=' . ($numeroOrder) . '&use_date1=' . ($date1) . '&use_date2=' . ($date2) . '&link_up=' . sha1("home_logistique_ravitaillement"));
                return;
            }
            $bdravitaillement = new BdRavitaillement();
        if ($bdravitaillement->addRavitaillement($date, $quantite, $prix, $pourcentageTVA, $dateexpiration, (2), ("total"), $idattribution)) {
            $bdattributionbiens = new BdAttributionBiens();
            
            if($stockage_quantity == $quantite_received[0]['quantite_minimale']){
                $finaliser = $bdattributionbiens->finaliseAttribution($idattribution);
            }else{
                $finaliser = true;
            }
            
            if ($finaliser) {
                $attributions = $bdattributionbiens->getAttributionBiensById($idattribution);
                foreach ($attributions as $attribution) {
                    $idbiens = $attribution['bId'];
                    $newquantite = $attribution['quantite'];
                    $libelle="Purchase "." Item: ".$attribution['bDesignation']." Qty: ".$quantite." Date: ".$date;
                }
                $newquantite = $newquantite + $quantite;
                $bdbiens = new BdBiens();
                $panier = "";
                if ($bdbiens->augmenteQuantiteBiens($idbiens, $newquantite)) {
                    $bdunite = new BdUnite();
                    for ($i = 0; $i < $quantite; $i++) {
                        $code = $idbiens . "-" . $idattribution . "-" . ($i + 1);
                        $panier = $panier . "/" . $code;
                        if ($bdunite->addUnite($code, $date, $dateexpiration, $idbiens,$prix) == false) {
                            $reponse = "traitement_error";
                        }
                    }

                    $type="out";
                    $responsable=$_SESSION['identite'];
                    $domaine="purchase";

                    $bdOperationF=new BdOperationF();
                    $bdOperationF->addOperation($libelle,$type,$responsable,$domaine,($quantite * $prix));
                    $reponse = "succes";
                } else {
                    $reponse = "traitement_error";
                }
            } else {
                $reponse = "traitement_error";
            }
        } else {
            $reponse = "traitement_error";
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("logistique_ravitaillement_add") . '&reponse=' . sha1($reponse) . '&use_fournisseur=' . ($idfournisseur) . '&use_numeroOrder=' . ($numeroOrder) . '&use_date1=' . ($date1) . '&use_date2=' . ($date2) . '&link_up=' . sha1("home_logistique_ravitaillement"));
    die;
}



if (isset($_POST['bt_update_date'])) {
    $date1 = $_POST['tb_date1'];
    $date2 = $_POST['tb_date2'];
    $idbiens = $_POST['tb_idbiens'];
    $idfournisseur = $_POST['tb_idfournisseur'];
    $idravitaillement = $_POST['tb_idravitaillement'];
    $newdate = $_POST['tb_newdate'];

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

//    echo $idlivraison; die;

    if ($newdate != "") {
        $bdravitaillement = new BdRavitaillement();
        if ($bdravitaillement->updateDateRavitaillement($idravitaillement, $newdate)) {
//            echo "dedans"; die;
            $reponse = "succes_edited";
        } else {
            $reponse = "traitement_error";
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("logistique_ravitaillement_liste_ravitaillement_all") . '&use_date1=' . ($date1) . '&use_date2=' . ($date2) . '&use_biens=' . ($idbiens) . '&use_fournisseur=' . ($idfournisseur) . '&link_up=' . sha1("home_logistique_ravitaillement"));
    die;
}


if (isset($_POST['bt_delete_ravitaillement'])) {
    $date1 = $_POST['tb_date1'];
    $date2 = $_POST['tb_date2'];
    $quantite = $_POST['tb_quantite'];
    $idbiens = $_POST['tb_idbiens'];
    $idfournisseur = $_POST['tb_idfournisseur'];
    $idravitaillement = $_POST['tb_idravitaillement'];

//    echo $idlivraison; die;

    $id_attributionbiens = "";
    if ($idravitaillement != "") {
        $bdattributionbiens = new BdAttributionBiens();
        $bdbiens = new BdBiens();
        $bdunite = new BdUnite();
        $bdravitaillement = new BdRavitaillement();
        $ravitaillements = $bdravitaillement->getRavitaillementById($idravitaillement);
        foreach ($ravitaillements as $ravitaillement) {
            $id_attributionbiens = $ravitaillement['attribution_id'];
        }

        $actual_quantite = 0;

        $attributions = $bdattributionbiens->getAttributionBiensById($id_attributionbiens);
        foreach ($attributions as $attribution) {
            $idbiens = $attribution['bId'];
            $actual_quantite = $attribution['quantite'];
        }

        $newquantite = $actual_quantite - $quantite;

        if ($newquantite >= 0) {
            if ($bdravitaillement->deleteRavitaillement($idravitaillement)) {
//            echo "dedans"; die;
                if ($bdbiens->diminueQuantiteBiens($idbiens, $newquantite)) {
                    $reponse = "succes_deleted";
                } else {
                    $reponse = "traitement_error";
                }


                if ($bdunite->deleteUniteByName($id_attributionbiens)) {
                    $reponse = "succes_deleted";
                }
            } else {
                $reponse = "traitement_error";
            }
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("logistique_ravitaillement_liste_ravitaillement_all") . '&link_up=' . sha1("home_logistique_ravitaillement") . '&reponse=' . sha1($reponse));
    die;
}


if (isset($_POST['bt_active'])) {
    $idbiens = securise($_POST['tb_idbiens']);
    $operation = securise($_POST['tb_operation']);
    if ($idbiens != "" && $operation != "") {
        $bdbiens = new BdBiens();
        if ($operation == "active") {
            if ($bdbiens->activeBiens($idbiens)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        } else {
            if ($bdbiens->desactiveBiens($idbiens)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("logistique_biens_active_biens_all") . '&reponse=' . sha1($reponse) . '&link_up=' . sha1("home_logistique_biens"));
}

if (isset($_POST['bt_search'])) {
    $reponse = "search_results";
    $motcle = $_POST['tb_search'];
    header('Location:../../views/home.php?link=' . sha1("logistique_ravitaillement_fiche_ravitaillement_fournisseur_all") . '&use=' . ($motcle) . '&link_up=' . sha1("home_logistique_ravitaillement"));
}

if (isset($_POST['bt_search_for_biens'])) {
    $reponse = "search_results";
    $motcle = $_POST['tb_search'];
    header('Location:../../views/home.php?link=' . sha1("logistique_ravitaillement_fiche_biens_ravitaillement_all") . '&use=' . ($motcle) . '&link_up=' . sha1("home_logistique_ravitaillement"));
}

if (isset($_POST['bt_view'])) {
    $reponse = $_POST['tb_idravitaillement'];
    header('Location:../../views/home.php?link=' . sha1("logistique_ravitaillement_fiche_ravitaillement_fournisseur_self") . '&use=' . ($reponse) . '&link_up=' . sha1("home_logistique_ravitaillement"));
}

if (isset($_POST['bt_view_for_biens'])) {
    $reponse = $_POST['tb_idbiens'];
    header('Location:../../views/home.php?link=' . sha1("logistique_ravitaillement_fiche_biens_ravitaillement_self") . '&use=' . ($reponse) . '&link_up=' . sha1("home_logistique_ravitaillement"));
}

if (isset($_POST['bt_encours_self'])) {
    $idbiens = $_POST['tb_idbiens'];
    $reponse = "get_encours_self";
    header('Location:../../views/home.php?link=' . sha1("logistique_attribution_biens_fiche_biens_attribution_self") . '&reponse=' . sha1($reponse) . '&use=' . ($idbiens) . '&link_up=' . sha1("home_logistique_attribution_biens"));
}

if (isset($_POST['bt_encours_fournisseur_self'])) {
    $idfournisseur = $_POST['tb_idfournisseur'];
    $reponse = "get_encours_fournisseur_self";
    header('Location:../../views/home.php?link=' . sha1("logistique_attribution_biens_fiche_attribution_fournisseur_self") . '&reponse=' . sha1($reponse) . '&use=' . ($idfournisseur) . '&link_up=' . sha1("home_logistique_attribution_biens"));
}

if (isset($_POST['bt_search_by_2dates'])) {
    $date1 = securise($_POST['tb_date1']);
    $date2 = securise($_POST['tb_date2']);
    $idbiens = securise($_POST['cb_biens']);
    $idfournisseur = securise($_POST['cb_fournisseur']);
    $numeroOrder = securise($_POST['cb_numeroOrder']);
    header('Location:../../views/home.php?link=' . sha1("logistique_ravitaillement_liste_ravitaillement_all") . '&use_date1=' . ($date1) . '&use_date2=' . ($date2) . '&use_biens=' . ($idbiens) . '&use_fournisseur=' . ($idfournisseur) . '&use_numeroOrder=' . ($numeroOrder) . '&link_up=' . sha1("home_logistique_ravitaillement"));
}

if (isset($_POST['bt_select_fournisseur_for_add_ravitaillement'])) {
    $idfournisseur = $_POST['cb_fournisseur'];
    $date1 = securise($_POST['tb_date1']);
    $date2 = securise($_POST['tb_date2']);
    $numeroOrder = securise($_POST['cb_numeroOrder']);
    header('Location:../../views/home.php?link=' . sha1("logistique_ravitaillement_add") . '&use_fournisseur=' . ($idfournisseur) . '&use_numeroOrder=' . ($numeroOrder) . '&use_date1=' . ($date1) . '&use_date2=' . ($date2) . '&link_up=' . sha1("home_logistique_ravitaillement"));
}

if (isset($_POST['bt_for_costing'])) {
    $idRavitaillement = $_POST['tb_idravitaillement'];
    header('Location:../../views/home.php?link=' . sha1("logistique_costing_add") . '&use_ravitaillement=' . ($idRavitaillement) . '&link_up=' . sha1("home_logistique_costing"));
}

?>

