<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../../models/connexion.php';

include '../../models/entreprise/entreprise.php';
?>

<?php

if (isset($_POST['bt_enregistrer'])) {
    $designation = $_POST['tb_designation'];
    $sigle = $_POST['tb_sigle'];
    if ($designation != "" && $sigle != "" && (isset($_FILES['tb_file']['tmp_name'])) && (($_FILES['tb_file']['tmp_name']) == UPLOAD_ERR_OK)) {
        $extensions = ['.png', '.gif', '.jpg', '.jpeg', '.PNG', '.GIF', '.JPG', '.JPEG'];
        $chemin_destination = '../../media/pictures-entreprise/';
        $extension_self = strrchr($_FILES['tb_file']['name'], '.');
        if (!in_array($extension_self, $extensions)) {
            header('Location:../../views/home.php?link=' . sha1("admin_entreprise_add") . '&link_up=' . sha1("home_admin_entreprise") . '&reponse=' . sha1("format_error"));
            die;
        }
        $fichier = basename($_FILES['tb_file']['name']);
        $resultat = move_uploaded_file($_FILES['tb_file']['tmp_name'], $chemin_destination . $fichier);
        if ($resultat) {
            $bdentreprise = new BdEntreprise();
            if ($bdentreprise->addEntreprise($designation, $sigle, $fichier)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        } else {
            $reponse = "upload_error";
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("admin_entreprise_add") . '&link_up=' . sha1("home_admin_entreprise") . '&reponse=' . sha1($reponse));
    die;
}

if (isset($_POST['bt_modifier'])) {
    $identreprise = $_POST['tb_identreprise'];
    $withfile = $_POST['rb_withfile'];
    $designation = $_POST['tb_designation'];
    $sigle = $_POST['tb_sigle'];

	echo $identreprise;
	echo $withfile;
	echo $designation;
	echo $sigle;

	

    if ($withfile == 1) {
        if ($designation != "" && $sigle != "" && (isset($_FILES['tb_file']['tmp_name']))) {
            $extensions = ['.png', '.gif', '.jpg', '.jpeg', '.PNG', '.GIF', '.JPG', '.JPEG'];
            $chemin_destination = '../../media/pictures-entreprise/';
            $extension_self = strrchr($_FILES['tb_file']['name'], '.');
            if (!in_array($extension_self, $extensions)) {
                header('Location:../../views/home.php?link=' . sha1("admin_entreprise_add") . '&link_up=' . sha1("home_admin_entreprise") . '&reponse=' . sha1("format_error"));
                die;
            }
            $fichier = basename($_FILES['tb_file']['name']);
            $resultat = move_uploaded_file($_FILES['tb_file']['tmp_name'], $chemin_destination . $fichier);
            if ($resultat) {
                $bdentreprise = new BdEntreprise();
                if ($bdentreprise->updateEntrepriseWithFile($identreprise, $designation, $sigle, $fichier)) {
                    $reponse = "succes";
                } else {
                    $reponse = "traitement_error";
                }
            } else {
                $reponse = "upload_error";
            }
        } else {
            $reponse = "remplissage_error";
        }
        header('Location:../../views/home.php?link=' . sha1("admin_entreprise_update") . '&link_up=' . sha1("home_admin_entreprise") . '&reponse=' . sha1($reponse));
        die;
    } else {
        if ($designation != "" && $sigle != "") {
            if (1) {
                $bdentreprise = new BdEntreprise();
                if ($bdentreprise->updateEntrepriseWithOutFile($identreprise, $designation, $sigle)) {
                    $reponse = "succes";
                } else {
                    $reponse = "traitement_error";
                }
            }
        } else {
            $reponse = "remplissage_error";
        }
        header('Location:../../views/home.php?link=' . sha1("admin_entreprise_update") . '&link_up=' . sha1("home_admin_entreprise") . '&reponse=' . sha1($reponse));
        die;
    }
}
?>