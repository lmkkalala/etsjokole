<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/affectation-service/affectationService.php';
include '../models/utilisateur/utilisateur.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-users" style="color: #0069d9; font-size: 30px;margin-right: 5px;"></span><span class="h3">Gestion des utilisateurs</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-list-ol" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Liste des utilisateurs</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Liste des utilisateurs</legend>
                <table class="table table-bordered table-striped table-responsive-lg">
                    <thead>
                    <th>
                        N°
                    </th>
                    <th>
                        Agent
                    </th>
                    <th>
                        Type
                    </th>
                    <th>
                        Etat
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdutilisateur = new BdUtilisateur();
                        $utilisateurs = $bdutilisateur->getUtilisateurAllDesc();
                        foreach ($utilisateurs as $utilisateur) {
                            $n++;
                            ?>
                            <tr>
                                <td><?= $utilisateur['id'] ?></td>
                                <td>
                                    <?php
                                    $bdaffectation = new BdAffectationService();
                                    $affectations = $bdaffectation->getAffectationServiceByIdSecond($utilisateur['mutation_id']);
                                    foreach ($affectations as $affectation) {
                                        ?>
                                        <?= $affectation['nom'] . " " . $affectation['postnom'] . " " . $affectation['prenom']." / ".$affectation['designation'] ?>
                                        <?php
                                    }
                                    ?>
                                </td>
                                <td><?= $utilisateur['type'] ?></td>
                                <td>
                                    <?php
                                    if ($utilisateur['active'] == 1) {
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
                        ?>
                    </tbody>
                    <tfoot>
                    <td style="font-size: 20px;">
                        <span>Nombre:</span><span><?= $n ?></span>
                    </td>
                    </tfoot>
                </table>
            </fieldset>
        </div>
    </div>
</div>

