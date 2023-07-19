<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/demande/demande.php';
include '../models/biens/biens.php';
include '../models/inventaire/inventaire.php';
include '../models/ravitaillement/ravitaillement.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-cube" style="color: darkorange; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-file-text-o" style="color: darkorange; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Gestion des inventaires</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-list-ol" style="color: darkgray; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Liste de tous les inventaires</span>
    </div>
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
    <div class="panel panel-body">
        <div>

            <fieldset>
                <legend>Search by date : </legend>
                <form class="form-inline" method="POST" action="../contollers/inventaire/inventaireController.php">
                    <div class="row form-group-lg">
                        <div class="col-4">
                        <input type="date" class="form-control" name="tb_date1" placeholder="First date">
                        </div>
                        <div class="col-4">
                        <input type="date" class="form-control" name="tb_date2" placeholder="Second date">
                        </div>
                        <div class="col-4">
                        <button type="submit" class="btn btn-success" name="bt_search_by_date"><span class="glyphicon glyphicon-search" style="color: white; font-size: 20px;margin-right: 5px;"></span> Rechercher</button>
                        </div>
                    </div>
                </form>
            </fieldset>
            <fieldset>
                <legend style="color: orange;">
                    <?php
                    if (isset($_GET['use_date1'])) {
                        echo "Starting date : " . $_GET['use_date1'] . " / Ending date : " . $_GET['use_date2'];
                    }
                    ?>
                </legend>
            </fieldset>
            <fieldset >
                <?php
                if ((isset($_GET['use_date1']))) {
                    ?>
                    <a style="font-size: 20px;" href='../views/logistique/inventaire/pdf_list_inventaire_all.php?use_date1=<?= $_GET['use_date1'] . '&use_date2=' . $_GET['use_date2'] ?>' class="btn btn-primary pull-left">Print in PDF</a>
                    <?php
                }
                ?>

            </fieldset>
            <br>
            <fieldset>
                <legend>Physic Inventory</legend>
                <table class="table table-bordered table-responsive-lg table-striped">
                    <thead>
                    <th>
                        N°
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        Biens/produit
                    </th>
                    <th>
                        Quantité virtuelle
                    </th>
                    <th>
                        Quantité physique
                    </th>
                    <th>
                        Ecart
                    </th>
                    <th>Valuer Ecart (USD)</th>
                    <th>
                        Réalisé par
                    </th>
                    <th>
                        Commentaire
                    </th>
                    <th>
                        Operation
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdinventaire = new BdInventaire();
                        if (((isset($_GET['use_date1'])) && (isset($_GET['use_date2']))) && (($_GET['use_date1'] != "") && ($_GET['use_date2'] != ""))) {
                            $inventaires = $bdinventaire->getInventaireBeetwen2Dates($_GET['use_date1'], $_GET['use_date2']);
                        } else {
                            $inventaires = $bdinventaire->getInventaireAllDesc();
                        }

                        $cumul_value_ecart = 0;
                        foreach ($inventaires as $inventaire) {
                            if (1) {
                                $n++;
                                ?>
                                <tr>
                                    <td><?= $n ?></td>
                                    <td><?= $inventaire['iDate'] ?></td>
                                    <td><?= $inventaire['bDesignation'] . " / " . $inventaire['gDesignation'] . " / Marque : " . $inventaire['marque'] ?></td>
                                    <td><?= $inventaire['quantite'] ?></td>
                                    <td><?= $inventaire['iQuantite'] ?></td>
                                    <?php
                                    $somme_prix_biens = 0;
                                    $s = 0;
                                    $bdravitaillement = new BdRavitaillement();
                                    $ravitaillements = $bdravitaillement->getRavitaillementByIdBiens($inventaire['bId']);
                                    foreach ($ravitaillements as $ravitaillement) {
                                        $s++;
                                        $somme_prix_biens = $somme_prix_biens + $ravitaillement['prix'];
                                    }

                                    $average_price = ($somme_prix_biens / $s);
                                    ?>
                                    <td>
                                        <?php
                                        if ($inventaire['iEcart'] < 0) {
                                            ?>
                                            <h4 style="color: red;"><?= $inventaire['iEcart'] ?> </h4>
                                            <?php
                                        } else {
                                            ?>
                                            <h4 style="color: forestgreen;"><?= $inventaire['iEcart'] ?> </h4>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td style="font-weight: bold;">
                                        <?php
                                        echo ($inventaire['iEcart'] * $average_price);
                                        if ($inventaire['validation'] == 0) {
                                            $cumul_value_ecart = $cumul_value_ecart + ($inventaire['iEcart'] * $average_price);
                                        }
                                        ?>
                                    </td>
                                    <td><?= $inventaire['nom'] . " " . $inventaire['postnom'] . " " . $inventaire['prenom'] ?></td>
                                    <td><?= $inventaire['commentaire'] ?></td>
                                    <td>
                                        <?php
                                        if ($inventaire['validation'] == 0) {
                                            ?>
                                            <form method="POST" action="../contollers/inventaire/inventaireController.php">
                                                <input type="hidden" name="tb_idbiens" value="<?= $inventaire['bId'] ?>">
                                                <input type="hidden" name="tb_idinventaire" value="<?= $inventaire['iId'] ?>">
                                                <input type="hidden" name="tb_quantite_reelle" value="<?= $inventaire['iQuantite'] ?>">
                                                <button type="submit" class="btn btn-primary" name="bt_valide_inventaire"><span class="fa fa-check" style="color: white; font-size: 15px;margin-right: 5px;"></span></button>
                                            </form>
                                            <?php
                                        } else {
                                            ?>
                                            <p style="font-weight: bold; color: forestgreen;">Equalized</p>
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
                    <td style="">
                        <span>Nombre:</span><span><?= $n ?></span>
                    </td>
                    <td style="font-weight: bold; color: orange;">
                        <p><?= "Total variance value : " . $cumul_value_ecart . " USD" ?></p>
                    </td>
                    </tfoot>
                </table>
            </fieldset>
        </div>
    </div>
</div>

