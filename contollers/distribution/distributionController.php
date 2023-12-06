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
include '../../models/unite/unite.php';
include '../../models/ventePOS/VentePOS.php';
include '../../models/affectation-service/affectationService.php';
include '../../models/crud/db.php';
?>
<?php

function securise($donnee)
{
    $donnee = trim($donnee);
    $donnee = stripslashes($donnee);
    $donnee = strip_tags($donnee);
    return $donnee;
}

if (isset($_POST['bt_enregistrer'])) {
    $idlivraison = securise($_POST['cb_livraison']);
    $idaffectation = securise($_POST['tb_idaffectation']);
    $quantite = securise($_POST['tb_quantite']);
    $date = securise($_POST['tb_use_date']);
    $price = securise($_POST['tb_price']);
    $typerepas = securise($_POST['tb_use_typerepas']);
    $identiteClient = securise($_POST['tb_use_identiteClient']);
    $type = securise($_POST['cb_type']);

    $ventePOSId = securise($_POST['tb_use_ventePOS']);

    $tva=securise($_POST['tb_tva']);

    if ($idlivraison != 0 && $idaffectation != 0 && $date != "" && $quantite > 0 && $price != "" && $price > 0 && $typerepas != "" && $ventePOSId != ""  && $ventePOSId > 0 && $tva !="" && $tva >= 0) {
        $bdlivraison = new BdLivraison();
        $livraisons = $bdlivraison->getLivraisonById($idlivraison);
        
        foreach ($livraisons as $livraison) {
            $newquantite = $livraison['quantite_actuelle'];
        }
        
        if ($quantite <= $newquantite) {
            if ($type != 'CASH_A_RETIRER') {
                $newquantite = $newquantite - $quantite;
            }
            
            $bddistribution = new BdDistribution();
            if ($bddistribution->addDistribution($date, $quantite, $price, $idlivraison, $idaffectation, $typerepas, $identiteClient,$ventePOSId,$tva,$type)) {
                if ($bdlivraison->diminueQuantiteLivraison($idlivraison, $newquantite)) {
                    $error = "succes";
        
                    if (isset($_GET['backCall'])) {
                        panier($idlivraison);
                        echo json_encode(array('message'=>'La vente de l\'article a été ajoutée avec success.','status'=>$error));
                    }else{
                        header('Location:../../views/home.php?link=' . sha1("service_distribution_panier_distribution_add") . '&reponse=' . sha1($error) . '&use_date=' . ($date) . '&use_typerepas=' . ($typerepas) . '&use_affectation=' . ($idaffectation). '&use_ventePOS=' . ($ventePOSId) . '&use_identiteClient=' . ($identiteClient) . '&link_up=' . sha1("home_service_distribution"));
                        die;
                    }
                    
                } else {
                    $error = "traitement_error";
                    if (isset($_GET['backCall'])) {
                        echo json_encode(array('message'=>'Echec d\'enregistrement','status'=>$error));
                    }else{
                        header('Location:../../views/home.php?link=' . sha1("service_distribution_add") . '&reponse=' . sha1($error) . '&use_date=' . ($date) . '&use_typerepas=' . ($typerepas) . '&use_affectation=' . ($idaffectation) . '&use_identiteClient=' . ($identiteClient). '&use_ventePOS=' . ($ventePOSId) . '&link_up=' . sha1("home_service_distribution"));
                        die;
                    }
                }
            } else {
                $error = "traitement_error";
                if (isset($_GET['backCall'])) {
                    echo json_encode(array('message'=>'Echec d\'enregistrement','status'=>$error));
                }else{
                    header('Location:../../views/home.php?link=' . sha1("service_distribution_add") . '&reponse=' . sha1($error) . '&use_date=' . ($date) . '&use_typerepas=' . ($typerepas) . '&use_affectation=' . ($idaffectation) . '&use_identiteClient=' . ($identiteClient). '&use_ventePOS=' . ($ventePOSId) . '&link_up=' . sha1("home_service_distribution"));
                    die;
                }
            }
        } else {
            $error = "quantite_error";
            if (isset($_GET['backCall'])) {
                echo json_encode(array('message'=>'Echec d\'enregistrement','status'=>$error));
            }else{
                header('Location:../../views/home.php?link=' . sha1("service_distribution_add") . '&reponse=' . sha1($error) . '&use_date=' . ($date) . '&use_typerepas=' . ($typerepas) . '&use_affectation=' . ($idaffectation) . '&use_identiteClient=' . ($identiteClient). '&use_ventePOS=' . ($ventePOSId) . '&link_up=' . sha1("home_service_distribution"));
                die;
            }
        }
    } else {
        $error = "remplissage_error";
        if (isset($_GET['backCall'])) {
            echo json_encode(array('message'=>'Echec d\'enregistrement, veuiller remplir tout les champs ...','status'=>$error));
        }else{
            header('Location:../../views/home.php?link=' . sha1("service_distribution_add") . '&reponse=' . sha1($error) . '&use_date=' . ($date) . '&use_typerepas=' . ($typerepas) . '&use_affectation=' . ($idaffectation) . '&use_identiteClient=' . ($identiteClient). '&use_ventePOS=' . ($ventePOSId) . '&link_up=' . sha1("home_service_distribution"));
            die;
        }
    }
}

