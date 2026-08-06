<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/attribution-biens/attributionBiens.php';
include '../models/demande/demande.php';
include '../models/livraison/livraison.php';
include '../models/biens/biens.php';
include '../models/unite/unite.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-cubes" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-share-alt" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Livraison</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-shopping-cart" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Le panier de la livraison</span>
    </div>
    <div class="panel panel-body">
        <div>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("succes")))) {
                ?>
                <div class="alert alert-success">
                    <span class="glyphicon glyphicon-ok" style="font-size: 15px;margin-right: 5px;"></span><span>Enregistrement effectué avec succès</span>
                </div>
                <?php
            }
            ?>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("traitement_error")))) {
                ?>
                <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-ban-circle" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur d'enregistrement</span>
                </div>
                <?php
            }
            ?>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("remplissage_error")))) {
                ?>
                <div class="alert alert-warning">
                    <span class="glyphicon glyphicon-blackboard" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur de remplissage, Recommencer SVP</span>
                </div>
                <?php
            }
            ?>
            <form class="form-horizontal" method="POST" action="../contollers/livraison/livraisonController.php">
                <fieldset>
                    <div class="form-group-lg">
                        <div class="input-group-lg">
                            <?php
                            
                            ?>
                            <label class="control-label">Choisir la livraison à utiliser :</label>
                            <select class="form-control" name="cb_livraison">

                                <?php
                                $idbiens = 0;
                                $quantite_choosen_livraison = 0;
                                $bdlivraison = new BdLivraison();
                                $livraisons = $bdlivraison->getLivraisonMaxSecond();
                                foreach ($livraisons as $livraison) {
                                    $idlivraison_considere = $livraison['lId'];
                                }
                                
                                $idbiens = $idbiens;
                                $livraisons = $bdlivraison->getLivraisonById($idlivraison_considere);
                                foreach ($livraisons as $livraison) {
                                    $livraison_etat = $livraison['lEtat'];
                                    $idbiens = $livraison['bId'];
                                    if (($livraison['panier'] == "")) {
                                        if (1) {
                                            ?>
                                            <option value="<?= $livraison['lId'] ?>"><?= $livraison['lDate'] . " " . $livraison['bDesignation'] . " : " . $livraison['marque'] . " / " . $livraison['gDesignation'] . " / quantité initiale : " . $livraison['lQuantite'] ?></option>
                                            <?php
                                            $quantite_choosen_livraison = $livraison['lQuantite'];
                                        }
                                    } else {
                                        ?>
                                        <option value="0">Aucune livraison en attente</option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </fieldset>
                <br>
                <fieldset>
                    <legend></legend>
                    <div class="input-group-lg">
                        <input type="hidden" name="tb_idpreparation" value="<?= $_GET['use_preparation'] ?>">
                        <input class="btn btn-success" type="submit" name="bt_enregistrer_panier" value="Valider">
                    </div>
                </fieldset>
                <hr>
                <fieldset>
                    <legend>Sélectionner les unités</legend>
                    <?php
                    include 'liste_unite_by_idbiens.php';
                    ?>
                </fieldset>
                
            </form>
        </div>
    </div>
</div>

