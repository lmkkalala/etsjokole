<?php

session_start();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../../models/connexion.php';

include '../../models/swaping/swaping.php';
include '../../models/affectation-groupe/affectationGroupe.php';
include '../../models/preparation/preparation.php';
include '../../models/affectation-service/affectationService.php';
include '../../models/agent/agent.php';
include '../../models/groupe-swaping/groupeSwaping.php';
include '../../models/service/service.php';
?>
<?php

function securise($donnee) {
    $donnee = trim($donnee);
    $donnee = stripslashes($donnee);
    $donnee = strip_tags($donnee);
    return $donnee;
}

if (isset($_POST['bt_enregistrer'])) {
    $codebar = securise($_POST['tb_codebar']);
    if ($codebar != "") {
        $nombre_consomme = 0;
        $nombre_repas_groupe = FALSE;
        $bdagent = new BdAgent();
        $agents = $bdagent->getAgentByCodebar($codebar);
        foreach ($agents as $agent) {
            $id_agent = $agent['id'];
        }
//        echo $id_agent; die;
        if (isset($id_agent)) {
            $bdaffectationgroupe = new BdAffectationGroupe();
            $affectationgroupes = $bdaffectationgroupe->getAffectationGroupeActiveByAgent($id_agent);
            foreach ($affectationgroupes as $affectationgroupe) {
//                echo "oui"; die;
                $id_affectationgroupe = $affectationgroupe['id'];
                $etatblockage_affectationgroupe = $affectationgroupe['etatBlockage'];
                $id_service = $affectationgroupe['service_id'];
                $alloweverywhere=$affectationgroupe['alloweverywhere'];
                $bdgroupeswaping = new BdGroupeSwaping();
                $groupeswapings = $bdgroupeswaping->getGroupeSwapingById($affectationgroupe['groupeswaping_id']);
                foreach ($groupeswapings as $groupeswaping) {
                    $nombre_repas_groupe = $groupeswaping['nombrerepas'];
                }
            }

//            echo $nombre_repas_groupe; die;

            $bdswaping = new BdSwaping();
            $swapings = $bdswaping->getSwapingTodayByAffectationGroupe($id_affectationgroupe);
            foreach ($swapings as $swaping) {
                $nombre_consomme++;
            }

//            echo $nombre_consomme; die;

            if ($nombre_consomme < $nombre_repas_groupe) {
                $peu_manger = TRUE;
            }

//            echo $id_service; die;
            if ($peu_manger) {
                if ((isset($id_affectationgroupe)) && (isset($id_service))) {
                    $bdaffectationservice = new BdAffectationService();
                    $affectationservices = $bdaffectationservice->getAffectationServiceByIdSecond($_SESSION['idaffectation']);
                    foreach ($affectationservices as $affectationservice) {
                        if (($affectationservice['active']) && ($etatblockage_affectationgroupe == 0)) {
                            if (($affectationservice['Sid'] == $id_service) || ($alloweverywhere==1)) {
                                $bdserviceSecond = new BdService();
                                $servicesSecond = $bdserviceSecond->getServiceById($affectationservice['Sid']);
                                foreach ($servicesSecond as $serviceSecond) {
                                    $prixbreakfast = $serviceSecond['prixBreakfast'];
                                    $prixlunch = $serviceSecond['prixLunch'];
                                    $prixdinner = $serviceSecond['prixDinner'];
                                }
                                $items_date = explode(' ', (date('Y-m-d H:i')));
                                if ($items_date[1] < ('09:00:00')) {
                                    $type_repas = "breakfast";
                                    $prix_choosen = $prixbreakfast;
                                } else if ($items_date[1] < ('14:00:00')) {
                                    $type_repas = "lunch";
                                    $prix_choosen = $prixlunch;
                                } else {
                                    $type_repas = "dinner";
                                    $prix_choosen = $prixdinner;
                                }
                                $doublon_possible = "non";
                                $bdswaping = new BdSwaping();
                                $swapings_checking = $bdswaping->getSwapingAllByDate($items_date[0]);
                                foreach ($swapings_checking as $swaping_checking) {
                                    if ($swaping_checking['affectationGroupe_id'] == $id_affectationgroupe) {
                                        if ($swaping_checking['typerepas'] == $type_repas) {
                                            $doublon_possible = "oui";
                                        }
                                    }
                                }
//                                echo $doublon_possible; die;
                                if ($doublon_possible=="non") {
                                    if ($bdswaping->addSwaping($id_affectationgroupe, $_SESSION['idaffectation'], $type_repas, $prix_choosen,$affectationservice['Sid'])) {
                                        $error = "succes";
                                    } else {
                                        $error = "traitement_error";
                                    }
                                } else {
                                    $error = "doublon_error";
                                }
                            } else {
                                $error = "card_error";
                            }
                        } else {
                            $error = "card_error";
                        }
                    }
                } else {
                    $error = "card_error";
                }
            } else {
                $error = "nombre_repas_error";
            }
        } else {
            $error = "card_error";
        }
    } else {
        $error = "remplissage_error";
    }
    if (isset($id_agent)) {
        $idagent_return = $id_agent;
    } else {
        $idagent_return = 0;
    }
    header('Location:../../views/home.php?link=' . sha1("service_swaping_add") . '&reponse=' . sha1($error) . '&use_agent=' . ($idagent_return) . '&link_up=' . sha1("home_service_swaping"));
}

if (isset($_POST['bt_modifier'])) {
    $idcategorie = securise($_POST['tb_idcategorie']);
    $designation = securise($_POST['tb_designation']);
    if ($idcategorie != "" && $designation != "") {
        $bdcategorie = new BdCategorie();
        if ($bdcategorie->updateCategorie($idcategorie, $designation)) {
            $reponse = "succes";
        } else {
            $reponse = "traitement_error";
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("logistique_categorie_update_categorie_all") . '&reponse=' . sha1($reponse) . '&link_up=' . sha1("home_logistique_categorie"));
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
?>

