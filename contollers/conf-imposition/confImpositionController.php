<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../../models/connexionM.php';


include '../../models/conf-imposition/ConfImposition.php';
?>

<?php

if (isset($_POST['bt_enregistrer'])) {
    $dateconf = $_POST['tb_dateconf'];
    $pourcentage = $_POST['tb_pourcentage'];
    $composanteimpositionId = $_POST['cb_composanteimposition'];
    $categorieId = $_POST['cb_categorie'];
    
    if (1) {
        if ($dateconf != "" && $pourcentage != "" && $composanteimpositionId != 0 && $categorieId != 0) {
            $bdconfimposition = new BdConfImposition();
//            echo $composanteimpositionId;
//            echo $categorieId;die;
            if ($bdconfimposition->desactiveConfImpositionByComposanteImpositionByCategorie($composanteimpositionId, $categorieId)) {
                if ($bdconfimposition->addConfImposition($dateconf, $pourcentage, $composanteimpositionId, $categorieId)) {
                    $reponse = "succes";
                } else {
                    $reponse = "traitement_error";
                }
            } else {
                $reponse = "traitement_error";
            }
        } else {
            $reponse = "remplissage_error";
        }
        header('Location:../../views/home.php?link=' . sha1("admin_confimposition_add") . '&link_up=' . sha1("home_admin_composanteimposition") . '&reponse=' . sha1($reponse));
        die;
    }
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
    $idfonction = $_POST['tb_idfonction'];
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

if (isset($_POST['bt_search_by_categorie'])) {
    $idcategorie=$_POST['cb_categorie'];
    header('Location:../../views/home.php?link=' . sha1("admin_confimposition_liste_confimposition_all") . '&use_categorie=' . ($idcategorie) . '&link_up=' . sha1("home_admin_composanteimposition"));
}

?>