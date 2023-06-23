<?php

session_start();

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../../models/connexion.php';

include '../../models/production/production.php';
?>
<?php

function securise($donnee)
{
    $donnee = trim($donnee);
    $donnee = stripslashes($donnee);
    $donnee = strip_tags($donnee);

    return $donnee;
}

if (isset($_POST['bt_enregistrer'])) {
    $dateheure = securise($_POST['tb_dateheure']);
    $quantite = securise($_POST['tb_quantite']);

    $prixUnitaireVente = securise($_POST['tb_prixUnitaireVente']);

    $idnourriture = securise($_POST['cb_nourriture']);

    $serviceId=$_SESSION['idservice'];

    if (($dateheure != '') && ($quantite != '') && ($quantite != 0) && ($idnourriture != 0) && ($serviceId!="") && ($prixUnitaireVente!="")) {
        $bdproduction = new BdProduction();
        if ($bdproduction->addProduction($idnourriture, $dateheure, $quantite,$prixUnitaireVente,$serviceId)) {
            $error = 'succes';
        } else {
            $error = 'traitement_error';
        }
    } else {
        $error = 'remplissage_error';
    }
    header('Location:../../views/home.php?link='.sha1('service_production_add').'&reponse='.sha1($error).'&link_up='.sha1('home_service_production'));
}

if (isset($_POST['bt_modifier'])) {
    $idproduction = securise($_POST['tb_idproduction']);
    $quantite = securise($_POST['tb_quantite']);
    if ($idproduction != '' && $quantite != '') {
        $bdproduction = new BdProduction();
        if ($bdproduction->updateQuantiteProduction($idproduction, $quantite)) {
            $reponse = 'succes';
        } else {
            $reponse = 'traitement_error';
        }
    } else {
        $reponse = 'remplissage_error';
    }
    header('Location:../../views/home.php?link='.sha1('service_production_update_production_all').'&reponse='.sha1($reponse).'&link_up='.sha1('home_service_production'));
}

if (isset($_POST['bt_active'])) {
    $idproduction = securise($_POST['tb_idproduction']);
    $operation = securise($_POST['tb_operation']);
    if ($idproduction != '' && $operation != '') {
        $bdproduction = new BdProduction();
        if ($operation == 'active') {
            if ($bdproduction->activeProduction($idproduction)) {
                $reponse = 'succes';
            } else {
                $reponse = 'traitement_error';
            }
        } else {
            if ($bdproduction->desactiveProduction($idproduction)) {
                $reponse = 'succes';
            } else {
                $reponse = 'traitement_error';
            }
        }
    } else {
        $reponse = 'remplissage_error';
    }
    header('Location:../../views/home.php?link='.sha1('service_production_active_production_all').'&reponse='.sha1($reponse).'&link_up='.sha1('home_service_production'));
}

if (isset($_POST['bt_search'])) {
    $reponse = 'search_results';
    $motcle = $_POST['tb_search'];
    header('Location:../../views/home.php?link='.sha1('logistique_categorie_fiche_categorie_all').'&use='.($motcle).'&link_up='.sha1('home_logistique_categorie'));
}

if (isset($_POST['bt_view'])) {
    $reponse = $_POST['tb_idcategorie'];
    header('Location:../../views/home.php?link='.sha1('logistique_categorie_fiche_categorie_self').'&use='.($reponse).'&link_up='.sha1('home_logistique_categorie'));
}

if (isset($_POST['bt_select_nourriture'])) {
    $nourritureId = $_POST['tb_idnourriture'];
    header('Location:../../views/home.php?link='.sha1('service_production_liste_production_by_product').'&use='.($nourritureId).'&link_up='.sha1('home_service_production'));
}

if (isset($_POST['bt_select_dates_by_product'])) {
    $nourritureId = $_POST['tb_nourritureId'];

    $date1 = $_POST['tb_date1'];
    $date2 = $_POST['tb_date2'];
    header('Location:../../views/home.php?link='.sha1('service_production_liste_production_by_product').'&use='.($nourritureId).'&date1='.($date1).'&date2='.($date2).'&link_up='.sha1('home_service_production'));
}

if (isset($_POST['bt_select_dates_all'])) {

    $date1 = $_POST['tb_date1'];
    $date2 = $_POST['tb_date2'];
    header('Location:../../views/home.php?link='.sha1('service_production_liste_production_by_dates').'&date1='.($date1).'&date2='.($date2).'&link_up='.sha1('home_service_production'));
}

?>

