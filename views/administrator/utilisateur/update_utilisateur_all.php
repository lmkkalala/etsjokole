<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/affectation-service/affectationService.php';
include '../models/agent/agent.php';
include '../models/utilisateur/utilisateur.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-users" style="color: #0069d9; font-size: 30px;margin-right: 5px;"></span><span class="h3">Gestion des utilisateurs</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>

        <span class="fa fa-pencil-square-o" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Mise à jour</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Les utilisateurs enregistrés</legend>
                <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("succes")))) {
                    ?>
                    <div class="alert alert-success">
                        <span class="glyphicon glyphicon-ok" style="font-size: 15px;margin-right: 5px;"></span><span>Modification effectué avec succès</span>
                    </div>
                    <?php
                }
                ?>
                <?php
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("traitement_error")))) {
                    ?>
                    <div class="alert alert-danger">
                        <span class="glyphicon glyphicon-ban-circle" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur de traitment</span>
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
                if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("recentmotdepasse_error")))) {
                    ?>
                    <div class="alert alert-danger">
                        <span class="fa fa-compress" style="font-size: 15px;margin-right: 5px;"></span><span>Mots de passe non concordants, Recommencer SVP</span>
                    </div>
                    <?php
                }
                ?>
                <table class="table table-bordered table-striped table-responsive-lg">
                    <thead>
                    <th>
                        N°
                    </th>
                    <th>
                        Agent
                    </th>
                    <th>
                        Nom d'utilisateur
                    </th>
                    <th>
                        Ancien mot de passe
                    </th>
                    <th>
                        Nouveau mot de passe
                    </th>
                    <th>
                        Type
                    </th>
                    <th>
                        Opération
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
                        <form class="form-horizontal" method="POST" action="../contollers/utilisateur/utilisateurController.php">
                            <div class="form-group-lg">
                                <tr>
                                    <td><?= $utilisateur['id'] ?></td>
                                    <td>
                                        <div class="input-group-lg">
                                            <select class="form-control" name="cb_affectation">
                                                <?php
                                                $bdaffectation = new BdAffectationService();
                                                $affectations = $bdaffectation->getAffectationServiceAllDesc();
                                                foreach ($affectations as $affectation) {
                                                    if (1) {
                                                        if ($affectation['Id'] == $utilisateur['mutation_id']) {
                                                            ?>
                                                            <option value="<?= $affectation['Id'] ?>" selected><?= $affectation['nom'] . " " . $affectation['postnom'] . " " . $affectation['prenom'] . " / " . $affectation['designation'] ?></option>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <option value="<?= $affectation['Id'] ?>" ><?= $affectation['nom'] . " " . $affectation['postnom'] . " " . $affectation['prenom'] . " / " . $affectation['designation'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </td>
                                    <td><input class="form-control" type="text" name="tb_nomutilisateur" value="<?= $utilisateur['nomUtilisateur'] ?>"></td>
                                    <td><input class="form-control" type="text" name="tb_motdepasserecent"></td>
                                    <td><input class="form-control" type="text" name="tb_motdepassenew"></td>
                                    <td>
                                        <div class="input-group-lg">
                                            <select class="form-control" name="cb_type">
                                                <option value="logistique" 
                                                <?php
                                                if ($utilisateur['type'] == "logistique") {
                                                    echo 'selected';
                                                }
                                                ?>
                                                        >Logistique</option>
                                                <option value="other" 
                                                <?php
                                                if ($utilisateur['type'] == "other") {
                                                    echo 'selected';
                                                }
                                                ?>
                                                        >Chef de service</option>
                                                <option value="membre" 
                                                <?php
                                                if ($utilisateur['type'] == "membre") {
                                                    echo 'selected';
                                                }
                                                ?>
                                                        >Membre d'un service</option>
                                                <option value="administration" 
                                                <?php
                                                if ($utilisateur['type'] == "administration") {
                                                    echo 'selected';
                                                }
                                                ?>
                                                        >Administration de l'entreprise</option>
                                                <option value="admin" 
                                                <?php
                                                if ($utilisateur['type'] == "admin") {
                                                    echo 'selected';
                                                }
                                                ?>
                                                        >Administrateur du système</option>
                                                
                                                
                                            </select>
                                        </div>
                                    </td>
                                <input type = "hidden" name = "tb_idutilisateur" value ="<?= $utilisateur['id'] ?>">
                                <td><button type="submit" class="btn btn-primary" name="bt_modifier"><span class="glyphicon glyphicon-pencil" style="color: white; font-size: 20px;margin-right: 5px;"></span></button></td>                                    
                                </tr>
                            </div>
                        </form>
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

