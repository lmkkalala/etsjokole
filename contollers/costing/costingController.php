<?php

session_start();

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../../models/connexion.php';

include '../../models/costing/Costing.php';
include '../../models/ravitaillement/ravitaillement.php';
include '../../models/unite/unite.php';
include '../../models/attribution-biens/attributionBiens.php';
include '../../models/addsin/Addsin.php';
include '../../models/operationF/OperationF.php';
include '../../models/connexionF.php';

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
    $dateSet = securise($_POST['tb_date']);
    $quantite = securise($_POST['tb_quantite']);
    $prix = securise($_POST['tb_prix']);
    $addsInId = securise($_POST['cb_addsin']);
    $ravitaillementId = securise($_POST['tb_idravitaillement']);
    if ($dateSet != '' && $quantite != '' && $prix != '' && $addsInId != '0' && $ravitaillementId != '') {
        $bdCosting = new BdCosting();
        if ($bdCosting->addCosting($dateSet, $quantite, $prix, $addsInId, $ravitaillementId)) {
             $prixRav=0;
            $bdravitaillement = new BdRavitaillement();
            $ravitaillements = $bdravitaillement->getRavitaillementById($ravitaillementId);
            foreach ($ravitaillements as $ravitaillement) {
                $id_attributionbiens = $ravitaillement['attribution_id'];
                $quantite_ravitaillement = $ravitaillement['quantite'];
                $prixRav = $ravitaillement['prix'];
            }
            
            

            $bdattributionbiens = new BdAttributionBiens();
            $attributions = $bdattributionbiens->getAttributionBiensById($id_attributionbiens);
            foreach ($attributions as $attribution) {
                $idbiens = $attribution['bId'];
                $newquantite = $attribution['quantite'];
                $biens_designation = $attribution['bDesignation'];
            }

            $bdAddsin = new BdAddsIn();
            $addsins = $bdAddsin->getAddsInById($addsInId);
            foreach ($addsins as $addsin) {
                $designation_addsIn = $addsin['designation'];
            }

            $bdUnite = new BdUnite();
            $unites = $bdUnite->getUniteByName($id_attributionbiens);
            foreach ($unites as $unite) {
                if ($bdUnite->updateUniteValueActuelle($unite['id'], ($unite['valueActuelle'] + (($quantite * $prix) / ($quantite_ravitaillement))))) {
                }
            }

            $libelle = 'Purchase adds-in Cost '.' Add-in: '.$designation_addsIn.' Item: '.$biens_designation.' Value: '.($quantite * $prix).' Date: '.$dateSet;
            $type = 'out';
            $responsable = $_SESSION['identite'];
            $domaine = 'Purchase adds-in cost';
            $montant = ($quantite * $prix);

            $bdOperationF = new BdOperationF();
            if ($bdOperationF->addOperation($libelle, $type, $responsable, $domaine, $montant)) {
                $error = 'succes';
                $cumulValeur=0;
                $costsRav=$bdCosting->getCostingByRavitaillementId($ravitaillementId);
                foreach($costsRav as $costRav) {
                $cumulValeur=$cumulValeur+($costRav['quantite']*$costRav['prix']);
                }
            
                $ratioCost=($cumulValeur/$quantite_ravitaillement);
                $bdravitaillement->updatePrixRavitaillement($idravitaillement, ($prixRav+$ratioCost));
            
            }
        } else {
            $error = 'traitement_error';
        }
    } else {
        $error = 'remplissage_error';
    }
    header('Location:../../views/home.php?reponse='.sha1($error).'&link='.sha1('logistique_costing_add').'&use_ravitaillement='.($ravitaillementId).'&link_up='.sha1('home_logistique_costing'));
}

if (isset($_POST['bt_modifier'])) {
    $idAddsIn = securise($_POST['tb_idaddsin']);
    $designation = securise($_POST['tb_designation']);

    if ($idAddsIn != '' && $designation != '') {
        $bdAddsin = new BdAddsIn();
        if ($bdAddsin->updateAddsIn($idAddsIn, $designation)) {
            $reponse = 'succes';
        } else {
            $reponse = 'traitement_error';
        }
    } else {
        $reponse = 'remplissage_error';
    }
    header('Location:../../views/home.php?link='.sha1('logistique_addsin_update_self').'&reponse='.sha1($reponse).'&link_up='.sha1('home_logistique_addsin').'&use_addsin='.($idAddsIn));
}

if (isset($_POST['bt_active'])) {
    $idAddsIn = securise($_POST['tb_idaddsin']);
    $operation = securise($_POST['tb_operation']);
    if ($idAddsIn != '' && $operation != '') {
        $bdAddsin = new BdAddsIn();
        if ($operation == 'active') {
            if ($bdAddsin->activeAddsIn($idAddsIn)) {
                $reponse = 'succes';
            } else {
                $reponse = 'traitement_error';
            }
        } else {
            if ($bdAddsin->desactiveAddsIn($idAddsIn)) {
                $reponse = 'succes';
            } else {
                $reponse = 'traitement_error';
            }
        }
    } else {
        $reponse = 'remplissage_error';
    }
    header('Location:../../views/home.php?link='.sha1('logistique_addsin_liste_all').'&reponse='.sha1($reponse).'&link_up='.sha1('home_logistique_addsin'));
}

if (isset($_POST['bt_delete'])) {
    $costingId = securise($_POST['tb_idcosting']);
    $ravitaillementId = securise($_POST['tb_idravitaillement']);
    $quantite = securise($_POST['tb_quantite']);
    $prix = securise($_POST['tb_prix']);

    if ($costingId != '') {
        $bdCosting = new BdCosting();

        $bdravitaillement = new BdRavitaillement();
        $ravitaillements = $bdravitaillement->getRavitaillementById($ravitaillementId);
        foreach ($ravitaillements as $ravitaillement) {
            $id_attributionbiens = $ravitaillement['attribution_id'];
            $quantite_ravitaillement = $ravitaillement['quantite'];
        }
        
        
        

        $bdUnite = new BdUnite();
        $unites = $bdUnite->getUniteByName($id_attributionbiens);
        foreach ($unites as $unite) {
            if ($bdUnite->updateUniteValueActuelle($unite['id'], ($unite['valueActuelle'] - (($quantite * $prix) / ($quantite_ravitaillement))))) {
            }
        }
        if ($bdCosting->deleteCosting($costingId)) {
            $reponse = 'succes';
                $cumulValeur=0;
                $costsRav=$bdCosting->getCostingByRavitaillementId($ravitaillementId);
                foreach($costsRav as $costRav) {
                $cumulValeur=$cumulValeur+($costRav['quantite']*$costRav['prix']);
                }
            
                $ratioCost=($cumulValeur/$quantite_ravitaillement);
                $bdravitaillement->updatePrixRavitaillement($idravitaillement, ($prixRav+$ratioCost));
        } else {
            $reponse = 'traitement_error';
        }
    } else {
        $reponse = 'remplissage_error';
    }
    header('Location:../../views/home.php?link='.sha1('logistique_costing_add').'&reponse='.sha1($reponse).'&use_ravitaillement='.($ravitaillementId).'&link_up='.sha1('home_logistique_costing'));
}

if (isset($_POST['bt_for_update'])) {
    $addsInId = $_POST['tb_idaddsin'];
    header('Location:../../views/home.php?link='.sha1('logistique_addsin_update_self').'&use_addsin='.($addsInId).'&link_up='.sha1('home_logistique_addsin'));
}

?>

