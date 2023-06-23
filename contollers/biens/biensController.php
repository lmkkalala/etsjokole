<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../../models/connexion.php';

include '../../models/biens/biens.php';
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
    $quantite = securise($_POST['tb_quantite']);
    $stockcritique = securise($_POST['tb_stockcritique']);
    $typeperissable = securise($_POST['rb_typeperissable']);
    $idcategorie = securise($_POST['cb_categorie']);
    $prixunitaire = securise($_POST['tb_prixunitaire']);
    $codebarre = securise($_POST['tb_codebarre']);
    if (($designation!="") && ($idcategorie!=0) && ($prixunitaire!="")) {
        $bdbiens = new BdBiens();
        if ($bdbiens->addBiens($designation, "item", $quantite, "1", "1", $stockcritique, $typeperissable,"FIFO", $idcategorie,$prixunitaire,$codebarre)) {
            $error = "succes";
        } else {
            $error = "traitement_error";
        }
    } else {
        $error = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("logistique_biens_add") . '&reponse=' . sha1($error) . '&link_up=' . sha1("home_logistique_biens"));
}

if (isset($_POST['bt_modifier'])) {
    $idbiens=securise($_POST['tb_idbiens']);
    $designation = securise($_POST['tb_designation']);
    $marque = securise($_POST['tb_marque']);
    $quantite = securise($_POST['tb_quantite']);
    $stockmax = securise($_POST['tb_stockmax']);
    $stockmin = securise($_POST['tb_stockmin']);
    $stockcritique = securise($_POST['tb_stockcritique']);
    $typeperissable = securise($_POST['rb_typeperissable']);
    $gestion= securise($_POST['cb_gestion']);
    $idcategorie = securise($_POST['cb_categorie']);
    $prixunitaire = securise($_POST['tb_prixunitaire']);
    $codebarre = securise($_POST['tb_codebarre']);
    if ($idbiens != "" && $designation != "" && $idcategorie!=0 && $prixunitaire!=0) {
        $bdbiens=new BdBiens();
        if ($bdbiens->updateBiens($idbiens, $designation, $marque, $quantite, $stockmax, $stockmin, $stockcritique, $typeperissable,$gestion, $idcategorie,$prixunitaire,$codebarre)) {
            $reponse = "succes";
        } else {
            $reponse = "traitement_error";
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("logistique_biens_update_biens_all") . '&reponse=' . sha1($reponse) . '&link_up=' . sha1("home_logistique_biens"));
}

if (isset($_POST['bt_active'])) {
    $idbiens = securise($_POST['tb_idbiens']);
    $operation = securise($_POST['tb_operation']);
    if ($idbiens != "" && $operation != "") {
        $bdbiens=new BdBiens();
        if ($operation == "active") {
            if ($bdbiens->activeBiens($idbiens)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        } else {
            if ($bdbiens->desactiveBiens($idbiens)) {
                $reponse = "succes";
            } else {
                $reponse = "traitement_error";
            }
        }
    } else {
        $reponse = "remplissage_error";
    }
    header('Location:../../views/home.php?link=' . sha1("logistique_biens_active_biens_all") . '&reponse=' . sha1($reponse) . '&link_up=' . sha1("home_logistique_biens"));
}

if (isset($_POST['bt_search'])) {
    $reponse = "search_results";
    $motcle = $_POST['tb_search'];
    header('Location:../../views/home.php?link=' . sha1("logistique_biens_fiche_biens_all") . '&use=' . ($motcle) . '&link_up=' . sha1("home_logistique_biens"));
}

if (isset($_POST['bt_view'])) {
    $reponse = $_POST['tb_idbiens'];
    header('Location:../../views/home.php?link=' . sha1("logistique_biens_fiche_biens_self") . '&use=' . ($reponse) . '&link_up=' . sha1("home_logistique_biens"));
}

if (isset($_POST['bt_search_for_all'])) {
    $reponse = $_POST['cb_biens'];
    header('Location:../../views/home.php?link=' . sha1("logistique_biens_liste_biens_all") . '&use_biens=' . ($reponse) . '&link_up=' . sha1("home_logistique_biens"));
}

if (isset($_POST['bt_search_for_all_for_value'])) {
    $reponse = $_POST['cb_biens'];
    header('Location:../../views/home.php?link=' . sha1("logistique_biens_liste_biens_value_all") . '&use_biens=' . ($reponse) . '&link_up=' . sha1("home_logistique_biens"));
}

if (isset($_POST['bt_search_for_update'])) {
    $reponse = $_POST['cb_biens'];
    header('Location:../../views/home.php?link=' . sha1("logistique_biens_update_biens_all") . '&use_biens=' . ($reponse) . '&link_up=' . sha1("home_logistique_biens"));
}

if (isset($_POST['bt_search_for_active'])) {
    $reponse = $_POST['cb_biens'];
    header('Location:../../views/home.php?link=' . sha1("logistique_biens_active_biens_all") . '&use_biens=' . ($reponse) . '&link_up=' . sha1("home_logistique_biens"));
}

?>

