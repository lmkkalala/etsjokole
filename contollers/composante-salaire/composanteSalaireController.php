<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../../models/connexionM.php';


include '../../models/composante-salaire/ComposanteSalaire.php';
?>

<?php

if (isset($_POST['bt_enregistrer'])) {
    $code = $_POST['tb_code'];
    $designation = $_POST['tb_designation'];
    $unite = $_POST['tb_unite'];
    $type = $_POST['rb_type'];
    $nature = $_POST['rb_nature'];
    $defaultquantite = $_POST['tb_defaultquantite'];
    if (1) {
        if ($code != "" && $designation != "" && $unite != "" && $type != "" && $nature != "" && $defaultquantite != "") {
            $bdcomposantesalaire=new BdComposanteSalaire();
            if ($bdcomposantesalaire->addComposanteSalaire($code,$designation, $unite, $type, $nature,$defaultquantite)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        } else {
            $reponse = "remplissage_error";
        }
        header('Location:../../views/home.php?link=' . sha1("admin_composantesalaire_add") . '&link_up=' . sha1("home_admin_composantesalaire") . '&reponse=' . sha1($reponse));
        die;
    }
}

if (isset($_POST['bt_modifier'])) {
    $idfonction = $_POST['tb_idfonction'];
    $designation = $_POST['tb_designation'];

    if ($designation != "") {
        $bdfonction=new BdFonction();
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
        $bdfonction=new BdFonction();
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
    header('Location:../../views/home.php?link=' . sha1("admin_fonction_active_fonction_all") . '&reponse=' . sha1($reponse).'&link_up='.sha1("home_admin_fonction"));
}


?>