if (isset($_POST['bt_enregistrer_panier'])) {
    
    $idaffectation = securise($_POST['tb_idaffectation']);
    $date = securise($_POST['tb_use_date']);
    $typerepas = securise($_POST['tb_use_typerepas']);
    $identiteClient = securise($_POST['tb_use_identiteClient']);
    $ventePOS = securise($_POST['tb_use_ventePOS']);

    $m = 0;
    
    $iddistribution = securise($_POST['cb_distribution']);

    $bddistribution = new BdDistribution();
    $distributions = $bddistribution->getDistributionById($iddistribution);
    foreach ($distributions as $distribution) {
        $quantite_distribue = $distribution['nombre'];
        $bdlivraison = new BdLivraison();
        $livraisons = $bdlivraison->getLivraisonById($distribution['distribution_id']);
        foreach ($livraisons as $livraison) {
            $idbiens = $livraison['bId'];
        }
    }
    $bdunite = new BdUnite();
    $unites = $bdunite->getUniteByIdBiens($idbiens);
    $panier = "";
    foreach ($unites as $unite) {
        if ((isset($_POST['chk_' . $unite['id']]))) {
            $panier = $panier . "/" . $_POST['chk_' . $unite['id']];
            $m++;
        }
    }
    
    if ($iddistribution != "" && $panier != "" && (($m == $quantite_distribue))) {
        foreach ($unites as $unite) {
            if ((isset($_POST['chk_' . $unite['id']]))) {
                if ($bdunite->desactiveUniteDistribution($_POST['chk_' . $unite['id']])) {
                }
            }
        }

        if ($bddistribution->setPanier($iddistribution, $panier)) {
            $reponse = "succes";
        } else {
            $reponse = "traitement_error";
        }
    } else {
        $reponse = "remplissage_error";
    }

    header('Location:../../views/home.php?link=' . sha1("service_distribution_add") . '&use_date=' . ($date) . '&use_typerepas=' . ($typerepas) . '&use_affectation=' . ($idaffectation) . '&use_identiteClient=' . ($identiteClient) . '&use_ventePOS=' . ($ventePOS) . '&reponse=' . sha1($reponse) . '&link_up=' . sha1("home_service_distribution").'#selectProduct');
}

