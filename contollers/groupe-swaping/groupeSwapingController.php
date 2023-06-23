<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../../models/connexion.php';


include '../../models/groupe-swaping/groupeSwaping.php';
?>

<?php

if (isset($_POST['bt_enregistrer'])) {
    $designation = $_POST['tb_designation'];
    $nombrerepas = $_POST['tb_nombre_repas'];

    if ($designation != "" && ($nombrerepas!="")) {
        if (1) {
            $bdgroupeswaping=new BdGroupeSwaping();
            if ($bdgroupeswaping->addGroupeSwaping($designation,$nombrerepas)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        } else {
            $reponse = "remplissage_error";
        }
        header('Location:../../views/home.php?link=' . sha1("admin_groupe_swaping_add") . '&link_up=' . sha1("home_admin_groupe_swaping") . '&reponse=' . sha1($reponse));
        die;
    }
}

if (isset($_POST['bt_modifier'])) {
    $idgroupeswaping = $_POST['tb_idgroupeswaping'];
    $designation = $_POST['tb_designation'];
    $nombrerepas = $_POST['tb_nombre_repas'];

    if (($designation != "") && ($nombrerepas!="")) {
        $bdgroupeswaping=new BdGroupeSwaping();
        if ($bdgroupeswaping->updateGroupeSwaping($idgroupeswaping, $designation,$nombrerepas)) {
            $reponse = "succes";
        } else {
            $reponse = "traitement_error";
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("admin_groupe_swaping_update_groupe_swaping_all") . '&link_up=' . sha1("home_admin_groupe_swaping") . '&reponse=' . sha1($reponse));
    die;
}

if (isset($_POST['bt_active'])) {
    $idgroupeswaping = $_POST['tb_idgroupeswaping'];
    $operation = $_POST['tb_operation'];
    if ($idgroupeswaping != "" && $operation != "") {
        $bdgroupeswaping=new BdGroupeSwaping();
        if ($operation == "active") {
            if ($bdgroupeswaping->activeGroupeSwaping($idgroupeswaping)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        } else {
            if ($bdgroupeswaping->desactiveGroupeSwaping($idgroupeswaping)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("admin_groupe_swaping_active_groupe_swaping_all") . '&reponse=' . sha1($reponse).'&link_up='.sha1("home_admin_groupe_swaping"));
}

if (isset($_POST['bt_search_for_swaping'])) {
    $reponse = "search_results";
    $date_1 = $_POST['tb_date1'];
    $date_2 = $_POST['tb_date2'];
    $idfonction=$_POST['cb_fonction'];
    $idservice=$_POST['cb_service'];
//    echo $date_1;
//    echo $date_2;die;
    
    header('Location:../../views/home.php?link=' . sha1("admin_groupe_swaping_stat") . '&use_date1=' . ($date_1) .'&use_date2=' . ($date_2) .'&use_departement=' . ($idfonction).'&use_service=' . ($idservice). '&link_up=' . sha1("home_admin_groupe_swaping"));
}

if (isset($_POST['bt_search_for_swaping_simple'])) {
    $reponse = "search_results";
    $date_1 = $_POST['tb_date1'];
    $date_2 = $_POST['tb_date2'];
    $idfonction=$_POST['cb_fonction'];
    $idservice=$_POST['cb_service'];
//    echo $date_1;
//    echo $date_2;die;
            
    header('Location:../../views/home.php?link=' . sha1("admin_groupe_swaping_stat_simple") . '&use_date1=' . ($date_1) .'&use_date2=' . ($date_2) .'&use_departement=' . ($idfonction).'&use_service=' . ($idservice). '&link_up=' . sha1("home_admin_groupe_swaping"));
}




?>