<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../../models/connexion.php';

include '../../models/attribution-biens/attributionBiens.php';
?>
<?php

function securise($donnee) {
    $donnee = trim($donnee);
    $donnee = stripslashes($donnee);
    $donnee = strip_tags($donnee);
    return $donnee;
}

if (isset($_POST['bt_search'])) {
    $reponse = "search_results";
    $motcle = $_POST['tb_search'];
    header('Location:../../views/home.php?use=' . ($motcle) . '&link_up=' . sha1("home_service_acceuil"));
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
    header('Location:../../views/home.php?link=' . sha1("service_demande_add") . '&use=' . ($reponse) . '&link_up=' . sha1("home_service_demande"));
}

if (isset($_POST['bt_encours_self'])) {
    $idbiens=$_POST['tb_idbiens'];
    $reponse="get_encours_self";
    header('Location:../../views/home.php?link=' . sha1("logistique_attribution_biens_fiche_biens_attribution_self") . '&reponse=' . sha1($reponse) . '&use='.($idbiens).'&link_up=' . sha1("home_logistique_attribution_biens"));
}

if (isset($_POST['bt_encours_fournisseur_self'])) {
    $idfournisseur=$_POST['tb_idfournisseur'];
    $reponse="get_encours_fournisseur_self";
    header('Location:../../views/home.php?link=' . sha1("logistique_attribution_biens_fiche_attribution_fournisseur_self") . '&reponse=' . sha1($reponse) . '&use='.($idfournisseur).'&link_up=' . sha1("home_logistique_attribution_biens"));
}
?>