function panier($iddistribution){
    $m = 0;
    
    $iddistribution = $iddistribution;

    $bddistribution = new BdDistribution();
    $distributions = $bddistribution->getDistributionById($iddistribution);
    foreach ($distributions as $distribution) {
        $quantite_distribue = $distribution['nombre'];
        $bdlivraison = new BdLivraison();
        $livraisons = $bdlivraison->getLivraisonById($distribution['distribution_id']);
        foreach ($livraisons as $livraison) {
            $idbiens = $livraison['bId'];
        }
    }
    $bdunite = new BdUnite();
    $unites = $bdunite->getUniteByIdBiens($idbiens);
    $panier = "";
    foreach ($unites as $unite) {
        if ((isset($_POST['chk_' . $unite['id']]))) {
            $panier = $panier . "/" . $unite['id'];
            $m++;
        }
    }
    
    if ($iddistribution != "" && $panier != "" && (($m == $quantite_distribue))) {
        foreach ($unites as $unite) {
            if (isset($unite['id'])) {
                $bdunite->desactiveUniteDistribution($unite['id']);
            }
        }
        $bddistribution->setPanier($iddistribution, $panier);
    }   
}

if (isset($_POST['bt_valider_ventePOS'])) {
    
    $idaffectation = securise($_POST['tb_idaffectation']);
    $date = securise($_POST['tb_use_date']);
    
    $typerepas = securise($_POST['tb_use_typerepas']);
    $identiteClient = securise($_POST['tb_use_identiteClient']);

    $serviceId=$_SESSION['idservice'];

    $ventePOSId=securise($_POST['tb_venteposId']);

    if ($date != "" || $typerepas != "") {

        $bdVentePOS=new BdVentePOS();

        $ventePOSs=$bdVentePOS->getVentePOSAll();
        $lesIdVentePOS=[];
        foreach ($ventePOSs as $vp) {
            array_push($lesIdVentePOS,$vp['id']);
        }

        if (!(in_array($ventePOSId,$lesIdVentePOS))) {
            $recentIdVentePOS=0;

            if ($bdVentePOS->addVentePOS($ventePOSId,$serviceId)) {
                $ventePOSs=$bdVentePOS->getVentePOSRecentId();
                $recentIdVentePOS=$ventePOSs[0]['recentId'];
                
                    $error = "succes";
                    
            } else {
                $error = "traitement_error";
            }
        } else {
            $recentIdVentePOS=$ventePOSId;
        }      
        
    } else {
        $error = "remplissage_error";
        
    }

    header('Location:../../views/home.php?link=' . sha1("service_distribution_add") . '&reponse=' . sha1($error) . '&use_date=' . ($date) . '&use_typerepas=' . ($typerepas) . '&use_affectation=' . ($idaffectation) . '&use_identiteClient=' . ($identiteClient) . '&use_ventePOS=' . ($recentIdVentePOS) . '&link_up=' . sha1("home_service_distribution"));
    die;
}



if (isset($_POST['bt_select_date_type'])) {
    $typerepas = securise($_POST['cb_typerepas']);
    $date = securise($_POST['tb_date']);
    $identiteClient = securise($_POST['tb_identiteClient']);
    $idaffectation = securise($_POST['tb_idaffectation']);
    //    echo $idlivraison;die;
    //    echo $idaffectation;die;
    //    echo $date;die;
    //    echo $quantite;die;
    if ($typerepas != "0" && $idaffectation != "" && $date != "") {
        $error = "selected";
        header('Location:../../views/home.php?link=' . sha1("service_distribution_add") . '&reponse=' . sha1($error) . '&use_date=' . ($date) . '&use_typerepas=' . ($typerepas) . '&use_affectation=' . ($idaffectation) . '&use_identiteClient=' . ($identiteClient) . '&link_up=' . sha1("home_service_distribution"));
        die;
    } else {
        header('Location:../../views/home.php?link=' . sha1("service_distribution_add") . '&reponse=' . sha1($error) . '&link_up=' . sha1("home_service_distribution"));
        die;
        $error = "remplissage_error";
    }
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
    if ($_SESSION['type'] == "logistique") {
        header('Location:../../views/home.php?link=' . sha1("service_distribution_fiche_biens_distribution_all") . '&use=' . ($motcle) . '&link_up=' . sha1("home_logistique_livraison"));
    } else {
        header('Location:../../views/home.php?link=' . sha1("service_distribution_fiche_biens_distribution_all") . '&use=' . ($motcle) . '&link_up=' . sha1("home_service_distribution"));
    }
}

