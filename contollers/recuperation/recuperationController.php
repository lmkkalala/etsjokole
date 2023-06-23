<?php

session_start();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../../models/connexion.php';

include '../../models/distribution/distribution.php';
include '../../models/livraison/livraison.php';
include '../../models/recuperation/recuperation.php';
include '../../models/unite/unite.php';
?>
<?php

function securise($donnee) {
    $donnee = trim($donnee);
    $donnee = stripslashes($donnee);
    $donnee = strip_tags($donnee);
    return $donnee;
}

if (isset($_POST['bt_enregistrer'])) {
    $iddistribution = securise($_POST['cb_distribution']);
    $idaffectation = securise($_SESSION['idaffectation']);
    $quantite = securise($_POST['tb_quantite']);
    $date = securise($_POST['tb_date']);
    if ($iddistribution != 0 && $idaffectation != 0 && $date != "" && $quantite > 0) {
        $bdrecuperation = new BdRecuperation();
        $bddistribution = new BdDistribution();
        $distributions = $bddistribution->getDistributionById($iddistribution);
        foreach ($distributions as $distribution) {
            $newquantite = $distribution['nombre_restant'];
            $idlivraison = $distribution['distribution_id'];
        }
        if ($quantite <= $newquantite) {
            $newquantite = $newquantite - $quantite;
//            echo $newquantite;die;
            if ($bdrecuperation->addRecuperation($date, $quantite, $iddistribution, $idaffectation)) {

                if ($bddistribution->diminueQuantiteDistribution($iddistribution, $newquantite)) {
                    $bdlivraison = new BdLivraison();
                    $livraisons = $bdlivraison->getLivraisonById($idlivraison);
                    foreach ($livraisons as $livraison) {
                        $new_quantite_actuelle = $livraison['quantite_actuelle'];
                    }
                    $new_quantite_actuelle = $new_quantite_actuelle + $quantite;
                    if ($bdlivraison->augmenteQuantiteLivraison($idlivraison, $new_quantite_actuelle)) {
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
            $error = "quantite_error";
        }
    } else {
        $error = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("service_recuperation_panier_recuperation_add") . '&reponse=' . sha1($error) . '&link_up=' . sha1("home_service_recuperation"));
}

if (isset($_POST['bt_modifier'])) {
    $idattribution = securise($_POST['tb_idattribution']);
    $idbiens = securise($_POST['cb_biens']);
    $idfournisseur = securise($_POST['cb_fournisseur']);
    $date = securise($_POST['tb_date']);
    $delai = securise($_POST['tb_delai']);
    $quantite = securise($_POST['tb_quantite']);
    if ($idattribution != "" && $idbiens != 0 && $idfournisseur != 0 && $date != "" && $delai > 0 && $quantite > 0) {
        $bdattributionbiens = new BdAttributionBiens();
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
    header('Location:../../views/home.php?link=' . sha1("service_recuperation_fiche_biens_recuperation_all") . '&use=' . ($motcle) . '&link_up=' . sha1("home_service_recuperation"));
}

if (isset($_POST['bt_search_for_agent'])) {
    $reponse = "search_results";
    $motcle = $_POST['tb_search'];
    header('Location:../../views/home.php?link=' . sha1("service_recuperation_fiche_agent_recuperation_all") . '&use=' . ($motcle) . '&link_up=' . sha1("home_service_recuperation"));
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

if (isset($_POST['bt_view_for_agent'])) {
    $reponse = $_POST['tb_idagent'];
    header('Location:../../views/home.php?link=' . sha1("service_recuperation_fiche_agent_recuperation_self") . '&use=' . ($reponse) . '&link_up=' . sha1("home_service_recuperation"));
}

if (isset($_POST['bt_view_for_biens'])) {
    $reponse = $_POST['tb_idbiens'];
    header('Location:../../views/home.php?link=' . sha1("service_recuperation_fiche_biens_recuperation_self") . '&use=' . ($reponse) . '&link_up=' . sha1("home_service_recuperation"));
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
    $idbiens = $_POST['tb_idbiens'];
    $reponse = "get_encours_self";
    header('Location:../../views/home.php?link=' . sha1("service_demande_fiche_biens_demande_self") . '&reponse=' . sha1($reponse) . '&use=' . ($idbiens) . '&link_up=' . sha1("home_service_demande"));
}

if (isset($_POST['bt_encours_self_logistique'])) {
    $idbiens = $_POST['tb_idbiens'];
    $reponse = "get_encours_self_logistique";
    header('Location:../../views/home.php?link=' . sha1("logistique_demande_fiche_biens_demande_self") . '&reponse=' . sha1($reponse) . '&use=' . ($idbiens) . '&link_up=' . sha1("home_logistique_demande"));
}

if (isset($_POST['bt_encours_self_logistique_service'])) {
    $idservice = $_POST['tb_idservice'];
    $reponse = "get_encours_self_logistique_service";
    header('Location:../../views/home.php?link=' . sha1("logistique_demande_fiche_service_demande_self") . '&reponse=' . sha1($reponse) . '&use=' . ($idservice) . '&link_up=' . sha1("home_logistique_demande"));
}

if (isset($_POST['bt_encours_fournisseur_self'])) {
    $idfournisseur = $_POST['tb_idfournisseur'];
    $reponse = "get_encours_fournisseur_self";
    header('Location:../../views/home.php?link=' . sha1("logistique_attribution_biens_fiche_attribution_fournisseur_self") . '&reponse=' . sha1($reponse) . '&use=' . ($idfournisseur) . '&link_up=' . sha1("home_logistique_attribution_biens"));
}

if (isset($_POST['bt_enregistrer_panier'])) {
    $m = 0;
    $idrecuperation = securise($_POST['cb_recuperation']);
    $bdrecuperation = new BdRecuperation();
    $recuperations = $bdrecuperation->getRecuperationById($idrecuperation);
    foreach ($recuperations as $recuperation) {
        $quantite_recupere = $recuperation['quantite'];
        $bddistribution = new BdDistribution();
        $distributions = $bddistribution->getDistributionById($recuperation['distribution_id']);
        foreach ($distributions as $distribution) {
            $bdlivraison = new BdLivraison();
            $livraisons = $bdlivraison->getLivraisonById($distribution['distribution_id']);
            foreach ($livraisons as $livraison) {
                $idbiens = $livraison['bId'];
            }
        }
    }
//    echo $quantite_recupere;die;
    $bdunite = new BdUnite();
    $unites = $bdunite->getUniteByIdBiens($idbiens);
    $panier = "";
    foreach ($unites as $unite) {
        if ((isset($_POST['chk_' . $unite['id']]))) {
            $panier = $panier . "/" . $_POST['chk_' . $unite['id']];
            $m++;
        }
    }
//    echo $panier;die;
    if ($idrecuperation != "" && $panier != "" && (($m == $quantite_recupere))) {
        foreach ($unites as $unite) {
            if ((isset($_POST['chk_' . $unite['id']]))) {
                if ($bdunite->activeUniteDistribution($_POST['chk_' . $unite['id']])) {
                    
                }
            }
        }
        if ($bdrecuperation->setPanier($idrecuperation, $panier)) {
            $reponse = "succes";
        } else {
            $reponse = "traitement_error";
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("service_recuperation_add") . '&reponse=' . sha1($reponse) . '&link_up=' . sha1("home_service_recuperation"));
}
?>

