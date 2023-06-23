<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../../models/connexionM.php';

include '../../models/serviceM/service.php';
?>

<?php

if (isset($_POST['bt_enregistrer'])) {
    $designation = $_POST['tb_designation'];
    
    if (1) {
        if ($designation != "") {
            $bdservice = new BdService();
            if ($bdservice->addService($designation)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        } else {
            $reponse = "remplissage_error";
        }
        header('Location:../../views/home.php?link=' . sha1("admin_service_add") . '&link_up=' . sha1("home_admin_serviceM") . '&reponse=' . sha1($reponse));
        die;
    }
}

if (isset($_POST['bt_modifier'])) {
    $idservice = $_POST['tb_idservice'];
    $designation = $_POST['tb_designation'];

    if ($idservice != "" && $designation!="") {
        $bdservice = new BdService();
        if ($bdservice->updateService($idservice, $designation)) {
            $reponse = "succes";
        } else {
            $reponse = "traitement_error";
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("admin_service_update_service_all") . '&link_up=' . sha1("home_admin_serviceM") . '&reponse=' . sha1($reponse));
    die;
}

if (isset($_POST['bt_active'])) {
    $idservice = $_POST['tb_idservice'];
    $operation = $_POST['tb_operation'];
    if ($idservice != "" && $operation != "") {
        $bdservice=new BdService();
        if ($operation == "active") {
            if ($bdservice->activeService($idservice)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        } else {
            if ($bdservice->desactiveService($idservice)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("admin_service_active_service_all") . '&reponse=' . sha1($reponse).'&link_up='.sha1("home_admin_serviceM"));
}


?>