if (isset($_POST['bt_search_for_agent'])) {
    $reponse = "search_results";
    $motcle = $_POST['tb_search'];
    header('Location:../../views/home.php?link=' . sha1("service_distribution_fiche_agent_distribution_all") . '&use=' . ($motcle) . '&link_up=' . sha1("home_service_distribution"));
}

if (isset($_POST['bt_view'])) {
    $reponse = $_POST['tb_idattribution'];
    header('Location:../../views/home.php?link=' . sha1("logistique_attribution_biens_fiche_attribution_fournisseur_self") . '&use=' . ($reponse) . '&link_up=' . sha1("home_logistique_attribution_biens"));
}

if (isset($_POST['bt_view_for_biens'])) {
    $reponse = $_POST['tb_idbiens'];
    if ($_SESSION['type'] == "logistique") {
        header('Location:../../views/home.php?link=' . sha1("service_distribution_fiche_biens_distribution_self") . '&use2=' . ($reponse) . '&link_up=' . sha1("home_logistique_livraison"));
    } else {
        header('Location:../../views/home.php?link=' . sha1("service_distribution_fiche_biens_distribution_self") . '&use2=' . ($reponse) . '&link_up=' . sha1("home_service_distribution"));
    }
}

if (isset($_POST['bt_view_for_biens_logistique'])) {
    $reponse = $_POST['tb_idbiens'];
    header('Location:../../views/home.php?link=' . sha1("logistique_demande_fiche_biens_demande_self") . '&use2=' . ($reponse) . '&link_up=' . sha1("home_logistique_demande"));
}

