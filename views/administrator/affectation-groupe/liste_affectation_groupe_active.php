<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/affectation-groupe/affectationGroupe.php';
include '../models/fonction/fonction.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-cube" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-plus-square-o" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Meal configuration</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-list-ol" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-check-circle-o" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">List of active's configuration</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Search by department :</legend>
                <form class="form-inline" method="POST" action="../contollers/affectation-groupe/affectationGroupeController.php">
                    <div class="form-group-lg">
                        <select class="form-control select2" name="cb_fonction">
                            <option value="0">Choose a department</option>
                            <?php
                            $bdfonction = new BdFonction();
                            $fonctions = $bdfonction->getFonctionAll();
                            foreach ($fonctions as $fonction) {
                                if (1) {
                                    if (1) {
                                        ?>
                                        <option value="<?= $fonction['id'] ?>"><?= $fonction['designation'] ?></option>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                        <button type="submit" class="btn btn-success" name="bt_search_for_affectation_groupe_departement"><span class="glyphicon glyphicon-search" style="color: white; font-size: 30px;margin-right: 5px;"></span></button>
                    </div>
                </form>
            </fieldset>
            <fieldset>
                <legend>...</legend>
                <table class="table table-bordered table-responsive-lg">
                    <thead>
                    <th>
                        N°
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        Agent
                    </th>
                    <th>
                        Category
                    </th>
                    <th>
                        Restau
                    </th>
                    <th>
                        Department
                    </th>
                    <th>
                        Lock
                    </th>
                    <th>
                        Active
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdaffectationgroupe = new BdAffectationGroupe();
                        if ((isset($_GET['use_departement'])) && ($_GET['use_departement']!=0)) {
                            $affectationgroupes = $bdaffectationgroupe->getAffectationGroupeByIdFonction($_GET['use_departement']);
                        } else {
                            $affectationgroupes = $bdaffectationgroupe->getAffectationGroupeAllActive();
                        }
                        
                        foreach ($affectationgroupes as $affectationgroupe) {
//                            
                            if (($affectationgroupe['etatBlockage'] == 0) && ($affectationgroupe['active'] == 1)) {

                                $n++;
                                ?>
                                <tr>
                                    <td><?= $affectationgroupe['idAG'] ?></td>
                                    <td><?= $affectationgroupe['dateHeureAffectation'] ?></td>
                                    <td><?= $affectationgroupe['nom'] . " " . $affectationgroupe['postnom'] . " " . $affectationgroupe['prenom'] ?></td>
                                    <td><?= $affectationgroupe['dGroupeSwaping'] ?></td>
                                    <td><?= $affectationgroupe['dService'] ?></td>
                                    <td><?= $affectationgroupe['dFonction'] ?></td>
                                    <td>
                                        <?php
                                        if ($affectationgroupe['etatBlockage'] == 0) {
                                            ?>
                                            <h4 style="color: forestgreen;">No</h4>
                                            <?php
                                        } else {
                                            ?>
                                            <h4 style="color: red;">Yes</h4>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($affectationgroupe['active'] == 1) {
                                            ?>
                                            <h4 style="color: forestgreen;">On</h4>
                                            <?php
                                        } else {
                                            ?>
                                            <h4 style="color: red;">Off</h4>
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

