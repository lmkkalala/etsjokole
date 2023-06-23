<?php
session_start();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../../models/connexion.php';

include '../../models/livraison/livraison.php';
include '../../models/biens/biens.php';
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
    $iddemande = securise($_POST['cb_demande']);
    $idaffectation = securise($_SESSION['idaffectation']);
    $date = securise($_POST['tb_date']);
    $quantite = securise($_POST['tb_quantite']);
    if ($iddemande != 0 && $idaffectation != 0 && $date != "" && $quantite > 0) {
        $bdlivraison=new BdLivraison();
        if ($bdlivraison->addLivraison($date, $quantite, $iddemande, $idaffectation)) {
            $bddemande=new BdDemande();
            if ($bddemande->finaliseDemande($iddemande)) {
                $bdbiens=new BdBiens();
                $bddemande=new BdDemande();
                $demandes=$bddemande->getDemandeById($iddemande);
                foreach ($demandes as $demande) {
                    $idbiens=$demande['bId'];
                    $newquantite=$demande['quantite'];
                }
                $newquantite=$newquantite-$quantite;
                if ($bdbiens->diminueQuantiteBiens($idbiens, $newquantite)) {
                    $error = "succes";
                } else {
                    $error = "traitement_error";
                }
            } else {
                $error = "traitement_error";
            }
            
        } else {
            $error = "traitement_error";
        }
    } else {
        $error = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("logistique_livraison_add") . '&reponse=' . sha1($error) . '&link_up=' . sha1("home_logistique_livraison"));
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
    header('Location:../../views/home.php?link=' . sha1("service_reception_fiche_biens_reception_all") . '&use=' . ($motcle) . '&link_up=' . sha1("home_service_reception"));
}

if (isset($_POST['bt_view'])) {
    $reponse = $_POST['tb_idattribution'];
    header('Location:../../views/home.php?link=' . sha1("logistique_attribution_biens_fiche_attribution_fournisseur_self") . '&use=' . ($reponse) . '&link_up=' . sha1("home_logistique_attribution_biens"));
}

if (isset($_POST['bt_view_for_biens'])) {
    $reponse = $_POST['tb_idbiens'];
    header('Location:../../views/home.php?link=' . sha1("service_reception_fiche_biens_reception_self") . '&use=' . ($reponse) . '&link_up=' . sha1("home_service_reception"));
}

if (isset($_POST['bt_view_for_service'])) {
    $idservice = $_POST['tb_idservice'];
    header('Location:../../views/home.php?link=' . sha1("logistique_livraison_fiche_service_livraison_self") . '&use=' . ($idservice) . '&link_up=' . sha1("home_logistique_livraison"));
}

if (isset($_POST['bt_encours_self'])) {
    $idbiens=$_POST['tb_idbiens'];
    $reponse="get_encours_self";
    header('Location:../../views/home.php?link=' . sha1("logistique_attribution_biens_fiche_biens_attribution_self") . '&reponse=' . sha1($reponse) . '&use='.($idbiens).'&link_up=' . sha1("home_logistique_attribution_biens"));
}

if (isset($_POST['bt_search_by_dates'])) {
//    echo "dedans";die;
    $date=$_POST['tb_date'];
    header('Location:../../views/home.php?link=' . sha1("service_reception_liste_reception_all") . '&reponse=' . sha1($reponse). '&date=' . ($date) .'&link_up=' . sha1("home_service_reception"));
}

if (isset($_POST['bt_search_by_dates_inventory'])) {
//    echo "dedans";die;
    $date=$_POST['tb_date'];
    header('Location:../../views/home.php?link=' . sha1("service_reception_inventory") . '&reponse=' . sha1($reponse). '&date=' . ($date) .'&link_up=' . sha1("home_service_reception"));
}

?>

