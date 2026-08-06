<?php
session_start();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../../models/connexion.php';

include '../../models/demande/demande.php';
?>
<?php

function securise($donnee) {
    $donnee = trim($donnee);
    $donnee = stripslashes($donnee);
    $donnee = strip_tags($donnee);
    return $donnee;
}

if (isset($_POST['bt_enregistrer'])) {
    $idbiens = securise($_POST['cb_biens']);
    $idaffectation = securise($_POST['tb_idaffectation']);
    $date = securise($_POST['tb_date']);
    $quantite = securise($_POST['tb_quantite']);
    $qualiteDemandeur= securise($_SESSION['type']);
    $idpreparation= securise($_POST['tb_idpreparation']);
    if ($idbiens != 0 && $idaffectation != 0 && $date != "" && $quantite > 0 && $qualiteDemandeur != "" && $idpreparation!=0) {
        $bddemande=new BdDemande();
        if ($bddemande->addDemande($date, $quantite,$idbiens, $idaffectation,$qualiteDemandeur,$idpreparation)) {
            $error = "succes";
        } else {
            $error = "traitement_error";
        }
    } else {
        $error = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("service_demande_add") .  '&use_preparation=' . ($idpreparation).'&reponse=' . sha1($error) . '&link_up=' . sha1("home_service_demande")."#selectProduct");
    die;
    
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

if (isset($_POST['bt_delete_demande_service'])) {
    $idpreparation= securise($_POST['tb_idpreparation']);
    $iddemande = securise($_POST['tb_iddemande']);
    if ($iddemande != 0 && $iddemande != "") {
        $bddemande=new BdDemande();
        if ($bddemande->deleteDemande($iddemande)) {
            $reponse = "succes_deleted";
        } else {
            $reponse = "traitement_error";
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("service_demande_add").'&use_preparation=' . ($idpreparation) . '&reponse=' . sha1($reponse) . '&link_up=' . sha1("home_service_demande")."#selectProduct");
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
    header('Location:../../views/home.php?link=' . sha1("logistique_attribution_biens_fiche_attribution_fournisseur_all") . '&use=' . ($motcle) . '&link_up=' . sha1("home_logistique_attribution_biens"));
}

if (isset($_POST['bt_search_for_biens'])) {
    $reponse = "search_results";
    $motcle = $_POST['tb_search'];
    header('Location:../../views/home.php?link=' . sha1("service_demande_fiche_biens_demande_all") . '&use=' . ($motcle) . '&link_up=' . sha1("home_service_demande"));
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

if (isset($_POST['bt_encours_fournisseur_self'])) {
    $idfournisseur=$_POST['tb_idfournisseur'];
    $reponse="get_encours_fournisseur_self";
    header('Location:../../views/home.php?link=' . sha1("logistique_attribution_biens_fiche_attribution_fournisseur_self") . '&reponse=' . sha1($reponse) . '&use='.($idfournisseur).'&link_up=' . sha1("home_logistique_attribution_biens"));
}

if (isset($_POST['bt_finalise_distribution'])) {
    $iddemande = securise($_POST['tb_id_demande']);
    if ($iddemande != "") {
        $bddemande=new BdDemande();
        if ($bddemande->finaliseDistributionDemande($iddemande)) {
            $error = "succes";
        } else {
            $error = "traitement_error";
        }
    } else {
        $error = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("service_demande_liste_demande_encours_interne") . '&reponse=' . sha1($error) . '&link_up=' . sha1("home_service_demande"));
}

if (isset($_POST['bt_select_preparation_for_add_demande'])) {
    $idpreparation=$_POST['cb_preparation'];
    header('Location:../../views/home.php?link=' . sha1("service_demande_add") . '&reponse=' . sha1($reponse) . '&use_preparation='.($idpreparation).'&link_up=' . sha1("home_service_demande"));
}

?>

