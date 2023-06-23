<?php
session_start();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../../models/connexion.php';

include '../../models/preparation/preparation.php';
?>
<?php

function securise($donnee) {
    $donnee = trim($donnee);
    $donnee = stripslashes($donnee);
    $donnee = strip_tags($donnee);
    return $donnee;
}

if (isset($_POST['bt_enregistrer'])) {
    $dateheure = securise($_POST['tb_dateheure']);
    $idaffectationservice=securise($_SESSION['idaffectation']);
    $typerepas = securise($_POST['cb_typerepas']);
    if (($dateheure != "") && ($idaffectationservice!="") && ($typerepas!="0")) {
        $bdpreparation = new BdPreparation();
        if ($bdpreparation->addPreparation($dateheure,$idaffectationservice,$typerepas)) {
            $error = "succes";
        } else {
            $error = "traitement_error";
        }
    } else {
        $error = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("service_preparation_add") . '&reponse=' . sha1($error) . '&link_up=' . sha1("home_service_preparation"));
}

if (isset($_POST['bt_modifier'])) {
    $idcategorie = securise($_POST['tb_idcategorie']);
    $designation = securise($_POST['tb_designation']);
    if ($idcategorie != "" && $designation != "") {
        $bdcategorie = new BdCategorie();
        if ($bdcategorie->updateCategorie($idcategorie, $designation)) {
            $reponse = "succes";
        } else {
            $reponse = "traitement_error";
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("logistique_categorie_update_categorie_all") . '&reponse=' . sha1($reponse) . '&link_up=' . sha1("home_logistique_categorie"));
}

if (isset($_POST['bt_active'])) {
    $idpreparation = securise($_POST['tb_idpreparation']);
    $operation = securise($_POST['tb_operation']);
    if ($idpreparation != "" && $operation != "") {
        $bdpreparation=new BdPreparation();
        if ($operation == "active") {
            if ($bdpreparation->activePreparation($idpreparation)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        } else {
            if ($bdpreparation->desactivePreparation($idpreparation)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("service_preparation_active_preparation_all") . '&reponse=' . sha1($reponse) . '&link_up=' . sha1("home_service_preparation"));
}

if (isset($_POST['bt_search'])) {
    $reponse = "search_results";
    $motcle = $_POST['tb_search'];
    
    header('Location:../../views/home.php?link=' . sha1("logistique_categorie_fiche_categorie_all") . '&use=' . ($motcle) . '&link_up=' . sha1("home_logistique_categorie"));
}

if (isset($_POST['bt_view'])) {
    $reponse = $_POST['tb_idcategorie'];
    header('Location:../../views/home.php?link=' . sha1("logistique_categorie_fiche_categorie_self") . '&use=' . ($reponse) . '&link_up=' . sha1("home_logistique_categorie"));
}

if (isset($_POST['bt_search_by_service'])) {
    if (isset($_POST['tb_idbiens'])) {
        $motcle2=$_POST['tb_idbiens'];
    } else {
        $motcle2="";
    }
    $reponse = "search_results";
    $motcle = $_POST['cb_service'];
    $link = $_POST['tb_link'];
    if ($_SESSION['type']=="logistique") {
        header('Location:../../views/home.php?link=' . sha1($link) . '&use=' . ($motcle) . '&use2=' . ($motcle2) . '&link_up=' . sha1("home_logistique_livraison"));
    } else {
        header('Location:../../views/home.php?link=' . sha1($link) . '&use=' . ($motcle) . '&use2=' . ($motcle2) . '&link_up=' . sha1("home_service_preparation"));
    }
}

if (isset($_POST['bt_search_for_preparation'])) {
    $reponse = $_POST['cb_preparation'];
    header('Location:../../views/home.php?link=' . sha1("service_preparation_stat") . '&use_preparation=' . ($reponse) . '&link_up=' . sha1("home_service_preparation"));
}

?>

