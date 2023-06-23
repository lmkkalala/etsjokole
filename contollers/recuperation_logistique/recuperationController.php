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
include '../../models/biens/biens.php';
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
    header('Location:../../views/home.php?link=' . sha1("service_recuperation_add") . '&reponse=' . sha1($error) . '&link_up=' . sha1("home_service_recuperation"));
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

if (isset($_POST['bt_recuperer'])) {
    $typerepas = securise($_POST['tb_typerepas']);
    $idbiens = securise($_POST['tb_idbiens']);
    $idservice = securise($_POST['tb_idservice']);
    $date1 = securise($_POST['tb_date1']);
    $date2 = securise($_POST['tb_date2']);
    $idlivraison = securise($_POST['tb_idlivraison']);
    if ($idlivraison != "") {
        $bdlivraison = new BdLivraison();
        if ($bdlivraison->recupereLivraison($idlivraison)) {
            $bdbiens = new BdBiens();
            $livraisons = $bdlivraison->getLivraisonById($idlivraison);
            foreach ($livraisons as $livraison) {
                $quantite_biens_last = $livraison['lQuantite'];
                $biens = $bdbiens->getBiensById($livraison['bId']);
                foreach ($biens as $bien) {
                    $quantite_biens = $bien['quantite'];
//                    echo $bien['bId'];die;
                    $quantite_biens = $quantite_biens + $quantite_biens_last;

                    if ($bdbiens->augmenteQuantiteBiens($bien['bId'], $quantite_biens)) {
                        $paniers = explode("/", $livraison['panier']);
                        $code = "";
                        $bdunite = new BdUnite();
                        $unites = $bdunite->getUniteByIdBiens($idbiens);
                        foreach ($unites as $unite) {
                            foreach ($paniers as $pan) {
                                if (($pan != "") && ($pan == $unite['id']) && (1)) {
                                    if ($bdunite->activeUnite($unite['id'])) {
                                        $error = "succes";
                                    } else {
                                        $error = "traitement_error";
                                    }
                                    if ($bdunite->activeUniteDistribution($unite['id'])) {
                                        $error = "succes";
                                    } else {
                                        $error = "traitement_error";
                                    }
                                }
                            }
                        }
                        if ($bdlivraison->deleteLivraison($idlivraison)) {
                            $error = "succes_deleted";
                        }
                    } else {
                        $reponse = "traitement_error";
                    }
                }
            }
        } else {
            $reponse = "traitement_error";
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("logistique_livraison_liste_livraison_all") . '&reponse=' . sha1($reponse) . '&use_date1=' . ($date1) . '&use_date2=' . ($date2) . '&use_service=' . ($idservice) . '&use_typerepas=' . ($typerepas) . '&use_biens=' . ($idbiens) . '&link_up=' . sha1("home_logistique_livraison"));
}

if (isset($_POST['bt_recuperer_low'])) {
    $idlivraison = securise($_POST['tb_idlivraison']);
    $quantite_recupere = securise($_POST['tb_quantite_recupere']);
    $quantite_actuelle = securise($_POST['tb_quantite_actuelle']);
    if ($idlivraison != "" && $quantite_recupere != "" && $quantite_recupere > 0) {

        $bdlivraison = new BdLivraison();

        if ($quantite_recupere <= $quantite_actuelle) {
            $bdbiens = new BdBiens();
            $livraisons = $bdlivraison->getLivraisonById($idlivraison);
            foreach ($livraisons as $livraison) {
                $quantite_biens_last = $livraison['lQuantite'];
                $biens = $bdbiens->getBiensById($livraison['bId']);
                foreach ($biens as $bien) {
                    $quantite_biens = $bien['quantite'];
//                    echo $bien['bId'];die;
                    $quantite_biens = $quantite_biens + $quantite_recupere;

                    if ($bdbiens->augmenteQuantiteBiens($bien['bId'], $quantite_biens)) {
                        $paniers = explode("/", $livraison['panier']);
                        $code = "";
                        $bdunite = new BdUnite();
                        $unites = $bdunite->getUniteByIdBiens($livraison['bId']);
                        $k = 0;
                        foreach ($unites as $unite) {
                            if ($k <= $quantite_recupere) {
                                foreach ($paniers as $pan) {
                                    if (($pan != "") && ($pan == $unite['id']) && (1)) {
                                        $k++;
                                        if ($bdunite->activeUnite($unite['id'])) {
                                            $error = "succes";
                                        } else {
                                            $error = "traitement_error";
                                        }
                                        if ($bdunite->activeUniteDistribution($unite['id'])) {
                                            $error = "succes";
                                        } else {
                                            $error = "traitement_error";
                                        }
                                    }
                                }
                            }
                        }
                        if ($bdlivraison->updateLivraisonQuantiteActuelle($idlivraison, ($quantite_actuelle - $quantite_recupere))) {
                            $error = "succes";
                        }
                    } else {
                        $reponse = "traitement_error";
                    }
                }
            }
        } else {

            $reponse = "quantity_error";
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("logistique_recuperation_add") . '&reponse=' . sha1($reponse) . '&link_up=' . sha1("home_logistique_recuperation"));
    die;
}

if (isset($_POST['bt_select_preparation_for_add_recuperation'])) {
    $preparationId = securise($_POST['cb_preparation']);
    
    
    header('Location:../../views/home.php?link=' . sha1("logistique_recuperation_add") . '&reponse=' . sha1($reponse). '&use_preparation=' . ($preparationId) . '&link_up=' . sha1("home_logistique_recuperation"));
    die;
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
?>

