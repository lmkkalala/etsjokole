<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../../models/connexion.php';

include '../../models/affectation-groupe/affectationGroupe.php';
include '../../models/agent/agent.php';
?>
<?php

function securise($donnee) {
    $donnee = trim($donnee);
    $donnee = stripslashes($donnee);
    $donnee = strip_tags($donnee);
    return $donnee;
}

if (isset($_POST['bt_enregistrer'])) {
    $idagent = securise($_POST['cb_agent']);
    $idgroupeswaping = securise($_POST['cb_groupeswaping']);
    $idservice = securise($_POST['cb_service']);
    $idfonction = securise($_POST['cb_fonction']);
    if (($idagent != 0) && ($idgroupeswaping != 0) && ($idservice != 0) && ($idfonction != 0)) {
        $bdaffectationgroupe = new BdAffectationGroupe();
        if ($bdaffectationgroupe->desactiveAllByAgent($idagent)) {
            if (isset($_POST['chk_alloweverywhere'])) {
                if ($bdaffectationgroupe->addAffectationGroupeAllowEveryWhere($idagent, $idgroupeswaping, $idservice, $idfonction)) {
                    $error = "succes";
                } else {
                    $error = "traitement_error";
                }
            } else {
                if ($bdaffectationgroupe->addAffectationGroupe($idagent, $idgroupeswaping, $idservice, $idfonction)) {
                    $error = "succes";
                } else {
                    $error = "traitement_error";
                }
            }
        }
    } else {
        $error = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("admin_affectation_groupe_add") . '&reponse=' . sha1($error) . '&link_up=' . sha1("home_admin_affectation_groupe"));
}

if (isset($_POST['bt_blocker'])) {
    $idaffectationgroupe = securise($_POST['cb_affectationgroupe']);
    $dateOuverture = securise($_POST['tb_dateOuverture']);
    if ($idaffectationgroupe != 0) {
        $bdaffectationgroupe = new BdAffectationGroupe();
        if (isset($_POST['chk_forevermore'])) {
            if ($bdaffectationgroupe->blockAffectationGroupeForevermore($idaffectationgroupe, $dateOuverture)) {
                $affectationgroupes = $bdaffectationgroupe->getAffectationGroupeById($idaffectationgroupe);
                foreach ($affectationgroupes as $affectationgroupe) {
                    $id_agent = $affectationgroupe['agent_id'];
                }
                $bdagent = new BdAgent();
                if ($bdagent->desactiveAgent($id_agent)) {
                    $reponse = "succes";
                }
            } else {
                $reponse = "traitement_error";
            }
        } else {
            if ($bdaffectationgroupe->blockAffectationGroupe($idaffectationgroupe, $dateOuverture)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("admin_affectation_groupe_blockage") . '&reponse=' . sha1($reponse) . '&link_up=' . sha1("home_admin_affectation_groupe"));
}

if (isset($_POST['bt_deblocker'])) {
    $idaffectationgroupe = securise($_POST['cb_affectationgroupe']);
    if ($idaffectationgroupe != 0) {
        $bdaffectationgroupe = new BdAffectationGroupe();
        if ($bdaffectationgroupe->deblockAffectationGroupe($idaffectationgroupe)) {
            $reponse = "succes";
        } else {
            $reponse = "traitement_error";
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("admin_affectation_groupe_deblockage") . '&reponse=' . sha1($reponse) . '&link_up=' . sha1("home_admin_affectation_groupe"));
}

if (isset($_POST['bt_active'])) {
    $idcategorie = securise($_POST['tb_idcategorie']);
    $operation = securise($_POST['tb_operation']);
    if ($idcategorie != "" && $operation != "") {
        $bdcategorie = new BdCategorie();
        if ($operation == "active") {
            if ($bdcategorie->activeCategorie($idcategorie)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        } else {
            if ($bdcategorie->desactiveCategorie($idcategorie)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("logistique_categorie_active_categorie_all") . '&reponse=' . sha1($reponse) . '&link_up=' . sha1("home_logistique_categorie"));
}

if (isset($_POST['bt_search'])) {
    $reponse = "search_results";
    $motcle = $_POST['tb_search'];
    header('Location:../../views/home.php?link=' . sha1("logistique_categorie_fiche_categorie_all") . '&use=' . ($motcle) . '&link_up=' . sha1("home_logistique_categorie"));
}

if (isset($_POST['bt_view'])) {
    $reponse = $_POST['tb_idcategorie'];
    header('Location:../../views/home.php?link=' . sha1("logistique_categorie_fiche_categorie_self") . '&use=' . ($reponse) . '&link_up=' . sha1("home_logistique_categorie"));
}

if (isset($_POST['bt_search_for_affectation_groupe_departement'])) {
    $iddepartement = $_POST['cb_fonction'];

    header('Location:../../views/home.php?link=' . sha1("admin_affectation_groupe_liste_active") . '&use_departement=' . ($iddepartement) . '&link_up=' . sha1("home_admin_affectation_groupe"));
}

if (isset($_POST['bt_search_for_affectation_groupe_departement_blocke'])) {
    $iddepartement = $_POST['cb_fonction'];

    header('Location:../../views/home.php?link=' . sha1("admin_affectation_groupe_liste_blocke") . '&use_departement=' . ($iddepartement) . '&link_up=' . sha1("home_admin_affectation_groupe"));
}

if (isset($_POST['bt_search_for_affectation_groupe_departement_desactive'])) {
    $iddepartement = $_POST['cb_fonction'];

    header('Location:../../views/home.php?link=' . sha1("admin_affectation_groupe_liste_desactive") . '&use_departement=' . ($iddepartement) . '&link_up=' . sha1("home_admin_affectation_groupe"));
}
?>

