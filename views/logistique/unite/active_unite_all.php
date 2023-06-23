<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/unite/unite.php';
include '../models/biens/biens.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-archive" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">les unités</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-lock" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Activation / Désactivation</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Taper le code de la recherche :</legend>
                <form class="form-inline" method="POST" action="../contollers/unite/uniteController.php">
                    <div class="form-group-lg">
                        <button type="submit" class="btn btn-success" name="bt_search_for_unite"><span class="glyphicon glyphicon-search" style="color: white; font-size: 30px;margin-right: 5px;"></span></button>
                        <input type="text" class="form-control" name="tb_search" placeholder="Mot-clé">                            
                    </div>
                </form>
            </fieldset>
            <fieldset>
                <legend>Liste des unités</legend>
                <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("succes")))) {
                    ?>
                    <div class="alert alert-success">
                        <span class="glyphicon glyphicon-ok" style="font-size: 15px;margin-right: 5px;"></span><span>Opération effectuée avec succès</span>
                    </div>
                    <?php
                }
                ?>
                <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("traitement_error") ))) {
                    ?>
                    <div class="alert alert-danger">
                        <span class="glyphicon glyphicon-ban-circle" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur d'activation</span>
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
                <table class="table table-bordered table-responsive-lg">
                    <thead>
                    <th>
                        N°
                    </th>
                    <th>
                        Code
                    </th>
                    <th>
                        Biens
                    </th>
                    <th>
                        Date achat
                    </th>
                    <th>
                        Date expiration
                    </th>
                    <th>
                        Etat
                    </th>
                    <th>
                        Opération
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $bdunite = new BdUnite();
                        if (isset($_GET['use'])) {
                            $unites = $bdunite->getUniteByName($_GET['use']);
                        } else {
                            $unites = $bdunite->getUniteAllDesc();
                        }
                        foreach ($unites as $unite) {
                            $n++;
                            $bdbiens = new BdBiens();
                            $biens = $bdbiens->getBiensById($unite['biens_id']);
                            foreach ($biens as $bien) {
                                $info_biens = $bien['bDesignation'] . " / " . $bien['gDesignation']. " / Marque : " . $bien['marque'];
                            }
                            ?>
                            <tr> 
                                <td><?= $unite['id'] ?></td>
                                <td><?= $unite['code'] ?></td>
                                <td><?= $info_biens ?></td>
                                <td><?= $unite['date_achat'] ?></td>
                                <td><?= $unite['date_expiration'] ?></td>
                                <td>
                                    <?php
                                    if ($unite['active_principal'] == 1) {
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
                                <td>
                                    <?php
                                    if ($unite['active_principal'] == 1) {
                                        ?>
                                        <form method="post" action="../contollers/unite/uniteController.php">
                                            <input type="hidden" name="tb_idunite" value="<?= $unite['id'] ?>">
                                            <input type="hidden" name="tb_operation" value="desactive">
                                            <button type="submit" name="bt_active" class="btn btn-danger"><span class="glyphicon glyphicon-lock" style="color: white; font-size: 15px;margin-right: 5px;"></span></button>
                                        </form>
                                        <?php
                                    } else {
                                        ?>
                                        <form method="post" action="../contollers/unite/uniteController.php">
                                            <input type="hidden" name="tb_idunite" value="<?= $unite['id'] ?>">
                                            <input type="hidden" name="tb_operation" value="active">
                                            <button type="submit" name="bt_active" class="btn btn-success"><span class="glyphicon glyphicon-check" style="color: white; font-size: 15px;margin-right: 5px;"></span></button>
                                        </form>
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

