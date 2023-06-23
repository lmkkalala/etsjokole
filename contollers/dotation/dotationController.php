<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../../models/connexion.php';
include '../../models/connexionF.php';

include '../../models/dotation/Dotation.php';
include '../../models/unite/unite.php';
include '../../models/operationF/OperationF.php';

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
    $annee = securise($_POST['tb_annee']);
    $montant = securise($_POST['tb_montant']);
    $amortissementId = securise($_POST['tb_idamortissement']);
    $uniteId = securise($_POST['tb_idunite']);

    $libelle = "";
    $type = "";
    $responsable = "";
    $domaine = "";

    if ($annee != "" && $montant != "" && $amortissementId != "") {
        $bdDotation = new BdDotation();
        if ($bdDotation->addDotation($annee, $montant, $amortissementId)) {

            $valueActuelle = "";
            $bdUnite = new BdUnite();
            $unites = $bdUnite->getUniteById($uniteId);
            foreach ($unites as $unite) {
                $valueActuelle = $unite['valueActuelle'];
                $id_biens = $unite['biensId'];
                $code_unite = $unite['code'];
            }

            if ($bdUnite->updateUniteValueActuelle($uniteId, ($valueActuelle - $montant))) {

                $bdBiens = new BdBiens();
                $biens = $bdBiens->getBiensById($id_biens);
                foreach ($biens as $bien) {
                    $designation_biens = $bien['bDesignation'];
                }

                $libelle = "Amortissement Item: " . $designation_biens . " Code: " . $code_unite;
                $type = "out";
                $responsable = $_SESSION['identite'];
                $domaine = "amortissement";

                $bdOperationF = new BdOperationF();
                if ($bdOperationF->addOperation($libelle, $type, $responsable, $domaine,$montant)) {
                    $error = "succes";
                }
                
            }
        } else {
            $error = "traitement_error";
        }
    } else {
        $error = "remplissage_error";
    }
    header('Location:../../views/home.php?reponse=' . sha1($error) . '&link=' . sha1("logistique_dotation_add") . '&use_unite=' . ($uniteId) . '&link_up=' . sha1("home_logistique_dotation"));
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

if (isset($_POST['bt_delete'])) {
    $amortissementId = securise($_POST['tb_idamortissement']);
    $uniteId = securise($_POST['tb_idunite']);
    $annee = securise($_POST['tb_annee']);
    $montant = securise($_POST['tb_montant']);
    if ($amortissementId != "" && $uniteId != "" && $annee != "") {
        $bdDotation = new BdDotation();
        if (1) {
            if ($bdDotation->deleteDotation($amortissementId, $annee)) {
                $valueActuelle = "";
                $bdUnite = new BdUnite();
                $unites = $bdUnite->getUniteById($uniteId);
                foreach ($unites as $unite) {
                    $valueActuelle = $unite['valueActuelle'];
                }

                if ($bdUnite->updateUniteValueActuelle($uniteId, ($valueActuelle + $montant))) {
                    $error = "succes";
                }
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("logistique_dotation_add") . '&reponse=' . sha1($reponse) . '&use_unite=' . ($uniteId) . '&link_up=' . sha1("home_logistique_dotation"));
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

if (isset($_POST['bt_for_amortissement'])) {
    $idunite = $_POST['tb_idunite'];
    header('Location:../../views/home.php?link=' . sha1("logistique_amortissement_add") . '&reponse=' . sha1($reponse) . '&use_unite=' . ($idunite) . '&link_up=' . sha1("home_logistique_amortissement"));
}

if (isset($_POST['bt_for_dotation'])) {
    $uniteId = $_POST['tb_idunite'];
    $amortissementId = $_POST['tb_idamortissement'];
    header('Location:../../views/home.php?link=' . sha1("logistique_dotation_add") . '&reponse=' . sha1($reponse) . '&use_unite=' . ($uniteId) . '&use_amortissement=' . ($amortissementId) . '&link_up=' . sha1("home_logistique_dotation"));
}

?>

