<?php



session_start();

/*

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */

include '../../models/connexion.php';



include '../../models/livraison/livraison.php';

include '../../models/biens/biens.php';

include '../../models/demande/demande.php';

include '../../models/unite/unite.php';

include '../../models/crud/db.php';
    
function add($table,$field,$prepared,$value){
    $DB = new db();
    return $DB->insert($table,$field,$prepared,$value);
}

?>



<?php



function securise($donnee) {

    $donnee = trim($donnee);

    $donnee = stripslashes($donnee);

    $donnee = strip_tags($donnee);

    return $donnee;

}



if (isset($_POST['bt_enregistrer'])) {

    $iddemande = securise($_POST['tb_iddemande']);

    $idaffectation = securise($_SESSION['idaffectation']);

    $date = securise($_POST['tb_date']);

    $quantite = securise($_POST['tb_quantite']);

    $idpreparation = securise($_POST['tb_idpreparation']);

//    echo $date; die;

    if ($iddemande != 0 && $idaffectation != 0 && $date != "" && floatval($quantite) > 0 && $idpreparation != 0) {

        $bdlivraison = new BdLivraison();

        $bddemande = new BdDemande();

        $bdbiens = new BdBiens();

        $bddemande = new BdDemande();

        $demandes = $bddemande->getDemandeById($iddemande);

//        echo $iddemande; die;

        foreach ($demandes as $demande) {

            $idbiens = $demande['bId'];

//            echo $demande['dQuantite']; die;

            $demande_quantite = $demande['dQuantite'];

            $quantite_actuel_biens = $demande['quantite'];

        }

//        echo $newquantite; die;

        if (($quantite <= $demande_quantite) && ($quantite_actuel_biens > 0)) {

            $newquantite = $quantite_actuel_biens - $quantite;

            if ($newquantite >= 0) {

                if (!empty($_POST['lieu_id']) and !empty($_POST['prix_reception']) and !empty($_POST['stockage_id'])) {
                    $table = 'receptionautreprix';
                    $field = '(date,bien_id,lieu_id,prix_reception,stockage_id,addedbyID)';
                    $prepared = '?,?,?,?,?,?';
                    
                    $value = array(
                        date('Y-m-d',time()),
                        securise($_POST['bien_id']),
                        securise($_POST['lieu_id']),
                        securise($_POST['prix_reception']),
                        securise($_POST['stockage_id']),
                        $_SESSION['idutilisateur']
                    );
                    add($table,$field,$prepared,$value);
                }

                if ($bdlivraison->addLivraison($date, $quantite, $iddemande, $idaffectation)) {

                    if ($bddemande->finaliseDemande($iddemande)) {

                        if ($bdbiens->diminueQuantiteBiens($idbiens, $newquantite)) {

                            $error = "succes";

                            header('Location:../../views/home.php?link=' . sha1("logistique_livraison_panier_livraison_add") . '&use_preparation=' . ($idpreparation) . '&reponse=' . sha1($error) . '&link_up=' . sha1("home_logistique_livraison"));

                            die;

                        } else {

                            $error = "traitement_error";

                            header('Location:../../views/home.php?link=' . sha1("logistique_livraison_add") . '&use_preparation=' . ($idpreparation) . '&reponse=' . sha1($error) . '&link_up=' . sha1("home_logistique_livraison"));

                            die;

                        }

                    } else {

                        $error = "traitement_error";

                        header('Location:../../views/home.php?link=' . sha1("logistique_livraison_add") . '&use_preparation=' . ($idpreparation) . '&reponse=' . sha1($error) . '&link_up=' . sha1("home_logistique_livraison"));

                        die;

                    }

                } else {

                    $error = "traitement_error";

                    header('Location:../../views/home.php?link=' . sha1("logistique_livraison_add") . '&use_preparation=' . ($idpreparation) . '&reponse=' . sha1($error) . '&link_up=' . sha1("home_logistique_livraison"));

                    die;

                }

            } else {

                $error = "quantite_error";

                header('Location:../../views/home.php?link=' . sha1("logistique_livraison_add") . '&use_preparation=' . ($idpreparation) . '&reponse=' . sha1($error) . '&link_up=' . sha1("home_logistique_livraison"));

                die;

            }

        } else {

            $error = "quantite_error";

            header('Location:../../views/home.php?link=' . sha1("logistique_livraison_add") . '&use_preparation=' . ($idpreparation) . '&reponse=' . sha1($error) . '&link_up=' . sha1("home_logistique_livraison"));

            die;

        }

    } else {

        $error = "remplissage_error";

        header('Location:../../views/home.php?link=' . sha1("logistique_livraison_add") . '&use_preparation=' . ($idpreparation) . '&reponse=' . sha1($error) . '&link_up=' . sha1("home_logistique_livraison"));

        die;

    }

}



if (isset($_POST['bt_update_date'])) {

    $date1 = $_POST['tb_date1'];

    $date2 = $_POST['tb_date2'];

    $idservice = $_POST['tb_idservice'];

    $typerepas = $_POST['tb_typerepas'];

    $idbiens = $_POST['tb_idbiens'];

    $idlivraison = $_POST['tb_idlivraison'];

    $newdate = $_POST['tb_newdate'];

//    echo $idlivraison; die;

    if ($newdate != "") {

        $bdlivraison = new BdLivraison();

        if ($bdlivraison->updateDateLivraison($idlivraison, $newdate)) {

//            echo "dedans"; die;

            $reponse = "succes";

        } else {

            $reponse = "traitement_error";

        }

    } else {

        $reponse = "remplissage_error";

    }

    header('Location:../../views/home.php?link=' . sha1("logistique_livraison_liste_livraison_all") . '&use_date1=' . ($date1) . '&use_date2=' . ($date2) . '&use_service=' . ($idservice) . '&use_typerepas=' . ($typerepas) . '&use_biens=' . ($idbiens) . '&link_up=' . sha1("home_logistique_livraison"));

    die;

}



