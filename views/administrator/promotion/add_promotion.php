<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/employe/Employe.php';
include '../models/serviceM/Service.php';
include '../models/fonctionM/Fonction.php';
include '../models/categorieM/Categorie.php';
include '../models/type-contrat/TypeContrat.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-bandcamp" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span><span class="h3">Promotion</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-asterisk" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">New</span>
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
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == (sha1("doublons_error"))))) {
                ?>
                <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-refresh" style="font-size: 15px;margin-right: 5px;"></span><span>Erreur de doublons, Recommencer SVP</span>
                </div>
                <?php
            }
            ?>

            <form class="form-horizontal" method="POST" action="../contollers/promotion/promotionController.php">
                <div class="form-group-lg">
                    <div class="input-group-lg">
                        <label class="control-label">Date promotion :</label>
                        <input class="form-control" type="date" name="tb_dateaffectation">
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Employé concernée :</label>
                        <select class="form-control select2" name="cb_employe">
                            <option value="0">Choisir l'employé concernée</option>
                            <?php
                            $bdemploye = new BdEmploye();
                            $employes = $bdemploye->getEmployeAllDesc();
                            foreach ($employes as $employe) {
                                if ($employe['active']) {
                                    if (1) {
                                        ?>
                                        <option value="<?= $employe['eId'] ?>"><?= "Matricule: ".$employe['matricule']." / ".$employe['nom']." ".$employe['postnom']." ".$employe['prenom']." / Sexe: ".$employe['sexe'] ?></option>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Service :</label>
                        <select class="form-control select2" name="cb_service">
                            <option value="0">Choisir le service</option>
                            <?php
                            $bdservice = new BdService();
                            $services = $bdservice->getServiceAllDesc();
                            foreach ($services as $service) {
                                if ($service['active']) {
                                    if (1) {
                                        ?>
                                        <option value="<?= $service['id'] ?>"><?= $service['designation'] ?></option>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Fonction :</label>
                        <select class="form-control select2" name="cb_fonction">
                            <option value="0">Choisir la fonction</option>
                            <?php
                            $bdfonction = new BdFonction();
                            $fonctions = $bdfonction->getFonctionAllDesc();
                            foreach ($fonctions as $fonction) {
                                if ($fonction['active']) {
                                    if (1) {
                                        ?>
                                        <option value="<?= $fonction['id'] ?>"><?= $fonction['designation'] ?></option>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Catégorie salariale :</label>
                        <select class="form-control select2" name="cb_categorie">
                            <option value="0">Choisir la catégorie</option>
                            <?php
                            $bdcategorie = new BdCategorieM();
                            $categories = $bdcategorie->getCategorieAllDesc();
                            foreach ($categories as $categorie) {
                                if ($categorie['active']) {
                                    if (1) {
                                        ?>
                                        <option value="<?= $categorie['id'] ?>"><?= $categorie['designation'] ?></option>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-group-lg">
                        <label class="control-label">Type de contrat :</label>
                        <select class="form-control select2" name="cb_typecontrat">
                            <option value="0">Choisir le type de contrat</option>
                            <?php
                            $bdtypecontrat = new BdTypeContrat();
                            $typecontrats = $bdtypecontrat->getTypeContratAllDesc();
                            foreach ($typecontrats as $typecontrat) {
                                if ($typecontrat['active']) {
                                    if (1) {
                                        ?>
                                        <option value="<?= $typecontrat['id'] ?>"><?= $typecontrat['designation'] ?></option>
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
                            <input class="btn btn-success" type="submit" name="bt_enregistrer" value="Save">
                            <input class="btn btn-danger" type="reset" value="Reset">
                        </div>
                    </fieldset>
                </div>
            </form>
        </div>

    </div>
</div>

