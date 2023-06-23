<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/candidat/Candidat.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-bandcamp" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span><span class="h3">Candidat</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-list" style="color: darkslategray; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">List</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Liste</legend>
                <table class="table table-bordered table-responsive-lg">
                    <thead>
                    <th>
                        #
                    </th>
                    <th>
                        Nom
                    </th>
                    <th>
                        Postnom
                    </th>
                    <th>
                        Prenom
                    </th>
                    <th>
                        Sexe
                    </th>
                    <th>
                        Nationalité
                    </th>
                    <th>
                        Adresse
                    </th>
                    <th>
                        Date de naissance
                    </th>
                    <th>
                        Lieu de naissance
                    </th>
                    <th>
                        Telephone
                    </th>
                    <th>
                        Email
                    </th>
                    <th>
                        State
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdCandidat = new BdCandidat();
                        $candidats = $bdCandidat->getCandidatAllDesc();
                        foreach ($candidats as $candidat) {
                            $n++;
                            ?>
                            <tr>
                                <td><?= $candidat['id'] ?></td>
                                <td><?= $candidat['nom'] ?></td>
                                <td><?= $candidat['postnom'] ?></td>
                                <td><?= $candidat['prenom'] ?></td>
                                <td><?= $candidat['sexe'] ?></td>
                                <td><?= $candidat['nationalite'] ?></td>
                                <td><?= $candidat['adresse'] ?></td>
                                <td><?= $candidat['dateNaissance'] ?></td>
                                <td><?= $candidat['lieuNaissance'] ?></td>
                                <td><?= $candidat['telephone'] ?></td>
                                <td><?= $candidat['email'] ?></td>
                                <td>
                                    <?php
                                    if ($candidat['active'] == 1) {
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
                        <span>Number:</span><span><?= $n ?></span>
                    </td>
                    </tfoot>
                </table>
            </fieldset>
        </div>
    </div>
</div>

