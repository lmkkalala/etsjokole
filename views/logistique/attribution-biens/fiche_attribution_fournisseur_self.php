<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/attribution-biens/attributionBiens.php';
include '../models/fournisseur/fournisseur.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-list-alt" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-gift" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Order</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-book" style="color: darkslategray; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Order per supplier</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Le fournisseur</legend>
                <?php
                $bdfournisseur = new BdFournisseur();
                $fournisseurs = $bdfournisseur->getFournisseurById($_GET['use']);
                foreach ($fournisseurs as $fournisseur) {
                    ?>
                    <table class="table table-bordered table-responsive-lg table-striped">
                        <tr>
                            <td><b>N°</b></td>
                            <td><?= $fournisseur['id'] ?></td>
                        </tr>
                        <tr>
                            <td><b>Désignation</b></td>
                            <td style="color: #0069d9;"><b><?= $fournisseur['designation'] ?></b></td>
                        </tr>
                        <tr>
                            <td><b>Domaine</b></td>
                            <td><?= $fournisseur['domaine'] ?></td>
                        </tr>
                    </table>
                    <?php
                }
                ?>
            </fieldset>
            <fieldset>
                <legend>Choose interval :</legend>
                <form class="form-inline" method="POST" action="../contollers/attribution-biens/attributionBiensController.php">
                    <div class="form-group-lg">
                        <input type="date" class="form-control" name="tb_date1" placeholder="First date">
                        <input type="date" class="form-control" name="tb_date2" placeholder="Second date">
                        <select class="form-control select2" name="cb_numeroOrder">
                            <option value="none">Choose order number</option>
                            <?php
                            $bdattributionbiens = new BdAttributionBiens();
                            $attributions = $bdattributionbiens->getAttributionBiensByIdFournisseurDistinctNumeroOrder($_GET['use']);
                            foreach ($attributions as $attribution) {
                                ?>
                                <option value="<?= $attribution['numero_order'] ?>"><?= $attribution['numero_order'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <input type="hidden" name="tb_idfournisseur" value="<?= $_GET['use'] ?>">
                        <button type="submit" class="btn btn-success" name="bt_search_attributionbiens_by_date"><span class="glyphicon glyphicon-search" style="color: white; font-size: 30px;margin-right: 5px;"></span></button>
                    </div>
                </form>
            </fieldset>
            <fieldset>
                <legend style="color: #c9302c; font-size: 20px;">
                    <?php
                    if ((isset($_GET['use_date1'])) && (isset($_GET['use_date2']))) {
                        ?>
                        <?= "Date 1 : " . $_GET['use_date1'] . " " . " / Date 2 :" . $_GET['use_date2'] ?>
                        <?php
                        if (isset($_GET['use_numeroOrder'])) {
                            ?>
                            <p style="color: orange;"><?= "Order number : ".$_GET['use_numeroOrder'] ?></p>
                            <?php
                        }
                    } else {
                        ?>
                        <p style="color: orange;">Choose interval</p>
                        <?php
                    }
                    ?>
                </legend>
            </fieldset>
            <br>
            <fieldset >
                <?php
                if ((isset($_GET['use_date1']))) {
                    ?>
                    <a style="font-size: 20px;" href='../views/logistique/attribution-biens/pdf_list_attributionbiens_by_fournisseur_by_date.php?use_date1=<?= $_GET['use_date1'] . '&use_date2=' . $_GET['use_date2'] . '&use_numeroOrder=' . $_GET['use_numeroOrder'] . '&use=' . $_GET['use'] ?>' class="btn btn-primary pull-left">Print in PDF</a>
                    <?php
                }
                ?>
            </fieldset>
            <br>
            <fieldset>
                <legend>Order for selected supplier</legend>
                <form method="post" action="../contollers/attribution-biens/attributionBiensController.php">
                    <input type="hidden" name="tb_idfournisseur" value="<?= $_GET['use'] ?>">
                    <button class="btn btn-info pull-right" style="margin-bottom: 10px;" type="submit" name="bt_encours_fournisseur_self">Voir les commandes encours</button>
                </form>
                <?php
                if ((isset($_GET['reponse'])) && ($_GET['reponse'] == sha1("get_encours_fournisseur_self"))) {
                    ?>
                    <h3>Les commandes encours</h3>
                    <?php
                    include 'liste_attribution_biens_by_idfournisseur_encours.php';
                } else {
                    include 'liste_attribution_biens_by_idfournisseur.php';
                }
                ?>
            </fieldset>
        </div>
    </div>
</div>

