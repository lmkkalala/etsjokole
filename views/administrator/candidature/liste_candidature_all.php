<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/candidature/Candidature.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-bandcamp" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span><span class="h3">Candidature</span>
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
                        Date de soumission
                    </th>
                    <th>
                        Offre d'emploie
                    </th>
                    <th>
                        Candidat
                    </th>
                    <th>
                        Accepted
                    </th>
                    <th>
                        State
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdcandidature = new BdCandidature();
                        $candidatures = $bdcandidature->getCandidatureAllDesc();
                        foreach ($candidatures as $candidature) {
                            $n++;
                            ?>
                            <tr>
                                <td><?= $candidature['id'] ?></td>
                                <td><?= $candidature['dateSoumission'] ?></td>
                                <td><?= $candidature['numero']. " / ".$candidature['libelle']." / Date de lancement: ".$candidature['dateLancement']." / Date de cloture: ".$candidature['dateCloture'] ?></td>
                                <td><?= $candidature['nom']." ".$candidature['postnom']." ".$candidature['prenom']." / sexe : ".$candidature['sexe'] ?></td>
                                <td>
                                    <?php
                                    if ($candidature['etatAcceptation'] == 1) {
                                        ?>
                                        <h4 style="color: forestgreen;">Yes</h4>
                                        <?php
                                    } else {
                                        ?>
                                        <h4 style="color: red;">No</h4>
                                        <?php
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($candidature['active'] == 1) {
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

