<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/affectation-groupe/affectationGroupe.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-cube" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-plus-square-o" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Meal configuration</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-lock" style="color: orange; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Lock</span>
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

            <form class="form-horizontal" method="POST" action="../contollers/affectation-groupe/affectationGroupeController.php">
                <div class="form-group-lg">
                    <div class="input-group-lg">
                        <label class="control-label">Agent :</label>
                        <select class="form-control select2" name="cb_affectationgroupe">
                            <option value="0">Choose an agent</option>
                            <?php
                            $bdaffectationgroupe = new BdAffectationGroupe();
                            $affectationgroupes = $bdaffectationgroupe->getAffectationGroupeAllActive();
                            foreach ($affectationgroupes as $affectationgroupe) {
                                if ($affectationgroupe['etatBlockage'] == 0) {
                                    if (1) {
                                        ?>
                                        <option value="<?= $affectationgroupe['idAG'] ?>"><?= $affectationgroupe['nom'] . " " . $affectationgroupe['postnom'] . " " . $affectationgroupe['prenom'] . " / " . $affectationgroupe['dService'] . " / " . $affectationgroupe['dFonction'] . " / " . $affectationgroupe['nombrerepas'] . " Repas/jour" ?></option>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Auto unlock date</label>
                        <input class="form-control" name="tb_dateOuverture" type="date">
                    </div>
                    <div class="input-group-lg">
                        <br>
                        <input type="checkbox" name="chk_forevermore" class="checkbox-inline"> <label class="control-label">For evermore</label>
                        <br>
                    </div>
                    <fieldset>
                        <legend></legend>
                        <div class="input-group-lg">
                            <input class="btn btn-warning" type="submit" name="bt_blocker" value="Lock">
                            <input class="btn btn-danger" type="reset" value="Reset">
                        </div>
                    </fieldset>
                </div>
            </form>
        </div>

    </div>
</div>

