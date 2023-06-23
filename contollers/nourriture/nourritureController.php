<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../../models/connexion.php';

include '../../models/nourriture/nourriture.php';
?>
<?php

function securise($donnee) {
    $donnee = trim($donnee);
    $donnee = stripslashes($donnee);
    $donnee = strip_tags($donnee);
    return $donnee;
}

if (isset($_POST['bt_enregistrer'])) {
    $designation = securise($_POST['tb_designation']);
    if ($designation != "") {
        $bdnourriture = new BdNourriture();
        if ($bdnourriture->addNourriture($designation)) {
            $error = "succes";
        } else {
            $error = "traitement_error";
        }
    } else {
        $error = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("service_nourriture_add") . '&reponse=' . sha1($error) . '&link_up=' . sha1("home_service_nourriture"));
}

if (isset($_POST['bt_modifier'])) {
    $idnourriture = securise($_POST['tb_idnourriture']);
    $designation = securise($_POST['tb_designation']);
    if ($idnourriture != "" && $designation != "") {
        $bdnourriture = new BdNourriture();
        if ($bdnourriture->updateNourriture($idnourriture, $designation)) {
            $reponse = "succes";
        } else {
            $reponse = "traitement_error";
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("service_nourriture_update_nourriture_all") . '&reponse=' . sha1($reponse) . '&link_up=' . sha1("home_service_nourriture"));
}

if (isset($_POST['bt_active'])) {
    $idnourriture = securise($_POST['tb_idnourriture']);
    $operation = securise($_POST['tb_operation']);
    if ($idnourriture != "" && $operation != "") {
        $bdnourriture=new BdNourriture();
        if ($operation == "active") {
            if ($bdnourriture->activeNourriture($idnourriture)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        } else {
            if ($bdnourriture->desactiveNourriture($idnourriture)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("service_nourriture_active_nourriture_all") . '&reponse=' . sha1($reponse) . '&link_up=' . sha1("home_service_nourriture"));
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
?>

