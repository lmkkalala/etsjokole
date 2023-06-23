<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/compte/Compte.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-bandcamp" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span><span class="h3">Compte / Caisse</span>
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
                        Etablissement 
                    </th>
                    <th>
                        Numero
                    </th>
                    <th>
                        Devise
                    </th>
                    <th>
                        Date création
                    </th>
                    <th>
                        Proprietaire
                    </th>
                    <th>
                        State
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdcompte = new BdCompte();
                        $comptes = $bdcompte->getCompteAllDesc();
                        foreach ($comptes as $compte) {
                            $n++;
                            ?>
                            <tr>
                                <td><?= $compte['coId'] ?></td>
                                <td><?= $compte['etablissement'] ?></td>
                                <td><?= $compte['coNumero'] ?></td>
                                <td><?= $compte['devise'] ?></td>
                                <td><?= $compte['dateCreation'] ?></td>
                                <td><?= "Matricule : ".$compte['matricule']." / ".$compte['nom']." ".$compte['postnom']." ".$compte['prenom']." / sexe : ".$compte['sexe'] ?></td>
                                <td>
                                    <?php
                                    if ($compte['coActive'] == 1) {
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

