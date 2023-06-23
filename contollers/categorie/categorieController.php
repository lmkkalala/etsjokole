<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../../models/connexion.php';

include '../../models/categorie/categorie.php';
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
        $bdcategorie = new BdCategorie();
        if ($bdcategorie->addCategorie($designation)) {
            $error = "succes";
        } else {
            $error = "traitement_error";
        }
    } else {
        $error = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("logistique_categorie_add") . '&reponse=' . sha1($error) . '&link_up=' . sha1("home_logistique_categorie"));
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
    $idcategorie = securise($_POST['tb_idcategorie']);
    $operation = securise($_POST['tb_operation']);
    if ($idcategorie != "" && $operation != "") {
        $bdcategorie=new BdCategorie();
        if ($operation == "active") {
            if ($bdcategorie->activeCategorie($idcategorie)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        } else {
            if ($bdcategorie->desactiveCategorie($idcategorie)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("logistique_categorie_active_categorie_all") . '&reponse=' . sha1($reponse) . '&link_up=' . sha1("home_logistique_categorie"));
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

