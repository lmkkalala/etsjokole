<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../../models/connexion.php';

include '../../models/participation/participation.php';
include '../../models/livraison/livraison.php';
include '../../models/ravitaillement/ravitaillement.php';

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


    $preparationId = securise($_POST['tb_preparationId']);
    $productionId = securise($_POST['tb_productionId']);

    $costForParticipation=0;
    $costForParticipation_total=0;
    $stringForCost="";
    
    $bdlivraison = new BdLivraison();
    $livraisons = $bdlivraison->getLivraisonAllDesc();
    foreach ($livraisons as $livraison) {
        if (($livraison['preparationId']==$preparationId)) {
            $somme_prix_biens = 0;
            $s = 0;
            $bdravitaillement = new BdRavitaillement();
            $ravitaillements = $bdravitaillement->getRavitaillementByIdBiens($livraison['bId']);
            foreach ($ravitaillements as $ravitaillement) {
                $s++;
                $somme_prix_biens = $somme_prix_biens + $ravitaillement['prix'];
            }
            $average_price = ($somme_prix_biens / $s);
            $quantiteForParticipation=$_POST['tb_lq'.$livraison['lId']];
            
            $stringForCost=$stringForCost.$livraison['lId'].":".$quantiteForParticipation." * ".$average_price. "--";
            
            if (($quantiteForParticipation!='') && is_numeric($quantiteForParticipation)) {
                $costForParticipation=($quantiteForParticipation*$average_price);
                $costForParticipation_total=$costForParticipation_total+$costForParticipation;
            }

            
        }
        
    }

    // echo $stringForCost; echo "------------";
    // echo $costForParticipation_total; die;


    if (($stringForCost!="") && ($preparationId != 0) && ($productionId != 0)) {
        $bdParticipation = new BdParticipation();
        if ($bdParticipation->addParticipation($preparationId,$productionId,$stringForCost)) {
            $error = 'succes';
        } else {
            $error = 'traitement_error';
        }
    } else {
        $error = 'remplissage_error';
    }
    header('Location:../../views/home.php?link='.sha1('service_participation_add').'&use_preparation='.($preparationId).'&use_production='.($productionId).'&reponse='.sha1($error).'&link_up='.sha1('home_service_participation'));
    die;
}

if (isset($_POST['bt_update'])) {


    $preparationId = securise($_POST['tb_preparationId']);
    $productionId = securise($_POST['tb_productionId']);
    $participationId = securise($_POST['tb_participationId']);

    $costForParticipation=0;
    $costForParticipation_total=0;
    $stringForCost="";
    
    $bdlivraison = new BdLivraison();
    $livraisons = $bdlivraison->getLivraisonAllDesc();
    foreach ($livraisons as $livraison) {
        if (($livraison['preparationId']==$preparationId)) {
            $somme_prix_biens = 0;
            $s = 0;
            $bdravitaillement = new BdRavitaillement();
            $ravitaillements = $bdravitaillement->getRavitaillementByIdBiens($livraison['bId']);
            foreach ($ravitaillements as $ravitaillement) {
                $s++;
                $somme_prix_biens = $somme_prix_biens + $ravitaillement['prix'];
            }
            $average_price = ($somme_prix_biens / $s);
            $quantiteForParticipation=$_POST['tb_lq'.$livraison['lId']];
            
            $stringForCost=$stringForCost.$livraison['lId'].":".$quantiteForParticipation." * ".$average_price. "--";
            
            if (($quantiteForParticipation!='') && is_numeric($quantiteForParticipation)) {
                $costForParticipation=($quantiteForParticipation*$average_price);
                $costForParticipation_total=$costForParticipation_total+$costForParticipation;
            }

            
        }
        
    }

    // echo $stringForCost; echo "------------";
    // echo $costForParticipation_total; die;


    if (($stringForCost!="") && ($preparationId != 0) && ($productionId != 0)) {
        $bdParticipation = new BdParticipation();
        // echo $stringForCost; die;
        if ($bdParticipation->updateParticipation($participationId,$stringForCost)) {
            $error = 'succes';
        } else {
            $error = 'traitement_error';
        }
    } else {
        $error = 'remplissage_error';
    }
    header('Location:../../views/home.php?link='.sha1('service_participation_add').'&use_preparation='.($preparationId).'&use_production='.($productionId).'&reponse='.sha1($error).'&link_up='.sha1('home_service_participation'));
    die;
}

if (isset($_POST['bt_select_preparation'])) {
    $reponse = "search_results";
    $preparationId = $_POST['cb_preparation'];
    header('Location:../../views/home.php?link='.sha1('service_participation_add').'&reponse='.sha1($error).'&use_preparation='.($preparationId).'&link_up='.sha1('home_service_participation'));
    die;
}

if (isset($_POST['bt_select_preparation_et_production'])) {
    $reponse = "search_results";
    $preparationId = $_POST['cb_preparation'];
    $productionId = $_POST['cb_production'];
    header('Location:../../views/home.php?link='.sha1('service_participation_add').'&reponse='.sha1($error).'&use_preparation='.($preparationId).'&use_production='.($productionId).'&link_up='.sha1('home_service_participation'));
    die;
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
?>

