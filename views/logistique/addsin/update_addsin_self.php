<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/addsin/AddsIn.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-usd" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-plus-square-o" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Cost adds-in</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-pencil" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Update</span>
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
            $bdAddsIn = new BdAddsIn();
            $addsins = $bdAddsIn->getAddsInById($_GET['use_addsin']);
            foreach ($addsins as $addsin) {
            ?>
                <form class="form-horizontal" method="POST" action="../contollers/addsin/addsinController.php">
                    <div class="form-group-lg">
                        <div class="input-group-lg">
                            <label class="control-label">Désignation :</label>
                            <input class="form-control" type="text" name="tb_designation" value="<?= $addsin['designation'] ?>">
                        </div>
                        <fieldset>
                            <legend></legend>
                            <div class="input-group-lg">
                                <input type="hidden" name="tb_idaddsin" value="<?= $_GET['use_addsin'] ?>">
                                <input class="btn btn-primary" type="submit" name="bt_modifier" value="Update">
                            </div>
                        </fieldset>
                    </div>
                </form>
            <?php
            }

            ?>

        </div>

    </div>
</div>