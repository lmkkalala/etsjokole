<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../../models/connexion.php';

include '../../models/service/service.php';
include '../../models/entreprise/entreprise.php';
include '../../models/affectation-service/affectationService.php';
?>

<?php

if (isset($_POST['bt_enregistrer'])) {
    $agent=$_POST['cb_agent'];
    $service=$_POST['cb_service'];
    $fonction=$_POST['cb_fonction'];
    $date=$_POST['tb_date'];


        if ($service!=0 && $agent!=0 && $fonction!=0) {
            $bdaffectation = new BdAffectationService();
            if ($bdaffectation->addAffectationService($date, $agent, $service,$fonction)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        } else {
            $reponse = "remplissage_error";
        }
        header('Location:../../views/home.php?link=' . sha1("admin_affectation_service_add") . '&link_up=' . sha1("home_admin_affectation_service") . '&reponse=' . sha1($reponse));
        die;
}

if (isset($_POST['bt_modifier'])) {
    $idaffectation=$_POST['tb_idaffectation'];
    $agent=$_POST['cb_agent'];
    $service=$_POST['cb_service'];
    $fonction=$_POST['cb_fonction'];
    $date=$_POST['tb_date'];
    if ($date != "" && $agent!=0 && $service!=0 && $fonction!=0) {
        $bdaffectation=new BdAffectationService();
        if ($bdaffectation->updateAffectationService($idaffectation, $date, $agent, $service, $fonction)) {
            $reponse = "succes";
        } else {
            $reponse = "traitement_error";
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("admin_affectation_service_update_affectation_service_all") . '&link_up=' . sha1("home_admin_affectation_service") . '&reponse=' . sha1($reponse));
    die;
}

if (isset($_POST['bt_active'])) {
    $idaffectation = $_POST['tb_idaffectation'];
    $operation = $_POST['tb_operation'];
    if ($idaffectation != "" && $operation != "") {
        $bdaffectation=new BdAffectationService();
        if ($operation == "active") {
            if ($bdaffectation->activeAffectationService($idaffectation)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        } else {
            if ($bdaffectation->desactiveAffectationService($idaffectation)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("admin_affectation_service_active_affectation_service_all") . '&reponse=' . sha1($reponse).'&link_up='.sha1("home_admin_affectation_service"));
}

if (isset($_POST['bt_view'])) {
    header('Location:../../views/home.php?link=' . sha1("admin_affectation_service_fiche_affectation_service_self") . '&reponse=' . sha1($reponse).'&link_up='.sha1("home_admin_affectation_service").'&use='.($_POST['tb_idservice']));
}


?>