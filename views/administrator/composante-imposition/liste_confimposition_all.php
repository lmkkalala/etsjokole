<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/conf-imposition/ConfImposition.php';
include '../models/categorieM/Categorie.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-bandcamp" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span><span class="h3">Configuration composante contribution</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-list" style="color: darkslategray; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">List</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend><label class="control-label">Search by category :</label></legend>
                <form class="form-horizontal" method="POST" action="../contollers/conf-imposition/confImpositionController.php">
                <div class="form-group-lg">
                    <div class="input-group-lg">
                        
                        <select class="form-control select2" name="cb_categorie">
                            <option value="0">Choisir une categorie salariale</option>
                            <?php
                            $bdcategorie = new BdCategorieM();
                            $categories = $bdcategorie->getCategorieAllDesc();
                            foreach ($categories as $categorie) {
                                if ($categorie['active']) {
                                    if (1) {
                                        ?>
                                        <option value="<?= $categorie['id'] ?>"><?= $categorie['designation'] ?></option>
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
                            <input class="btn btn-success" type="submit" name="bt_search_by_categorie" value="Search">
                        </div>
                    </fieldset>
                </div>
            </form>
            </fieldset>
            <fieldset>
                <legend>Liste</legend>
                <table class="table table-bordered table-responsive-lg table-striped">
                    <thead>
                    <th>
                        #
                    </th>
                    <th>
                        Date configuration
                    </th>
                    <th>
                        Composante contribution patron
                    </th>
                    <th>
                        Catégorie salariale
                    </th>
                    <th>
                        Pourcentage (%)
                    </th>
                    <th>
                        State
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdconfimposition = new BdConfImposition();
                        if ((isset($_GET['use_categorie'])) && ($_GET['use_categorie']!="")) {
                            $confimpositions = $bdconfimposition->getConfImpositionByCategorie($_GET['use_categorie']);
                        } else {
                            $confimpositions = $bdconfimposition->getConfimpositionAllDesc();
                        }
                        
                        foreach ($confimpositions as $confimposition) {
                            if ($confimposition['active']) {

                                $n++;
                                ?>
                                <tr>
                                    <td><?= $confimposition['id'] ?></td>
                                    <td><?= $confimposition['dateConf'] ?></td>
                                    <td><?= $confimposition['designation'] . " / " . $confimposition['unite'] . " / " . $confimposition['type'] ?></td>
                                    <td><?= $confimposition['caDesignation'] ?></td>
                                    <td><?= $confimposition['pourcentage'] ?></td>
                                    <td>
                                        <?php
                                        if ($confimposition['active'] == 1) {
                                            ?>
                                            <h4 style="color: forestgreen;">Actif</h4>
                                            <?php
                                        } else {
                                            ?>
                                            <h4 style="color: red;">Inactif</h4>
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
                    <td style="font-size: 20px;">
                        <span>Number:</span><span><?= $n ?></span>
                    </td>
                    </tfoot>
                </table>
            </fieldset>
        </div>
    </div>
</div>

