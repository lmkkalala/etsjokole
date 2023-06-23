<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../../models/connexionM.php';
include '../../models/candidat/Candidat.php';
?>

<?php

if (isset($_POST['bt_enregistrer'])) {
    $nom = $_POST['tb_nom'];
    $postnom = $_POST['tb_postnom'];
    $prenom = $_POST['tb_prenom'];
    if(isset($_POST['rb_sexe'])) {
        $sexe = $_POST['rb_sexe'];
    } else {
        $sexe = "";
    }
    $nationalite = $_POST['tb_nationalite'];
    $adresse = $_POST['tb_adresse'];
    $datenaissance = $_POST['tb_datenaissance'];
    $lieunaissance = $_POST['tb_lieunaissance'];
    $telephone = $_POST['tb_telephone'];
    $email = $_POST['tb_email'];
    if (1) {
        if ($nom != "" && $postnom != "" && $prenom != "" && $sexe != "" && $nationalite != "" && $adresse != "" && $datenaissance != "" && $lieunaissance != "" && $telephone != "" && $email != "") {
            $bdCandidat=new BdCandidat();
            if ($bdCandidat->addCandidat($nom, $postnom, $prenom, $sexe,$nationalite,$adresse,$datenaissance,$lieunaissance,$telephone,$email)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        } else {
            $reponse = "remplissage_error";
        }
        header('Location:../../views/home.php?link=' . sha1("admin_candidat_add") . '&link_up=' . sha1("home_admin_candidat") . '&reponse=' . sha1($reponse));
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