if (isset($_POST['bt_view_for_agent'])) {
    $reponse = $_POST['tb_idagent'];
    header('Location:../../views/home.php?link=' . sha1("service_distribution_fiche_agent_distribution_self") . '&use=' . ($reponse) . '&link_up=' . sha1("home_service_distribution"));
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

//die($_POST['bt_RetirerDistribution']);

if (isset($_POST['bt_RetirerDistribution'])) {
    
    $idlivraison=securise($_POST['distribution_id']);
    $idaffectation = securise($_POST['tb_idaffectation']);
    $date = securise($_POST['tb_use_date']);
    $typerepas = securise($_POST['tb_use_typerepas']);
    $identiteClient = securise($_POST['tb_use_identiteClient']);
    $ventePOS = securise($_POST['tb_use_ventePOS']);
    $type = securise($_POST['typePaiement']);
    $quantite = securise($_POST['quantiteVendu']);

    $bdlivraison = new BdLivraison();
    $livraisons = $bdlivraison->getLivraisonById($idlivraison);
        
        foreach ($livraisons as $livraison) {
            $newquantite = $livraison['quantite_actuelle'];
        }
        
        if ($quantite <= $newquantite) {
            if ($type == 'CASH_A_RETIRER') {
                $newquantite = $newquantite - $quantite;
            }

            $DB = new DB();
            $count = $DB->getWhereMultipleMore(" id FROM affectation "," distribution_id = '".$idlivraison."' AND typePaiement = 'CASH_A_RETIRER' ");
            if(count($count) > 0){
                $updateType = $DB->update("affectation","typePaiement = ?","distribution_id = ?", array('CASH',$idlivraison));
                if($updateType){
                    if ($bdlivraison->diminueQuantiteLivraison($idlivraison,$newquantite)) {
                        $error = "success";
                    }
                }else{
                    $error = "cash_retirer_error";  
                }
            }else{
                $error = "cash_retirer_error";
            }
        }else{
            $error = "quantite_error";
        }

    header('Location:../../views/home.php?link=' . sha1("service_distribution_add") . '&use_date=' . ($date) . '&use_typerepas=' . ($typerepas) . '&use_affectation=' . ($idaffectation) . '&use_identiteClient=' . ($identiteClient) . '&use_ventePOS=' . ($ventePOS) . '&reponse=' . sha1($reponse) . '&link_up=' . sha1("home_service_distribution").'#selectProduct');
    die;
}

if (isset($_POST['bt_delete_lineDistribution'])) {
    
    $distributionId=securise($_POST['tb_distributionId']);
    $idaffectation = securise($_POST['tb_idaffectation']);
    $date = securise($_POST['tb_use_date']);
    $typerepas = securise($_POST['tb_use_typerepas']);
    $identiteClient = securise($_POST['tb_use_identiteClient']);
    $ventePOS = securise($_POST['tb_use_ventePOS']);
    $typePaiement = securise($_POST['typePaiement']);

    $m = 0;
    $iddistribution = securise($distributionId);
    $bddistribution = new BdDistribution();
    $bdlivraison = new BdLivraison();
    $distributions = $bddistribution->getDistributionById($iddistribution);
    foreach ($distributions as $distribution) {
        $quantite_distribue = $distribution['nombre'];
        $panierDistribution=$distribution['panier'];
        $livraisons = $bdlivraison->getLivraisonById($distribution['distribution_id']);
        foreach ($livraisons as $livraison) {
            $idbiens = $livraison['bId'];
            $quantiteActuelleLiv = $livraison['quantite_actuelle'];
            
        }
    }
    
    
    $bdunite = new BdUnite();
    $unites = $bdunite->getUniteByIdBiens($idbiens);
    

    if ($iddistribution != "" && ((1))) {
        if ($typePaiement == 'CASH_A_RETIRER') {
            if ($bddistribution->deleteDistribution($iddistribution)) {
                $reponse = "succes";
            } else{
                $reponse = "traitement_error";
            }
        }else{
            if ($bdlivraison->augmenteQuantiteLivraison($livraisons[0]['lId'],($quantiteActuelleLiv+$quantite_distribue))) {
                $itemsDist=explode('/',$panierDistribution);
            
                foreach ($itemsDist as $iDist) {
                    if ($iDist!="") {
                        if ($bdunite->activeUniteDistribution($iDist)) {
                        }
                    }
                }
                
                if ($bddistribution->setPanier($iddistribution, "")) {
                    if ($bddistribution->deleteDistribution($iddistribution)) {
                        $reponse = "succes";
                    }else{
                        $reponse = "traitement_error";
                    }
                    
                } else {
                    $reponse = "traitement_error";
                }
            }else{
                $reponse = "traitement_error";
            }
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("service_distribution_add") . '&use_date=' . ($date) . '&use_typerepas=' . ($typerepas) . '&use_affectation=' . ($idaffectation) . '&use_identiteClient=' . ($identiteClient) . '&use_ventePOS=' . ($ventePOS) . '&reponse=' . sha1($reponse) . '&link_up=' . sha1("home_service_distribution").'#selectProduct');
    die;
}

if (isset($_POST['bt_search_by_service'])) {
    if (isset($_POST['tb_idbiens'])) {
        $motcle2 = $_POST['tb_idbiens'];
    } else {
        $motcle2 = "";
    }
    $reponse = "search_results";
    $motcle = $_POST['cb_service'];
    $link = $_POST['tb_link'];
    $date1 = securise($_POST['tb_date1']);
    $date2 = securise($_POST['tb_date2']);
    $typerepas = securise($_POST['cb_typerepas']);
    $identiteClient = securise($_POST['cb_identiteClient']);
    $autres_place = securise($_POST['autres_place']);

    if ($_SESSION['type'] == "logistique") {
        header('Location:../../views/home.php?link=' . sha1($link) . '&use=' . ($motcle) . '&use2=' . ($motcle2) . '&use_date1=' . ($date1) . '&use_date2=' . ($date2) . '&use_typerepas=' . ($typerepas) . '&use_identiteClient=' . ($identiteClient) . '&link_up=' . sha1("home_logistique_livraison") .'& autres_place='.$autres_place);
    } else {
        header('Location:../../views/home.php?link=' . sha1($link) . '&use=' . ($motcle) . '&use2=' . ($motcle2) . '&use_date1=' . ($date1) . '&use_date2=' . ($date2) . '&use_typerepas=' . ($typerepas) . '&use_identiteClient=' . ($identiteClient) . '&link_up=' . sha1("home_service_distribution") .'& autres_place='.$autres_place);
    }
}
?>

