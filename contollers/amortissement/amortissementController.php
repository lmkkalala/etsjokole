<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../../models/connexion.php';

include '../../models/amortissement/Amortissement.php';
?>
<?php

function securise($donnee) {
    $donnee = trim($donnee);
    $donnee = stripslashes($donnee);
    $donnee = strip_tags($donnee);
    return $donnee;
}

if (isset($_POST['bt_enregistrer'])) {
    $dateDebut = securise($_POST['tb_dateDebut']);
    $prixAcquisition = securise($_POST['tb_prixAcquisition']);
    $duree = securise($_POST['tb_duree']);
    $uniteId = securise($_POST['tb_idunite']);
    if ($dateDebut != "" && $prixAcquisition != "" && $uniteId!="" && $duree!="") {
        $bdAmortissement=new BdAmortissement();
        if ($bdAmortissement->addAmortissement($dateDebut,$prixAcquisition,$duree,$uniteId)) {
            $error = "succes";
        } else {
            $error = "traitement_error";
        }
    } else {
        $error = "remplissage_error";
    }
    header('Location:../../views/home.php?reponse=' . sha1($error) . '&link=' . sha1("logistique_amortissement_add"). '&use_unite=' . ($uniteId). '&link_up=' . sha1("home_logistique_amortissement"));
}

if (isset($_POST['bt_modifier'])) {
    $idattribution = securise($_POST['tb_idattribution']);
    $idbiens = securise($_POST['cb_biens']);
    $idfournisseur = securise($_POST['cb_fournisseur']);
    $date = securise($_POST['tb_date']);
    $delai = securise($_POST['tb_delai']);
    $quantite = securise($_POST['tb_quantite']);
    if ($idattribution != "" && $idbiens != 0 && $idfournisseur != 0 && $date != "" && $delai > 0 && $quantite > 0) {
        $bdattributionbiens=new BdAttributionBiens();
        if ($bdattributionbiens->updateAttributionBiens($idattribution, $date, $quantite, $delai, $idbiens, $idfournisseur)) {
            $reponse = "succes";
        } else {
            $reponse = "traitement_error";
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("logistique_attribution_biens_update_attribution_biens_all") . '&reponse=' . sha1($reponse) . '&link_up=' . sha1("home_logistique_attribution_biens"));
}

if (isset($_POST['bt_delete'])) {
    $amortissementId = securise($_POST['tb_idamortissement']);
    $uniteId = securise($_POST['tb_idunite']);
    if ($amortissementId != "" && $uniteId != "") {
        $bdAmortissement = new BdAmortissement();
        if (1) {
            if ($bdAmortissement->deleteAmortissement($amortissementId)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("logistique_amortissement_add") . '&reponse=' . sha1($reponse). '&use_unite=' . ($uniteId) . '&link_up=' . sha1("home_logistique_amortissement"));
}

if (isset($_POST['bt_search_for_biens'])) {
    $reponse = "search_results";
    $motcle = $_POST['cb_biens'];
    header('Location:../../views/home.php?link=' . sha1("logistique_amortissement_liste_all") . '&use=' . ($motcle) . '&link_up=' . sha1("home_logistique_unite"));
}

if (isset($_POST['bt_active'])) {
    $idtaux = securise($_POST['tb_idtaux']);
    $operation = securise($_POST['tb_operation']);
    if ($idtaux != "" && $operation != "") {
        $bdtaux = new BdTaux();
        if ($operation == "active") {
            if ($bdtaux->activeTaux($idtaux)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        } else {
            if ($bdtaux->desactiveTaux($idtaux)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("logistique_taux_active_taux_all") . '&reponse=' . sha1($reponse) . '&link_up=' . sha1("home_logistique_taux"));
}

if (isset($_POST['bt_search'])) {
    $reponse = "search_results";
    $motcle = $_POST['tb_search'];
    header('Location:../../views/home.php?link=' . sha1("logistique_attribution_biens_fiche_attribution_fournisseur_all") . '&use=' . ($motcle) . '&link_up=' . sha1("home_logistique_attribution_biens"));
}

if (isset($_POST['bt_search_for_biens_logistique'])) {
    $reponse = "search_results";
    $motcle = $_POST['tb_search'];
    header('Location:../../views/home.php?link=' . sha1("logistique_demande_fiche_biens_demande_all") . '&use=' . ($motcle) . '&link_up=' . sha1("home_logistique_demande"));
}

if (isset($_POST['bt_view'])) {
    $reponse = $_POST['tb_idattribution'];
    header('Location:../../views/home.php?link=' . sha1("logistique_attribution_biens_fiche_attribution_fournisseur_self") . '&use=' . ($reponse) . '&link_up=' . sha1("home_logistique_attribution_biens"));
}

if (isset($_POST['bt_view_for_biens'])) {
    $reponse = $_POST['tb_idbiens'];
    header('Location:../../views/home.php?link=' . sha1("service_demande_fiche_biens_demande_self") . '&use=' . ($reponse) . '&link_up=' . sha1("home_service_demande"));
}

if (isset($_POST['bt_view_for_biens_logistique'])) {
    $reponse = $_POST['tb_idbiens'];
    header('Location:../../views/home.php?link=' . sha1("logistique_demande_fiche_biens_demande_self") . '&use=' . ($reponse) . '&link_up=' . sha1("home_logistique_demande"));
}

if (isset($_POST['bt_view_for_service'])) {
    $reponse = $_POST['tb_idservice'];
    header('Location:../../views/home.php?link=' . sha1("logistique_demande_fiche_service_demande_self") . '&use=' . ($reponse) . '&link_up=' . sha1("home_logistique_demande"));
}

if (isset($_POST['bt_encours_self'])) {
    $idbiens=$_POST['tb_idbiens'];
    $reponse="get_encours_self";
    header('Location:../../views/home.php?link=' . sha1("service_demande_fiche_biens_demande_self") . '&reponse=' . sha1($reponse) . '&use='.($idbiens).'&link_up=' . sha1("home_service_demande"));
}

if (isset($_POST['bt_encours_self_logistique'])) {
    $idbiens=$_POST['tb_idbiens'];
    $reponse="get_encours_self_logistique";
    header('Location:../../views/home.php?link=' . sha1("logistique_demande_fiche_biens_demande_self") . '&reponse=' . sha1($reponse) . '&use='.($idbiens).'&link_up=' . sha1("home_logistique_demande"));
}

if (isset($_POST['bt_encours_self_logistique_service'])) {
    $idservice=$_POST['tb_idservice'];
    $reponse="get_encours_self_logistique_service";
    header('Location:../../views/home.php?link=' . sha1("logistique_demande_fiche_service_demande_self") . '&reponse=' . sha1($reponse) . '&use='.($idservice).'&link_up=' . sha1("home_logistique_demande"));
}

if (isset($_POST['bt_for_amortissement'])) {
    $idunite=$_POST['tb_idunite'];
    header('Location:../../views/home.php?link=' . sha1("logistique_amortissement_add") . '&reponse=' . sha1($reponse) . '&use_unite='.($idunite).'&link_up=' . sha1("home_logistique_amortissement"));
}

if (isset($_POST['bt_for_dotation'])) {
    $uniteId=$_POST['tb_idunite'];
    $amortissementId=$_POST['tb_idamortissement'];
    header('Location:../../views/home.php?link=' . sha1("logistique_dotation_add") . '&reponse=' . sha1($reponse) . '&use_unite='.($uniteId). '&use_amortissement='.($amortissementId).'&link_up=' . sha1("home_logistique_dotation"));
}

?>

