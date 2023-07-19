<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../../models/connexion.php';

include '../../models/attribution-biens/attributionBiens.php';
include '../../models/biens/biens.php';

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
    $idfournisseur = securise($_POST['tb_idfournisseur']);
    $date = securise($_POST['tb_date']);
    $quantite = securise($_POST['tb_quantite']);
    $prixorder = securise($_POST['tb_prixorder']);
    $numeroOrder = securise($_POST['tb_numero_order_down']);
    if ($idbiens != 0 && $idfournisseur != 0 && $date != "" && $quantite > 0 && $prixorder!="0" && $prixorder!="" && $numeroOrder!="") {
        $bdbiens=new BdBiens();
        $biens=$bdbiens->getBiensById($idbiens);
        foreach ($biens as $bien) {
            $prix_unitaire_actuelle=$prixorder;
        }
        $bdattributionbiens = new BdAttributionBiens();
        if ($bdattributionbiens->addAttributionBiens($date, (2), $quantite,$prix_unitaire_actuelle,$numeroOrder, $idfournisseur, $idbiens)) {
            $error = "succes";
        } else {
            $error = "traitement_error";
        }
    } else {
        $error = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("logistique_attribution_biens_add") . '&use_fournisseur=' . ($idfournisseur). '&use_dateRecent=' . ($date). '&use_numeroOrder=' . ($numeroOrder) . '&reponse=' . sha1($error) . '&link_up=' . sha1("home_logistique_attribution_biens")."#selectProduct");
}

if (isset($_POST['bt_delete_attribution_biens'])) {
    $idattributionbiens = securise($_POST['tb_idattributionbiens']);
    $idfournisseur = securise($_POST['tb_idfournisseur']);
    if ($idattributionbiens != 0 && $idfournisseur != "") {
        $bdattributionbiens = new BdAttributionBiens();
        if ($bdattributionbiens->deleteAttributionBiens($idattributionbiens)) {
            $reponse = "succes_deleted";
        } else {
            $reponse = "traitement_error";
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("logistique_attribution_biens_add") . '&use_fournisseur=' . ($idfournisseur) . '&reponse=' . sha1($reponse) . '&link_up=' . sha1("home_logistique_attribution_biens"));
    die;
}

if (isset($_POST['bt_modifier'])) {
    $idattribution = securise($_POST['tb_idattribution']);
    $idbiens = securise($_POST['cb_biens']);
    $idfournisseur = securise($_POST['cb_fournisseur']);
    $date = securise($_POST['tb_date']);
    $delai = securise($_POST['tb_delai']);
    $quantite = securise($_POST['tb_quantite']);
    $prix = securise($_POST['tb_prix']);
    if ($idattribution != "" && $idbiens != 0 && $idfournisseur != 0 && $date != "" && $delai > 0 && $quantite > 0) {
        $bdattributionbiens = new BdAttributionBiens();
        if ($bdattributionbiens->updateAttributionBiens($idattribution, $date, $quantite, $delai, $idbiens, $idfournisseur, $prix)) {
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
    header('Location:../../views/home.php?link=' . sha1("logistique_attribution_biens_fiche_biens_attribution_all") . '&use=' . ($motcle) . '&link_up=' . sha1("home_logistique_attribution_biens"));
}

if (isset($_POST['bt_view'])) {
    $reponse = $_POST['tb_idattribution'];
    header('Location:../../views/home.php?link=' . sha1("logistique_attribution_biens_fiche_attribution_fournisseur_self") . '&use=' . ($reponse) . '&link_up=' . sha1("home_logistique_attribution_biens"));
}

if (isset($_POST['bt_view_for_biens'])) {
    $reponse = $_POST['tb_idbiens'];
    header('Location:../../views/home.php?link=' . sha1("logistique_attribution_biens_fiche_biens_attribution_self") . '&use=' . ($reponse) . '&link_up=' . sha1("home_logistique_attribution_biens"));
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

if (isset($_POST['bt_select_fournisseur_for_add_attribution_biens'])) {
    $idfournisseur = $_POST['cb_fournisseur'];
    header('Location:../../views/home.php?link=' . sha1("logistique_attribution_biens_add") . '&use_fournisseur=' . ($idfournisseur) . '&link_up=' . sha1("home_logistique_attribution_biens"));
}

if (isset($_POST['bt_search_attributionbiens_by_date'])) {
    $date1 = $_POST['tb_date1'];
    $date2 = $_POST['tb_date2'];
    $numeroOrder = $_POST['cb_numeroOrder'];
    $idfournisseur = $_POST['tb_idfournisseur'];
    header('Location:../../views/home.php?link=' . sha1("logistique_attribution_biens_fiche_attribution_fournisseur_self") . '&use=' . ($idfournisseur). '&use_numeroOrder=' . ($numeroOrder). '&use_date1=' . ($date1). '&use_date2=' . ($date2) . '&link_up=' . sha1("home_logistique_attribution_biens"));
}

?>