if (isset($_POST['bt_active'])) {

    $idbiens = securise($_POST['tb_idbiens']);

    $operation = securise($_POST['tb_operation']);

    if ($idbiens != "" && $operation != "") {

        $bdbiens = new BdBiens();

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

    header('Location:../../views/home.php?link=' . sha1("logistique_attribution_biens_fiche_attribution_fournisseur_all") . '&use=' . ($motcle) . '&link_up=' . sha1("home_logistique_attribution_biens"));

}



if (isset($_POST['bt_search_for_biens'])) {

    $reponse = "search_results";

    $motcle = $_POST['tb_search'];

    header('Location:../../views/home.php?link=' . sha1("logistique_livraison_fiche_biens_livraison_all") . '&use=' . ($motcle) . '&link_up=' . sha1("home_logistique_livraison"));

}



if (isset($_POST['bt_view'])) {

    $reponse = $_POST['tb_idattribution'];

    header('Location:../../views/home.php?link=' . sha1("logistique_attribution_biens_fiche_attribution_fournisseur_self") . '&use=' . ($reponse) . '&link_up=' . sha1("home_logistique_attribution_biens"));

}



if (isset($_POST['bt_view_for_biens'])) {

    $reponse = $_POST['tb_idbiens'];

    header('Location:../../views/home.php?link=' . sha1("logistique_livraison_fiche_biens_livraison_self") . '&use=' . ($reponse) . '&link_up=' . sha1("home_logistique_livraison"));

}



if (isset($_POST['bt_view_for_service'])) {

    $idservice = $_POST['tb_idservice'];

    header('Location:../../views/home.php?link=' . sha1("logistique_livraison_fiche_service_livraison_self") . '&use=' . ($idservice) . '&link_up=' . sha1("home_logistique_livraison"));

}



if (isset($_POST['bt_encours_self'])) {

    $idbiens = $_POST['tb_idbiens'];

    $reponse = "get_encours_self";

    header('Location:../../views/home.php?link=' . sha1("logistique_attribution_biens_fiche_biens_attribution_self") . '&reponse=' . sha1($reponse) . '&use=' . ($idbiens) . '&link_up=' . sha1("home_logistique_attribution_biens"));

}



if (isset($_POST['bt_encours_fournisseur_self'])) {

    $idfournisseur = $_POST['tb_idfournisseur'];

    $reponse = "get_encours_fournisseur_self";

    header('Location:../../views/home.php?link=' . sha1("logistique_attribution_biens_fiche_attribution_fournisseur_self") . '&reponse=' . sha1($reponse) . '&use=' . ($idfournisseur) . '&link_up=' . sha1("home_logistique_attribution_biens"));

}



if (isset($_POST['bt_enregistrer_panier'])) {

    $m = 0;

    $idlivraison = securise($_POST['cb_livraison']);

    $idpreparation = securise($_POST['tb_idpreparation']);

    $bdlivraison = new BdLivraison();

    $livraisons = $bdlivraison->getLivraisonById($idlivraison);

    foreach ($livraisons as $livraison) {

        $quantite_livree = $livraison['lQuantite'];

        $idbiens = $livraison['bId'];

    }

    $bdunite = new BdUnite();

    $unites = $bdunite->getUniteByIdBiens($idbiens);

    $panier = "";

    foreach ($unites as $unite) {

        if ((isset($_POST['chk_' . $unite['id']]))) {

            $panier = $panier . "/" . $_POST['chk_' . $unite['id']];

            $m++;

        }

    }

//    echo $quantite_livree;die;

    if ($idlivraison != "" && $panier != "" && ((1))) {

        foreach ($unites as $unite) {

            if ((isset($_POST['chk_' . $unite['id']]))) {

                if ($bdunite->desactiveUnite($_POST['chk_' . $unite['id']])) {

                    

                }

            }

        }

        if ($bdlivraison->setPanier($idlivraison, $panier)) {

            $reponse = "succes";

        } else {

            $reponse = "traitement_error";

        }

    } else {

        $reponse = "remplissage_error";

    }

    header('Location:../../views/home.php?link=' . sha1("logistique_livraison_add") . '&use_preparation=' . ($idpreparation) . '&reponse=' . sha1($reponse) . '&link_up=' . sha1("home_logistique_livraison"));

}



if (isset($_POST['bt_search_by_date_by_service'])) {

    $date1 = $_POST['tb_date1'];

    $date2 = $_POST['tb_date2'];

    $idservice = $_POST['cb_service'];

    $typerepas = $_POST['cb_typerepas'];

    $idbiens = $_POST['cb_biens'];

    header('Location:../../views/home.php?link=' . sha1("logistique_livraison_liste_livraison_all") . '&use_date1=' . ($date1) . '&use_date2=' . ($date2) . '&use_service=' . ($idservice) . '&use_typerepas=' . ($typerepas) . '&use_biens=' . ($idbiens) . '&link_up=' . sha1("home_logistique_livraison"));

}



if (isset($_POST['bt_select_preparation_for_add_livraison'])) {

    $idpreparation = $_POST['cb_preparation'];

    header('Location:../../views/home.php?link=' . sha1("logistique_livraison_add") . '&reponse=' . sha1($reponse) . '&use_preparation=' . ($idpreparation) . '&link_up=' . sha1("home_logistique_livraison"));

}

?>



