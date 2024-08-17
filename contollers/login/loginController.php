<?php

// echo "ici";

session_start();



/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../../models/connexion.php';

include '../../models/entreprise/entreprise.php';
include '../../models/utilisateur/utilisateur.php';
include '../../models/affectation-service/affectationService.php';
?>

<?php

function securise($donnee) {
    $donnee = trim($donnee);
    $donnee = stripslashes($donnee);
    $donnee = strip_tags($donnee);
    return $donnee;
}

if (isset($_POST['bt_connexion'])) {

    $nomutilisateur = securise($_POST['tb_nomutilisateur']);
    $motdepasse = securise($_POST['tb_motdepasse']);
    $etat = 0;
    if ($nomutilisateur != "" && $motdepasse != "") {
        $bdutilisateur = new BdUtilisateur();
        if (1) {
            $utilisateurs = $bdutilisateur->getUtilisateurAllDesc();
            foreach ($utilisateurs as $utilisateur) {
                if ($utilisateur['nomUtilisateur'] == $nomutilisateur) {
                    if ($utilisateur['motdepasse'] == sha1($motdepasse)) {
                        $etatuser = $utilisateur['active'];
                        $type = $utilisateur['type'];
                        $idutilisateur = $utilisateur['id'];
                        $bdaffectation = new BdAffectationService();
                        $affectations = $bdaffectation->getAffectationServiceByIdSecond($utilisateur['mutation_id']);
                        foreach ($affectations as $affectation) {
                            $identite = $affectation['nom'] . " " . $affectation['postnom'] . " " . $affectation['prenom'];
                            $service = $affectation['designation'];
                            $grade = $affectation['grade'];
                            $idaffectation = $affectation['Id'];
                            $idservice = $affectation['Sid'];
                            $agentID = $affectation['Aid'];
                            $mSeller = $affectation['mSeller'];
                        }
                        $reponse = "succes";
                        $etat = 1;
                    } else {
                        $reponse = "motdepasse_error";
                    }
                } else {
                    $reponse = "nomutilisateur_error";
                }
            }
        } else {
            $reponse = "traitement_error";
        }
    } else {
        $reponse = "remplissage_error";
    }
    
    if ($etat) {
        if ($etatuser) {
            $_SESSION['identite'] = $identite;
            $_SESSION['service'] = $service;
            $_SESSION['grade'] = $grade;
            $_SESSION['idaffectation'] = $idaffectation;
            $_SESSION['idutilisateur'] = $idutilisateur;
            $_SESSION['idservice'] = $idservice;
            $_SESSION['type'] = $type;
            $_SESSION['agentID'] = $agentID;
            $_SESSION['mSeller'] = $mSeller;
            
            if ($type == "admin") {
                header('Location:../../views/home.php?link_up=' . sha1("home_admin_acceuil") . '&reponse=' . sha1($reponse));
                die;
            } else if ($type == "logistique") {
                header('Location:../../views/home.php?link_up=' . sha1("home_logistique_acceuil") . '&reponse=' . sha1($reponse));
                die;
            } else if ($type == "other") {
                header('Location:../../views/home.php?link_up=' . sha1("home_service_acceuil") . '&reponse=' . sha1($reponse));
                die;
            } else if ($type == "personnel") {
                header('Location:../../views/home.php?link_up=' . sha1("home_admin_acceuil") . '&reponse=' . sha1($reponse));
                die;
            } else if ($type == "membre") {
                header('Location:../../views/home.php?link_up=' . sha1("home_service_swaping") . '&reponse=' . sha1($reponse));
                die;
            } else if ($type == "administration") {
                header('Location:../../views/home.php?link_up=' . sha1("home_admin_acceuil") . '&reponse=' . sha1($reponse));
                die;
            } else if ($type == "hr_mb") {
                header('Location:../../views/home.php?link_up=' . sha1("home_admin_acceuil") . '&reponse=' . sha1($reponse));
                die;
            }
        } else {
            $reponse = "activation_error";
            header('Location:../../index.php?reponse=' . sha1($reponse));
            die;
        }
    } else {
        header('Location:../../index.php?reponse=' . sha1($reponse));
        die;
    }
}

if (!empty($_SESSION['type'])) {
    $reponse = '';
     $type = $_SESSION['type'];
    if ($type == "admin") {
        header('Location:../../views/home.php?link_up=' . sha1("home_admin_acceuil") . '&reponse=' . sha1($reponse));
        die;
    } else if ($type == "logistique") {
        header('Location:../../views/home.php?link_up=' . sha1("home_logistique_acceuil") . '&reponse=' . sha1($reponse));
        die;
    } else if ($type == "other") {
        header('Location:../../views/home.php?link_up=' . sha1("home_service_acceuil") . '&reponse=' . sha1($reponse));
        die;
    } else if ($type == "personnel") {
        header('Location:../../views/home.php?link_up=' . sha1("home_admin_acceuil") . '&reponse=' . sha1($reponse));
        die;
    } else if ($type == "membre") {
        header('Location:../../views/home.php?link_up=' . sha1("home_service_swaping") . '&reponse=' . sha1($reponse));
        die;
    } else if ($type == "administration") {
        header('Location:../../views/home.php?link_up=' . sha1("home_admin_acceuil") . '&reponse=' . sha1($reponse));
        die;
    } else if ($type == "hr_mb") {
        header('Location:../../views/home.php?link_up=' . sha1("home_admin_acceuil") . '&reponse=' . sha1($reponse));
        die;
    }
}


?>