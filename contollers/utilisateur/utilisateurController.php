<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../../models/connexion.php';

include '../../models/utilisateur/utilisateur.php';
?>

<?php

if (isset($_POST['bt_enregistrer'])) {
    $affectation = $_POST['cb_affectation'];
    $nomutilisateur = $_POST['tb_nomutilisateur'];
    $motdepasse = $_POST['tb_motdepasse'];
    $motdepasseagain = $_POST['tb_motdepasseagain'];
    $type = $_POST['cb_type'];
    if ($affectation != 0 && $nomutilisateur != "" && $motdepasse != "" && $motdepasseagain != "") {
        if ($motdepasse == $motdepasseagain) {
            $bdutilisateur = new BdUtilisateur();
            if ($bdutilisateur->addUtilisateur($nomutilisateur, $motdepasse, $type, $affectation)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        } else {
            $reponse = "motdepasse_error";
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("admin_utilisateur_add") . '&link_up=' . sha1("home_admin_utilisateur") . '&reponse=' . sha1($reponse));
    die;
}

if (isset($_POST['bt_modifier'])) {
    $idutilisateur = $_POST['tb_idutilisateur'];
    $idaffectation = $_POST['cb_affectation'];
    $nomutilisateur = $_POST['tb_nomutilisateur'];
    $motdepasserecent = $_POST['tb_motdepasserecent'];
    $motdepassenew = $_POST['tb_motdepassenew'];
    $type = $_POST['cb_type'];
    if ($idutilisateur != "" && $idaffectation != 0 && $nomutilisateur != "" && $motdepasserecent != "" && $motdepassenew != "") {
        $bdutilisateur = new BdUtilisateur();
        $utilisateurs = $bdutilisateur->getUtilisateurById($idutilisateur);
        foreach ($utilisateurs as $utilisateur) {
            if ($utilisateur['motdepasse'] == sha1($motdepasserecent)) {
                $bdutilisateur = new BdUtilisateur();
                if ($bdutilisateur->updateUtilisateur($nomutilisateur, $motdepassenew, $type, $idaffectation, $idutilisateur)) {
                    $reponse = "succes";
                } else {
                    $reponse = "traitement_error";
                }
            } else {
                $reponse = "recentmotdepasse_error";
            }
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("admin_utilisateur_update_utilisateur_all") . '&link_up=' . sha1("home_admin_utilisateur") . '&reponse=' . sha1($reponse));
    die;
}

if (isset($_POST['bt_active'])) {
    $idutilisateur = $_POST['tb_idutilisateur'];
    $operation = $_POST['tb_operation'];
    if ($idutilisateur!= "" && $operation != "") {
        $bdutilisateur = new BdUtilisateur();
        if ($operation == "active") {
            if ($bdutilisateur->activeUtilisateur($idutilisateur)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        } else {
            if ($bdutilisateur->desactiveUtilisateur($idutilisateur)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("admin_utilisateur_active_utilisateur_all") . '&reponse=' . sha1($reponse) . '&link_up=' . sha1("home_admin_utilisateur"));
}

if (isset($_POST['bt_view'])) {
    header('Location:../../views/home.php?link=' . sha1("admin_affectation_service_fiche_affectation_service_self") . '&reponse=' . sha1($reponse) . '&link_up=' . sha1("home_admin_affectation_service") . '&use=' . ($_POST['tb_idservice']));
}

if (isset($_POST['bt_modifier_self'])) {
    $idutilisateur = $_POST['tb_idutilisateur'];
    $nomutilisateur = $_POST['tb_nomutilisateur'];
    $motdepasserecent = $_POST['tb_motdepasserecent'];
    $motdepassenew = $_POST['tb_motdepassenew'];
    if ($idutilisateur != "" && $nomutilisateur != "" && $motdepasserecent != "" && $motdepassenew != "") {
        $bdutilisateur = new BdUtilisateur();
        $utilisateurs = $bdutilisateur->getUtilisateurById($idutilisateur);
        foreach ($utilisateurs as $utilisateur) {
            if ($utilisateur['motdepasse'] == sha1($motdepasserecent)) {
                if ($bdutilisateur->updateUtilisateurSelf($nomutilisateur, $motdepassenew, $idutilisateur)) {
                    $reponse = "succes";
                } else {
                    $reponse = "traitement_error";
                }
            } else {
                $reponse = "recentmotdepasse_error";
            }
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("admin_utilisateur_update_utilisateur_self") . '&link_up=' . sha1("home_admin_utilisateur") . '&reponse=' . sha1($reponse));
    die;
}

?>