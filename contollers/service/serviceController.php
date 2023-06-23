<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../../models/connexion.php';

include '../../models/service/service.php';
include '../../models/entreprise/entreprise.php';
?>

<?php

if (isset($_POST['bt_enregistrer'])) {
    $designation = $_POST['tb_designation'];
    $prixbreakfast = 0;
    $prixlunch = 0;
    $prixdinner = 0;
    if ($designation != "" && $prixbreakfast!="" && $prixlunch!="" && $prixdinner!="") {
        if (1) {
            $bdservice = new BdService();
            $bdentreprise = new BdEntreprise();
            $entreprises = $bdentreprise->getEntreprise();
            foreach ($entreprises as $entreprise) {
                $identreprise = $entreprise['id'];
            }
            if ($bdservice->addService($designation, $identreprise,$prixbreakfast,$prixlunch,$prixdinner)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        } else {
            $reponse = "remplissage_error";
        }
        header('Location:../../views/home.php?link=' . sha1("admin_service_add") . '&link_up=' . sha1("home_admin_service") . '&reponse=' . sha1($reponse));
        die;
    }
}

if (isset($_POST['bt_modifier'])) {
    $idservice = $_POST['tb_idservice'];
    $designation = $_POST['tb_designation'];
    $prixbreakfast = 0;
    $prixlunch = 0;
    $prixdinner = 0;

    if ($designation != "" && $prixbreakfast!="" && $prixlunch!="" && $prixdinner!="") {
        $bdservice = new BdService();
        if ($bdservice->updateService($idservice, $designation,$prixbreakfast,$prixlunch,$prixdinner)) {
            $reponse = "succes";
        } else {
            $reponse = "traitement_error";
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("admin_service_update_service_all") . '&link_up=' . sha1("home_admin_service") . '&reponse=' . sha1($reponse));
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
    header('Location:../../views/home.php?link=' . sha1("admin_service_active_service_all") . '&reponse=' . sha1($reponse).'&link_up='.sha1("home_admin_service"));
}


?>