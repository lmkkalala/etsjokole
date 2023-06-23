<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/biens/biens.php';
include '../models/preparation/preparation.php';
include '../models/demande/demande.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-cube" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-plus-square-o" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Requisition</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-asterisk" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Ajout</span>
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
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("succes_deleted")))) {
                ?>
                <div class="alert alert-warning">
                    <span class="glyphicon glyphicon-check" style="font-size: 15px;margin-right: 5px;"></span><span>Success deleted</span>
                </div>
                <?php
            }
            ?>
            <div style="background-color: whitesmoke; padding: 10px;">
                <form class="form-horizontal" method="POST" action="../contollers/demande/demandeController.php">
                    <div class="form-group-lg">
                        <div class="input-group-lg">
                            <label class="control-label">Activité :</label>
                            <select class="form-control select2" name="cb_preparation">
                                <option value="0">Choisir activité</option>
                                <?php
                                $bdpreparation = new BdPreparation();
                                if ($_SESSION['type'] == 'logistique') {
                                    $preparations = $bdpreparation->getPreparationAllDescActive();
                                }else{
                                    $preparations = $bdpreparation->getPreparationByAffectationService($_SESSION['idaffectation']);
                                }
                                
                                foreach ($preparations as $preparation) {
                                    if ($preparation['active']) {
                                        if (1) {
                                            ?>
                                            <option value="<?= $preparation['id'] ?>"><?= $preparation['typerepas'] . " / " . $preparation['dateHeure'] ?></option>
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
                                <input class="btn btn-success" type="submit" name="bt_select_preparation_for_add_demande" value="Séléctionner">
                            </div>
                        </fieldset>
                    </div>
                </form>
            </div>


            <?php
            if (isset($_GET['use_preparation'])) {
                ?>
                <div style="margin: 15px;">
                    <fieldset>
                        <legend style="margin: 5px; color: dodgerblue;">
                            <?php
                            if (isset($_GET['use_preparation'])) {
                                $bdpreparation = new BdPreparation();
                                $preparations = $bdpreparation->getPreparationById($_GET['use_preparation']);
                                foreach ($preparations as $preparation) {
                                    ?>
                                    <?= $preparation['typerepas'] . " / " . $preparation['dateHeure'] ?>
                                    <?php
                                }
                            }
                            ?>
                        </legend>
                    </fieldset>

                    <form class="form-horizontal" method="POST" action="../contollers/demande/demandeController.php">
                        <table class="table table-bordered table-hover table-responsive table-striped">
                            <tr>
                                <td>
                                    <div class="input-group-lg">
                                        <label id="selectProduct" class="control-label">Produit :</label>
                                        <select class="form-control select2" name="cb_biens">
                                            <option value="0">Choisir produit</option>
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
                                        <input class="form-control" type="date" name="tb_date">
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group-lg">
                                        <input class="form-control" type="text" name="tb_quantite" placeholder="Quantité">
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group-lg">
                                        <input type="hidden" name="tb_idpreparation" value="<?= $_GET['use_preparation'] ?>">
                                        <input type="hidden" name="tb_idaffectation" value="<?= $_SESSION['idaffectation'] ?>">
                                        <input class="btn btn-success" type="submit" name="bt_enregistrer" value="Ajouter">
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <?php
            }
            ?>
        </div>

    </div>

    <div style="margin: 10px;">
        <fieldset>
            <legend>Requisitions</legend>
            <table class="table table-bordered table-responsive-lg">
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
                    Quantité
                </th>
                <th>
                    Finalisée
                </th>
                </thead>
                <tbody>
                    <?php
                    $n = 0;
                    $bddemande = new BdDemande();
                    if (isset($_GET['use_preparation'])) {
                        $demandes = $bddemande->getDemandeByPreparation($_GET['use_preparation']);
                    } else {
                        $demandes = $bddemande->getDemandeByPreparation(0);
                    }

                    foreach ($demandes as $demande) {
                        if ($demande['mutation_id'] == $_SESSION['idaffectation']) {
                            $n++;
                            ?>
                            <tr>
                                <td><?= $demande['dId'] ?></td>
                                <td><?= $demande['date'] ?></td>
                                <td><?= $demande['bDesignation'] . " / " . $demande['gDesignation'] ?></td>
                                <td><?= $demande['dQuantite'] ?></td>
                                <td>
                                    <?php
                                    if ($demande['dEtat'] == 0) {
                                        ?>
                                        <h4 style="color: forestgreen;">Non</h4>
                                        <?php
                                    } else {
                                        ?>
                                        <h4 style="color: red;">Oui</h4>
                                        <?php
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($demande['dEtat'] == 0) {
                                        ?>
                                        <form class="form-horizontal" method="POST" action="../contollers/demande/demandeController.php">
                                            <input type="hidden" name="tb_iddemande" value="<?= $demande['dId'] ?>">
                                            <input type="hidden" name="tb_idpreparation" value="<?= $_GET['use_preparation'] ?>">
                                            <button class="btn btn-danger" type="submit" name="bt_delete_demande_service">Supprimer</button>
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
                <td style="font-size: 20px;">
                    <span>Nombre:</span><span><?= $n ?></span>
                </td>
                </tfoot>
            </table>
        </fieldset>
    </div>

</div>

