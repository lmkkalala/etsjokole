<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../../models/connexion.php';

include '../../models/agent/agent.php';
include '../../models/fournisseur/fournisseur.php';
include '../../models/unite/unite.php';
?>
<?php

function securise($donnee) {
    $donnee = trim($donnee);
    $donnee = stripslashes($donnee);
    $donnee = strip_tags($donnee);
    return $donnee;
}

if (isset($_POST['bt_active'])) {
    $idunite = $_POST['tb_idunite'];
    $operation = $_POST['tb_operation'];
    if ($idunite != "" && $operation != "") {
        $bdunite=new BdUnite();
        if ($operation == "active") {
            if ($bdunite->activePrincipalUnite($idunite)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        } else {
            if ($bdunite->desactivePrincipalUnite($idunite)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("logistique_unite_active_unite_all") . '&reponse=' . sha1($reponse).'&link_up='.sha1("home_logistique_unite"));
}

if (isset($_POST['bt_search_for_biens'])) {
    $reponse = "search_results";
    $motcle = $_POST['tb_search'];
    header('Location:../../views/home.php?link=' . sha1("logistique_unite_fiche_biens_unite_all") . '&use=' .($motcle).'&link_up='.sha1("home_logistique_unite"));
}

if (isset($_POST['bt_view'])) {
    $reponse=$_POST['tb_idagent'];
    header('Location:../../views/home.php?link=' . sha1("admin_agent_fiche_agent_self") . '&use=' .($reponse).'&link_up='.sha1("home_admin_agent"));
}

if (isset($_POST['bt_view_for_biens'])) {
    $reponse=$_POST['tb_idbiens'];
    header('Location:../../views/home.php?link=' . sha1("logistique_unite_fiche_biens_unite_self") . '&use=' .($reponse).'&link_up='.sha1("home_logistique_unite"));
}

if (isset($_POST['bt_search_for_unite'])) {
    $reponse = "search_results";
    $motcle = $_POST['tb_search'];
    header('Location:../../views/home.php?link=' . sha1("logistique_unite_active_unite_all") . '&use=' .($motcle).'&link_up='.sha1("home_logistique_unite"));
}

if (isset($_POST['bt_search_for_biens_unite'])) {
    $reponse = "search_results";
    $motcle = $_POST['cb_biens'];
    header('Location:../../views/home.php?link=' . sha1("logistique_unite_fiche_biens_unite_all") . '&use=' .($motcle).'&link_up='.sha1("home_logistique_unite"));
}

?>

