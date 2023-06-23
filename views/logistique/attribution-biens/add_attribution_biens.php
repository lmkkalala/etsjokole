<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/categorie/categorie.php';
include '../models/fournisseur/fournisseur.php';
include '../models/biens/biens.php';
include '../models/attribution-biens/attributionBiens.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-list-alt" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-gift" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Commande</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-asterisk" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Ajout</span><a style="font-size: 20px;" href='../views/home.php?link=<?= sha1("logistique_attribution_biens_add") . '&link_up=' . sha1("home_logistique_attribution_biens") ?>' class="btn btn-info pull-right"><span class="fa fa-refresh"></span></a>
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
            <fieldset>
                <a style="font-size: 20px;" href='../views/home.php?link=<?= sha1("logistique_biens_add") . '&link_up=' . sha1("home_logistique_biens") ?>' class="btn btn-danger pull-right">New item</a>
                <a style="font-size: 20px;" href='../views/home.php?link=<?= sha1("logistique_fournisseur_add") . '&link_up=' . sha1("home_logistique_fournisseur") ?>' class="btn btn-warning pull-left">New supplier</a>
            </fieldset>
            <br>
            <div style="background-color: whitesmoke; padding: 10px;">
                <form class="form-horizontal" method="POST" action="../contollers/attribution-biens/attributionBiensController.php">
                    <div class="form-group-lg">
                        <div class="input-group-lg">
                            <label class="control-label">Fournisseur :</label>
                            <select class="form-control select2" name="cb_fournisseur">
                                <option value="0">Choisir un fournisseur</option>
                                <?php
                                $bdfournisseur = new BdFournisseur();
                                $fournisseurs = $bdfournisseur->getFournisseurAllDesc();
                                foreach ($fournisseurs as $fournisseur) {
                                    if ($fournisseur['active']) {
                                        if (1) {
                                            ?>
                                            <option value="<?= $fournisseur['id'] ?>"><?= $fournisseur['designation'] ?></option>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>                    
                        <fieldset>
                            <legend></legend>
                            <div class="input-group-lg">
                                <input class="btn btn-success" type="submit" name="bt_select_fournisseur_for_add_attribution_biens" value="Select">
                            </div>
                        </fieldset>
                    </div>
                </form>
            </div>

            <div style="margin: 10px;">
                <fieldset>
                    <legend style="margin: 5px; color: dodgerblue;">
                        <?php
                        if (isset($_GET['use_fournisseur'])) {
                            $bdfournisseur = new BdFournisseur();
                            $fournisseurs = $bdfournisseur->getFournisseurById($_GET['use_fournisseur']);
                            foreach ($fournisseurs as $fournisseur) {
                                ?>
                                <?= $fournisseur['designation'] ?>
                                <?php
                            }
                        }
                        ?>
                    </legend>
                    <div style="color: red;">
                        
                        <?php
                        
                        $recentNumeroOrder="";
                        $bdattributionbiens = new BdAttributionBiens();
                        $attributions = $bdattributionbiens->getMaxAttributionBiensDistinctNumeroOrder();
                        foreach ($attributions as $attribution) {
                             $recentNumeroOrder = $attribution['numero_orderMax'];
                        }
                        
                        // $attributions = $bdattributionbiens->getMaxDateAttributionBiensDistinctNumeroOrder();
                        
                        // $maxIdOrder=0;
                        // foreach ($attributions as $attribution) {
                            
                            // echo $attribution['lastDate'];
                            
                             // $recentNumeroOrder=explode("/",$attribution['numero_orderFetchDate'])[0];
                             
                             // echo $recentNumeroOrder;
                             // echo "\n";
                             
                             // if ($recentNumeroOrder>=$maxIdOrder) {
                                 // $maxIdOrder=$recentNumeroOrder;
                             // }
                             
                        // }
                        
                        // $maxRecentNumeroOrder=$maxIdOrder;
                        
                        // echo $maxRecentNumeroOrder;
                        
                        /* $_GET['use_numeroOrder'] */
                        ?>
                        <p><?= "Numero recent: ".$recentNumeroOrder ?></p>
                        <label class="control-label">Numero Commande</label>
                        <?php
                            if (isset($_GET['use_numeroOrder'])) {
                        ?>
                            <input type="text" name="tb_numero_order_up" class="form-control-sm" id="numero_order_up" placeholder="Numero" value="<?= ($_GET['use_numeroOrder']) ?>">
                        <?php
                            } else {
                        ?>
                            <input type="text" name="tb_numero_order_up" class="form-control-sm" id="numero_order_up" placeholder="Muméro" value="<?=$recentNumeroOrder+1?>">
                        <?php
                        }
                        ?>
                        

                    </div>

                </fieldset>
            </div>

            <div>
                <form class="form-horizontal" method="POST" action="../contollers/attribution-biens/attributionBiensController.php">
                    <table class="table table-bordered table-hover table-responsive">
                        <tr>
                            <td>
                                <div class="input-group-lg">
                                    <label id="selectProduct" class="control-label">Bien/produit :</label>
                                    <select class="form-control select2" name="cb_biens">
                                        <option value="0">Choisir un biens/produit</option>
                                        <?php
                                        $bdbiens = new BdBiens();
                                        $biens = $bdbiens->getBiensAllDesc();
                                        foreach ($biens as $bien) {
                                            if ($bien['active']) {
                                                if ($bien['bId'] == isset($_GET['use'])) {
                                                    ?>
                                                    <option value="<?= $bien['bId'] ?>" selected><?= $bien['bDesignation'] . " : " . $bien['marque'] . " / " . $bien['gDesignation'] ?></option>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <option value="<?= $bien['bId'] ?>"><?= $bien['bDesignation'] . " : " . $bien['marque'] . " / " . $bien['gDesignation'] ?></option>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="input-group-lg">
                                    <?php
                                    if (isset($_GET['use_dateRecent'])) {
                                        ?>
                                        <input class="form-control" type="date" name="tb_date" value="<?= $_GET['use_dateRecent'] ?>">
                                        <?php
                                    } else {
                                        ?>
                                        <input class="form-control" type="date" name="tb_date">
                                        <?php
                                    }
                                    ?>

                                </div>
                            </td>
                            <td>
                                <div class="input-group-lg">
                                    <input class="form-control" type="text" name="tb_quantite" placeholder="Quantité">
                                </div>
                            </td>
                            <td>
                                <div class="input-group-lg">
                                    <input class="form-control" type="text" name="tb_prixorder" placeholder="PU commande">
                                </div>
                            </td>
                            <td>
                                <div class="input-group-lg">
                                    <?php
                                    if (isset($_GET['use_numeroOrder'])) {
                                        ?>
                                        <input type="hidden" name="tb_numero_order_down" class="form-control-sm" id="numero_order_down" value="<?= $_GET['use_numeroOrder'] ?>">
                                        <?php
                                    } else {
                                        ?>
                                        <input type="hidden" name="tb_numero_order_down" class="form-control-sm" id="numero_order_down" value="<?=$recentNumeroOrder+1?>">
                                        <?php
                                    }

                                    $fournisseurId=0;
                                    if (isset($_GET['use_fournisseur'])) {
                                        $fournisseurId=$_GET['use_fournisseur'];
                                    }

                                    ?>

                                    <input type="hidden" name="tb_idfournisseur" value="<?= $fournisseurId ?>">
                                    <input class="btn btn-success" type="submit" name="bt_enregistrer" value="Ajouter">
                                </div>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>

        <div style="margin: 10px;">
            <fieldset>
                <legend>Les commandes</legend>
                <table class="table table-bordered table-responsive-lg table-striped">
                    <thead>
                    <th>
                        #
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        Produit
                    </th>
                    <th>
                        PU actuel (USD)
                    </th>
                    <th>
                        Quantité
                    </th>
                    <th>
                        PU Commande (USD)
                    </th>
                    <th>
                        Valeur (USD)
                    </th>
                    <th>
                        Etat
                    </th>
                    <th>
                        Plus
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdattributionbiens = new BdAttributionBiens();
                        if (isset($_GET['use_fournisseur'])) {
                            $attributions = $bdattributionbiens->getAttributionBiensByIdFournisseurEncours($_GET['use_fournisseur']);
                        } else {
                            $attributions = $bdattributionbiens->getAttributionBiensByIdFournisseur(0);
                        }
                        $cumul_value = 0;
                        foreach ($attributions as $attribution) {
                            if (1) {
                                $n++;
                                ?>
                                <tr>
                                    <td><?= $attribution['aId'] ?></td>
                                    <td><?= $attribution['date'] ?></td>
                                    <td>
                                        <?php
                                        echo $attribution['bDesignation'] . " / " . $attribution['gDesignation'];
                                        $prix_unitaire_biens = $attribution['aPrixUnitaire'];
                                        ?>
                                    </td>
                                    <td style="font-weight: bold;"><?= $attribution['prixunitaire'] ?></td>
                                    <td style="font-weight: bold;"><?= $attribution['quantite_minimale'] ?></td>
                                    <td style="font-weight: bold;"><?= $prix_unitaire_biens ?></td>

                                    <td style="color: orange; font-weight: bold;">
                                        <?php
                                        echo ($attribution['quantite_minimale'] * $prix_unitaire_biens);
                                        $cumul_value = $cumul_value + ($attribution['quantite_minimale'] * $prix_unitaire_biens);
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($attribution['etat'] == 0) {
                                            ?>
                                            <h4 style="color: forestgreen;">Encours</h4>
                                            <?php
                                        } else {
                                            ?>
                                            <h4 style="color: red;">Finalisée</h4>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($attribution['etat'] == 0) {
                                            ?>
                                            <form class="form-horizontal" method="POST" action="../contollers/attribution-biens/attributionBiensController.php">
                                                <input type="hidden" name="tb_idattributionbiens" value="<?= $attribution['aId'] ?>">
                                                <input type="hidden" name="tb_idfournisseur" value="<?= $_GET['use_fournisseur'] ?>">
                                                <button class="btn btn-danger" type="submit" name="bt_delete_attribution_biens">Delete</button>
                                            </form>
                                            <?php
                                        }
                                        ?>

                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                    <td style="font-weight: bold;">
                        <span>Number : </span><span><?= $n ?></span>
                    </td>
                    <td style="font-weight: bold; color: orange;">
                        <span>Total value : </span><span><?= $cumul_value ?> USD </span>
                    </td>
                    </tfoot>
                </table>
            </fieldset>
        </div>
    </div>
</div>

