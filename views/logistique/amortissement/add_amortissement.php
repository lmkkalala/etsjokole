<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// include '../models/ravitaillement/ravitaillement.php';

include '../models/ravitaillement/ravitaillement.php';
include '../models/attribution-biens/attributionBiens.php';
include '../models/unite/unite.php';
include '../models/biens/biens.php';
include '../models/fournisseur/fournisseur.php';
include '../models/amortissement/Amortissement.php';

?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-usd" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-plus-square-o" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Configuration Amortissement</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-asterisk" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">New</span>
    </div>
    <div class="panel panel-body">
        <div>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("succes")))) {
            ?>
                <div class="alert alert-success">
                    <span class="glyphicon glyphicon-ok" style="font-size: 15px;margin-right: 5px;"></span><span>Success</span>
                </div>
            <?php
            }
            ?>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("traitement_error")))) {
            ?>
                <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-ban-circle" style="font-size: 15px;margin-right: 5px;"></span><span>Error</span>
                </div>
            <?php
            }
            ?>
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("remplissage_error")))) {
            ?>
                <div class="alert alert-warning">
                    <span class="glyphicon glyphicon-blackboard" style="font-size: 15px;margin-right: 5px;"></span><span>Data error</span>
                </div>
            <?php
            }
            ?>
            <?php
            $c = 0;

            include 'liste_unite_hot.php';

            include 'liste_amortissement_hot.php';

            if ($c < 1) {
                include 'addForm.php';
            }

            ?>
        </div>

    </div>
</div>