<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../../models/connexionM.php';


include '../../models/bulletin/Bulletin.php';
include '../../models/ligne-salaire/LigneSalaire.php';
include '../../models/ligne-imposition/LigneImposition.php';
?>

<?php

if (isset($_POST['bt_enregistrer'])) {
    $datecreation = $_POST['tb_datecreation'];
    $idcompte = $_POST['cb_compte'];
    $chaine_composantesalaire_selectionnee = $_POST['tb_use_chaine_composantesalaire'];
    $idlivrepaie = $_POST['tb_use_livrepaie'];
    $idaffectationservice = $_POST['tb_use_affectationservice'];
    $idchargeconf = $_POST['tb_idchargeconf'];
    $chaine_composante_imposition = $_POST['tb_chaine_composanteimposition'];

    if ($datecreation != "" && $idcompte != 0 && $chaine_composantesalaire_selectionnee != "" && $idlivrepaie != "" && $idaffectationservice != "") {

        $bdbulletin = new BdBulletin();
        $j = 0;
        $bulletins = $bdbulletin->getBulletinByAffectationServiceByLivrePaieActive($idaffectationservice, $idlivrepaie);
        foreach ($bulletins as $bulletin) {
            $j++;
        }
        if ($j == 0) {
            if ($bdbulletin->addBulletin($datecreation, $idaffectationservice, $idcompte, $idlivrepaie, $idchargeconf, $chaine_composantesalaire_selectionnee, $chaine_composante_imposition)) {
                $reponse = "succes";
                $bulletins = $bdbulletin->getBulletinRecent();
                foreach ($bulletins as $bulletin) {
                    $maxId = $bulletin['maxId'];
                }

                $items_composantesalaire = explode('/', $chaine_composantesalaire_selectionnee);
                foreach ($items_composantesalaire as $item_composantesalaire) {
                    if ($item_composantesalaire != "") {
                        $items_contenue = explode('-', $item_composantesalaire);

                        $id_confsalaire_item = $items_contenue[0];
                        $quantite_item = $items_contenue[1];

                        $bdlignesalaire = new BdLigneSalaire();
                        if ($bdlignesalaire->addLigneSalaire($quantite_item, $id_confsalaire_item, $maxId)) {
                            $reponse = "succes";
                        } else {
                            $reponse = "traitement_error";
                        }
                    }
                }

                $items_composanteimposition = explode('-', $chaine_composante_imposition);
                foreach ($items_composanteimposition as $item_composanteimposition) {
                    if ($item_composanteimposition != "") {

                        $bdligneimposition = new BdLigneImposition();
                        if ($bdligneimposition->addLigneImposition($item_composanteimposition, $maxId)) {
                            $reponse = "succes";
                        } else {
                            $reponse = "traitement_error";
                        }
                    }
                }
            } else {
                $reponse = "traitement_error";
            }
        } else {
            $reponse = "doublons_error";
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("admin_bulletin_completation") . '&use_livrepaie=' . ($idlivrepaie) . '&use_chaine_composantesalaire=' . ($chaine_composantesalaire_selectionnee) . '&use_affectationservice=' . ($idaffectationservice) . '&use_compte=' . ($idcompte) . '&use_datecreation=' . ($datecreation) . '&use_printable=' . ("yes") . '&reponse=' . sha1($reponse) . '&link_up=' . sha1("home_admin_bulletin"));
    die;
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
    $idfonction = $_POST['tb_idfonction'];
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

if (isset($_POST['bt_continuer'])) {
    $reponse = "search_results";
    $idlivrepaie = $_POST['cb_livrepaie'];
    $idaffectationservice = $_POST['cb_affectationservice'];
    if ($idlivrepaie != 0 && $idaffectationservice != 0) {
        header('Location:../../views/home.php?link=' . sha1("admin_bulletin_completation") . '&use_livrepaie=' . ($idlivrepaie) . '&use_chaine_composantesalaire=' . ("") . '&use_affectationservice=' . ($idaffectationservice) . '&use_printable=' . ("no") . '&link_up=' . sha1("home_admin_bulletin"));
    } else {
        $reponse="remplissage_error";
        header('Location:../../views/home.php?link=' . sha1("admin_bulletin_add") . '&reponse=' . sha1($reponse) . '&link_up=' . sha1("home_admin_bulletin"));
    }
}

if (isset($_POST['bt_select_composantesalaire'])) {
    $reponse = "search_results";
    $idlivrepaie = $_POST['tb_use_livrepaie'];
    $idaffectationservice = $_POST['tb_use_affectationservice'];
    $chaine_composantesalaire = ($_POST['tb_use_chaine_composantesalaire'] . $_POST['tb_idconfsalaire'] . "-" . $_POST['tb_quantite'] . "/");
    header('Location:../../views/home.php?link=' . sha1("admin_bulletin_completation") . '&use_livrepaie=' . ($idlivrepaie) . '&use_chaine_composantesalaire=' . ($chaine_composantesalaire) . '&use_affectationservice=' . ($idaffectationservice) . '&use_printable=' . ("no") . '&link_up=' . sha1("home_admin_bulletin"));
}

if (isset($_POST['bt_remove_composantesalaire'])) {
    $reponse = "search_results";
    $idlivrepaie = $_POST['tb_use_livrepaie'];
    $idaffectationservice = $_POST['tb_use_affectationservice'];
    $new_chaine = "";
    $items_composantesalaire = explode('/', $_POST['tb_use_chaine_composantesalaire']);
    foreach ($items_composantesalaire as $item_composantesalaire) {
        if ($item_composantesalaire != "") {
            $items_contenue = explode('-', $item_composantesalaire);

            $id_confsalaire_item = $items_contenue[0];
            $quantite_item = $items_contenue[1];

            if ($id_confsalaire_item != $_POST['tb_idconfsalaire']) {
                $new_chaine = $new_chaine . $id_confsalaire_item . "-" . $quantite_item . "/";
            }
        }
    }

    $chaine_composantesalaire = ($_POST['tb_use_chaine_composantesalaire'] . $_POST['tb_idconfsalaire'] . "-" . $_POST['tb_quantite'] . "/");
    header('Location:../../views/home.php?link=' . sha1("admin_bulletin_completation") . '&use_livrepaie=' . ($idlivrepaie) . '&use_chaine_composantesalaire=' . ($new_chaine) . '&use_affectationservice=' . ($idaffectationservice) . '&use_printable=' . ("no") . '&link_up=' . sha1("home_admin_bulletin"));
}

if (isset($_POST['bt_desactive_bulletin'])) {
    $reponse = "search_results";
    $idbulletin = $_POST['tb_idbulletin'];
    $idaffectationservice = $_POST['tb_use_affectationservice'];

    $bdbulletin = new BdBulletin();
    if ($bdbulletin->desactiveBulleltin($idbulletin)) {
        $reponse = "succes";
    } else {
        $reponse = "traitement_error";
    }

    header('Location:../../views/home.php?link=' . sha1("admin_bulletin_liste_bulletin_by_affectationservice") . '&reponse=' . sha1($reponse) . '&use_affectationservice=' . ($idaffectationservice) . '&link_up=' . sha1("home_admin_bulletin"));
}

if (isset($_POST['bt_search_by_idaffectationservice'])) {
    $reponse = "search_results";
    $idaffectationservice = $_POST['cb_affectationservice'];
    header('Location:../../views/home.php?link=' . sha1("admin_bulletin_liste_bulletin_by_affectationservice") . '&use_affectationservice=' . ($idaffectationservice) . '&link_up=' . sha1("home_admin_bulletin"));
}

if (isset($_POST['bt_search_by_idlivrepaie'])) {
    $reponse = "search_results";
    $idlivrepaie = $_POST['cb_livrepaie'];
    header('Location:../../views/home.php?link=' . sha1("admin_bulletin_liste_bulletin_by_livrepaie") . '&use_livrepaie=' . ($idlivrepaie) . '&link_up=' . sha1("home_admin_bulletin"));
}
?>