<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../../models/connexion.php';

include '../../models/agent/agent.php';
?>
<?php

if (isset($_POST['bt_enregistrer'])) {
//    echo $_FILES['tb_file']['name'];die;
    $nom = $_POST['tb_nom'];
    $postnom = $_POST['tb_postnom'];
    $prenom = $_POST['tb_prenom'];
    $sexe = $_POST['rb_sexe'];
    $grade = $_POST['tb_grade'];
    $codebar = $_POST['tb_codebar'];


    if ($nom != "" && $postnom != "" && $prenom != "" && $sexe != "" && $grade != "" && $codebar != "") {
        
        if (isset($_FILES['tb_file']['tmp_name']) and !empty(($_FILES['tb_file']['tmp_name']))) {
            $extensions = ['.png', '.gif', '.jpg', '.jpeg', '.PNG', '.GIF', '.JPG', '.JPEG'];
            $chemin_destination = '../../media/pictures-agent/';
            $extension_self = strrchr($_FILES['tb_file']['name'], '.');
            if (!in_array($extension_self, $extensions)) {
                $reponse = "format_error";
                header('Location:../../views/home.php?link=' . sha1("admin_agent_add") . '&link_up=' . sha1("home_admin_agent") . '&reponse=' . $reponse);
                die;
            }
            $fichier = basename($_FILES['tb_file']['name']);
            $resultat = move_uploaded_file($_FILES['tb_file']['tmp_name'], $chemin_destination . ($nom . "-" . $postnom . "-" . $prenom . "-" . $codebar . $extension_self));
        }else{
            $resultat = true;
        }
        
        if ($resultat) {
            $bdagent = new BdAgent();
            $agents=$bdagent->getAgentMaxId();
            $recentId=0;
            if (isset($agents[0])) {
                $recentId=$agents[0]['recentId'];
            }

            if ($bdagent->addAgent(($recentId+1),$nom, $postnom, $prenom, $sexe, $grade, $codebar, ($nom . "-" . $postnom . "-" . $prenom . "-" . $codebar . $extension_self))) {
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

    header('Location:../../views/home.php?link=' . sha1("admin_agent_add") . '&reponse=' . $reponse . '&link_up=' . sha1("home_admin_agent"));
}

if (isset($_POST['bt_modifier'])) {
    $idagent = $_POST['tb_idagent'];
    $nom = $_POST['tb_nom'];
    $postnom = $_POST['tb_postnom'];
    $prenom = $_POST['tb_prenom'];
    $sexe = $_POST['rb_sexe'];
    $grade = $_POST['tb_grade'];
    $codebar = $_POST['tb_codebar'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $daily_sell = $_POST['daily_sell'];
    $multi_seller_account = $_POST['multi_seller_account'];

    $with_upload = FALSE;
    $resultat = FALSE;
    if ($nom != "" && $postnom != "" && $prenom != "" && $sexe != "" && $grade != "" && $codebar != "") {
        if ((isset($_FILES['tb_file']['tmp_name'])) && (($_FILES['tb_file']['tmp_name']) == UPLOAD_ERR_OK)) {
            $extensions = ['.png', '.gif', '.jpg', '.jpeg', '.PNG', '.GIF', '.JPG', '.JPEG'];
            $chemin_destination = '../../media/pictures-agent/';
            $extension_self = strrchr($_FILES['tb_file']['name'], '.');
            if (!in_array($extension_self, $extensions)) {
                header('Location:../../views/home.php?link=' . sha1("admin_agent_update_agent_all") . '&link_up=' . sha1("home_admin_agent") . '&reponse=' . sha1("format_error"));
                die;
            }
            $fichier = basename($_FILES['tb_file']['name']);
            $resultat = move_uploaded_file($_FILES['tb_file']['tmp_name'], $chemin_destination . ($nom . "-" . $postnom . "-" . $prenom . "-" . $codebar . $extension_self));
            $with_upload = TRUE;
        }

        if ($with_upload) {
            if ($resultat) {
                $bdagent = new BdAgent();
                if ($bdagent->updateAgentWithPhoto($idagent, $nom, $postnom, $prenom, $sexe, $grade, $codebar, ($nom . "-" . $postnom . "-" . $prenom . "-" . $codebar . $extension_self), $start_time, $end_time, $daily_sell,$multi_seller_account)) {
                    $reponse = "succes";
                } else {
                    $reponse = "traitement_error";
                }
            } else {
                $reponse = "upload_error";
            }
        } else {
            $bdagent = new BdAgent();
            if ($bdagent->updateAgent($idagent, $nom, $postnom, $prenom, $sexe, $grade, $codebar,$start_time, $end_time, $daily_sell,$multi_seller_account)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        }
    } else {
        $reponse = "remplissage_error";
    }

    header('Location:../../views/home.php?link=' . sha1("admin_agent_update_agent_all") . '&reponse=' . $reponse . '&link_up=' . sha1("home_admin_agent"));
}

if (isset($_POST['bt_active'])) {
    $idagent = $_POST['tb_idagent'];
    $operation = $_POST['tb_operation'];
    if ($idagent != "" && $operation != "") {
        $bdagent = new BdAgent();
        if ($operation == "active") {
            if ($bdagent->activeAgent($idagent)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        } else {
            if ($bdagent->desactiveAgent($idagent)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("admin_agent_active_agent_all") . '&reponse=' . $reponse . '&link_up=' . sha1("home_admin_agent"));
}

if (isset($_POST['bt_search'])) {
    $reponse = "search_results";
    $motcle = $_POST['tb_search'];
    header('Location:../../views/home.php?link=' . sha1("admin_agent_fiche_agent_all") . '&use=' . ($motcle) . '&link_up=' . sha1("home_admin_agent"));
}

if (isset($_POST['bt_view'])) {
    $reponse = $_POST['tb_idagent'];
    header('Location:../../views/home.php?link=' . sha1("admin_agent_fiche_agent_self") . '&use=' . ($reponse) . '&link_up=' . sha1("home_admin_agent"));
}

if (isset($_POST['bt_search_for_update'])) {
    $reponse = "search_results";
    $motcle = $_POST['cb_agent'];
    header('Location:../../views/home.php?link=' . sha1("admin_agent_update_agent_all") . '&use_agent=' . ($motcle) . '&link_up=' . sha1("home_admin_agent"));
}

if (isset($_POST['bt_search_for_all'])) {
    $reponse = "search_results";
    $motcle = $_POST['cb_agent'];
    header('Location:../../views/home.php?link=' . sha1("admin_agent_liste_agent_all") . '&use_agent=' . ($motcle) . '&link_up=' . sha1("home_admin_agent"));
}

?>

