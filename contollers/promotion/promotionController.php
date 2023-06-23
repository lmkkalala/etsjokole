<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../../models/connexionM.php';


include '../../models/promotion/Promotion.php';
?>

<?php

if (isset($_POST['bt_enregistrer'])) {
    $dateaffectation = $_POST['tb_dateaffectation'];
    $employeId = $_POST['cb_employe'];
    $serviceId = $_POST['cb_service'];
    $fonctionId = $_POST['cb_fonction'];
    $categorieId = $_POST['cb_categorie'];
    $typeContratId = $_POST['cb_typecontrat'];
    if ($dateaffectation != "" && $employeId != 0 && $serviceId != 0 && $fonctionId != 0 && $categorieId != 0 && $typeContratId != 0) {
        if (1) {
            $bdpromotion = new BdPromotion();
            $promotions = $bdpromotion->getPromotionByEmployeByServiceByFonctionByCategorieByTypeContrat($employeId, $serviceId, $fonctionId, $categorieId, $typeContratId);
            $i = 0;
            foreach ($promotions as $promotion) {
                $i++;
            }
            if ($i == 0) {
                if ($bdpromotion->desactivePromotionByEmploye($employeId)) {
                    if ($bdpromotion->addPromotion($dateaffectation, $employeId, $serviceId, $fonctionId, $categorieId, $typeContratId)) {
                        $reponse = "succes";
                    } else {
                        $reponse = "traitement_error";
                    }
                } else {
                    $reponse = "traitement_error";
                }
            } else {
                $reponse = "doublons_error";
            }
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("admin_promotion_add") . '&link_up=' . sha1("home_admin_promotion") . '&reponse=' . sha1($reponse));
    die;
}

if (isset($_POST['bt_modifier'])) {
    $idfonction = $_POST['tb_idfonction'];
    $designation = $_POST['tb_designation'];

    if ($designation != "") {
        $bdfonction = new BdFonction();
        if ($bdfonction->updateFonction($idfonction, $designation)) {
            $reponse = "succes";
        } else {
            $reponse = "traitement_error";
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("admin_fonction_update_fonction_all") . '&link_up=' . sha1("home_admin_fonction") . '&reponse=' . sha1($reponse));
    die;
}

if (isset($_POST['bt_active'])) {
    $idcandidature = $_POST['tb_idcandidature'];
    $operation = $_POST['tb_operation'];
    if ($idfonction != "" && $operation != "") {
        $bdfonction = new BdFonction();
        if ($operation == "active") {
            if ($bdfonction->activeFonction($idfonction)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        } else {
            if ($bdfonction->desactiveFonction($idfonction)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("admin_fonction_active_fonction_all") . '&reponse=' . sha1($reponse) . '&link_up=' . sha1("home_admin_fonction"));
}

if (isset($_POST['bt_selection'])) {
    $idcandidature = $_POST['tb_idcandidature'];
    $operation = $_POST['tb_operation'];
    if ($idcandidature != "" && $operation != "") {
        $bdcandidature = new BdCandidature();
        if ($operation == "allow") {
            if ($bdcandidature->allowCandidature($idcandidature)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        } else {
            if ($bdcandidature->rejectCandidature($idcandidature)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("admin_candidature_accepte_candidature_all") . '&reponse=' . sha1($reponse) . '&link_up=' . sha1("home_admin_candidature"));
}
?>