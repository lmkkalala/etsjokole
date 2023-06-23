<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../../models/connexion.php';

include '../../models/addsin/Addsin.php';
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
        $bdAddsin=new BdAddsIn();
        if ($bdAddsin->addAddsIn($designation)) {
            $error = "succes";
        } else {
            $error = "traitement_error";
        }
    } else {
        $error = "remplissage_error";
    }
    header('Location:../../views/home.php?reponse=' . sha1($error) . '&link_up=' . sha1("home_logistique_addsin"));
}

if (isset($_POST['bt_modifier'])) {
    $idAddsIn = securise($_POST['tb_idaddsin']);
    $designation = securise($_POST['tb_designation']);

    if ($idAddsIn != "" && $designation != "") {
        $bdAddsin=new BdAddsIn();
        if ($bdAddsin->updateAddsIn($idAddsIn,$designation)) {
            $reponse = "succes";
        } else {
            $reponse = "traitement_error";
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("logistique_addsin_update_self") . '&reponse=' . sha1($reponse) . '&link_up=' . sha1("home_logistique_addsin") . '&use_addsin=' . ($idAddsIn));
}

if (isset($_POST['bt_active'])) {
    $idAddsIn = securise($_POST['tb_idaddsin']);
    $operation = securise($_POST['tb_operation']);
    if ($idAddsIn != "" && $operation != "") {
        $bdAddsin = new BdAddsIn();
        if ($operation == "active") {
            if ($bdAddsin->activeAddsIn($idAddsIn)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        } else {
            if ($bdAddsin->desactiveAddsIn($idAddsIn)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("logistique_addsin_liste_all") . '&reponse=' . sha1($reponse) . '&link_up=' . sha1("home_logistique_addsin"));
}

if (isset($_POST['bt_for_update'])) {
    $addsInId = $_POST['tb_idaddsin'];
    header('Location:../../views/home.php?link=' . sha1("logistique_addsin_update_self") . '&use_addsin=' . ($addsInId) . '&link_up=' . sha1("home_logistique_addsin"));
}

if (isset($_POST['bt_for_statistics'])) {
    $addsInId = $_POST['tb_idaddsin'];
    header('Location:../../views/home.php?link=' . sha1("logistique_addsin_statistics") . '&use_addsin=' . ($addsInId) . '&link_up=' . sha1("home_logistique_addsin"));
}

?>

