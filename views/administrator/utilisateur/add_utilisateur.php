<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/affectation-service/affectationService.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-users" style="color: #0069d9; font-size: 30px;margin-right: 5px;"></span><span class="h3">Gestion des utilisateurs</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-asterisk" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Nouveau utilisateur</span>
    </div>
    <div class="panel panel-body">
        <div>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == (sha1("succes"))))) {
                ?>
                <div class="alert alert-success">
                    <span class="glyphicon glyphicon-ok" style="font-size: 15px;margin-right: 5px;"></span><span>Enregistrement effectué avec succès</span>
                </div>
                <?php
            }
            ?>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == (sha1("traitement_error"))))) {
                ?>
                <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-ban-circle" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur d'enregistrement</span>
                </div>
                <?php
            }
            ?>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == (sha1("remplissage_error"))))) {
                ?>
                <div class="alert alert-warning">
                    <span class="glyphicon glyphicon-blackboard" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur de remplissage, Recommencer SVP</span>
                </div>
                <?php
            }
            ?>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == (sha1("motdepasse_error"))))) {
                ?>
                <div class="alert alert-danger">
                    <span class="fa fa-remove" style="font-size: 15px;margin-right: 5px;"></span><span>Mots de passe non concordants, Recommencer SVP</span>
                </div>
                <?php
            }
            ?>

            <form class="form-horizontal" method="POST" action="../contollers/utilisateur/utilisateurController.php">
                <div class="form-group-lg">
                    <div class="input-group-lg">
                        <label class="control-label">Agent :</label>
                        <select class="form-control" name="cb_affectation">
                            <option value="0">Choisir un agent</option>
                            <?php
                            $bdaffectation=new BdAffectationService();
                            $affectations=$bdaffectation->getAffectationServiceAllDesc();
                            foreach ($affectations as $affectation) {
                                if ($affectation['active']) {
                                    ?>
                                    <option value="<?= $affectation['Id'] ?>"><?= $affectation['nom'] . " " . $affectation['postnom'] . " " . $affectation['prenom'] . " / " . $affectation['designation'] ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Nom d'utilisateur :</label>
                        <input type="text" class="form-control" name="tb_nomutilisateur" placeholder="Nom d'utilisateur">
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Mot de passe :</label>
                        <input type="text" class="form-control" name="tb_motdepasse" placeholder="Mot de passe">
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Rétaper le mot de passe :</label>
                        <input type="text" class="form-control" name="tb_motdepasseagain" placeholder="Rétaper le mot de passe">
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Type d'utilisateur :</label>
                        <select class="form-control" name="cb_type">
                            <option value="0">Choisir le type d'utilisateur</option>
                            <option value="logistique">Logistique</option>
                            <option value="other">Chef de service</option>
                            <option value="membre">Membre d'un service</option>
                            <!-- <option value="personnel">HR Twangiza</option> -->
                            <option value="administration">Administration de l'entreprise</option>
                            <option value="admin">Administrateur du système</option>
                            <!-- <option value="hr_mb">HR MB</option> -->
                        </select>
                    </div>
                    <fieldset>
                        <legend></legend>
                        <div class="input-group-lg">
                            <button class="btn btn-success" type="submit" name="bt_enregistrer"><span class="fa fa-save" style="font-size: 15px;margin-right: 5px;"></span>Enregistrer</button>
                            <button class="btn btn-danger" type="reset" name="bt_reset"><span class="fa fa-refresh" style="font-size: 15px;margin-right: 5px;"></span>Initialiser</button>
                        </div>
                    </fieldset>
                </div>
            </form>
        </div>

    </div>
</div>

