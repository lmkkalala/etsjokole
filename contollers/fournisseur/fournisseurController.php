<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../../models/connexion.php';

include '../../models/agent/agent.php';
include '../../models/fournisseur/fournisseur.php';
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
    $domaine = securise($_POST['tb_domaine']);
    $adresse = securise($_POST['tb_adresse']);
    $ville = securise($_POST['tb_ville']);
    $province = securise($_POST['tb_province']);
    $pays = securise($_POST['tb_pays']);
    $telephone = securise($_POST['tb_telephone']);
    $email = securise($_POST['tb_email']);
    if ($designation != "" && $domaine != "" && $adresse != "" && $ville != "" && $province != "" && $pays != "") {
        $bdfournisseur = new BdFournisseur();
        if ($bdfournisseur->addFournisseur($designation, $domaine, $adresse, $ville, $province, $pays,$telephone,$email)) {
            $error = "succes";
        } else {
            $error = "traitement_error";
        }
    } else {
        $error = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("logistique_fournisseur_add") . '&reponse=' . sha1($error) . '&link_up=' . sha1("home_logistique_fournisseur"));
}

if (isset($_POST['bt_modifier'])) {
    $idfournisseur = securise($_POST['tb_idfournisseur']);
    $designation = securise($_POST['tb_designation']);
    $domaine = securise($_POST['tb_domaine']);
    $adresse = securise($_POST['tb_adresse']);
    $ville = securise($_POST['tb_ville']);
    $province = securise($_POST['tb_province']);
    $pays = securise($_POST['tb_pays']);
    $telephone = securise($_POST['tb_telephone']);
    $email = securise($_POST['tb_email']);
    if ($idfournisseur != "" && $designation != "" && $domaine != "" && $adresse != "" && $ville != "" && $province != "" && $pays != "") {
        $bdfournisseur = new BdFournisseur();
        if ($bdfournisseur->updateFournisseur($idfournisseur, $designation, $domaine, $adresse, $ville, $province, $pays,$telephone,$email)) {
            $reponse = "succes";
        } else {
            $reponse = "traitement_error";
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("logistique_fournisseur_update_fournisseur_all") . '&reponse=' . sha1($reponse) . '&link_up=' . sha1("home_logistique_fournisseur"));
}

if (isset($_POST['bt_active'])) {
    $idfournisseur = $_POST['tb_idfournisseur'];
    $operation = $_POST['tb_operation'];
    if ($idfournisseur != "" && $operation != "") {
        $bdfournisseur = new BdFournisseur();
        if ($operation == "active") {
            if ($bdfournisseur->activeFournisseur($idfournisseur)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        } else {
            if ($bdfournisseur->desactiveFournisseur($idfournisseur)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("logistique_fournisseur_active_fournisseur_all") . '&reponse=' . sha1($reponse) . '&link_up=' . sha1("home_logistique_fournisseur"));
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
?>

