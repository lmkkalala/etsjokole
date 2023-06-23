<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../../models/connexionM.php';


include '../../models/employe/Employe.php';
?>

<?php

if (isset($_POST['bt_enregistrer'])) {
    $daterecrutement = $_POST['tb_daterecrutement'];
    $matricule = $_POST['tb_matricule'];
    $candidatureId = $_POST['cb_candidature'];
    if ($daterecrutement != "" && $matricule != "" && $candidatureId != 0) {
        if (1) {
            $bdemploye = new BdEmploye();
            $employes = $bdemploye->getEmployeByCandidatureByMatricule($candidatureId, $matricule);
            $i = 0;
            foreach ($employes as $employe) {
                $i++;
            }
            if ($i == 0) {
                if ($bdemploye->addEmploye($daterecrutement, $matricule, $candidatureId)) {
                    $reponse = "succes";
                } else {
                    $reponse = "traitement_error";
                }
            } else {
                $reponse = "doublons_error";
            }
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("admin_employe_add") . '&link_up=' . sha1("home_admin_employe") . '&reponse=' . sha1($reponse));die;
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
    $idcandidature = $_POST['tb_idcandidature'];
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

if (isset($_POST['bt_selection'])) {
    $idcandidature = $_POST['tb_idcandidature'];
    $operation = $_POST['tb_operation'];
    if ($idcandidature != "" && $operation != "") {
        $bdcandidature = new BdCandidature();
        if ($operation == "allow") {
            if ($bdcandidature->allowCandidature($idcandidature)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        } else {
            if ($bdcandidature->rejectCandidature($idcandidature)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("admin_candidature_accepte_candidature_all") . '&reponse=' . sha1($reponse) . '&link_up=' . sha1("home_admin_candidature"));
}
?>