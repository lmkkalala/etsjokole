<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/biens/biens.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-usd" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-plus-square-o" style="color: darkcyan; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Currency in CDF</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="glyphicon glyphicon-asterisk" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">New</span>
    </div>
    <div class="panel panel-body">
        <div class="row">
            <?php
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("succes")))) {
            ?>
                <div class="alert alert-success">
                    <span class="glyphicon glyphicon-ok" style="font-size: 15px;margin-right: 5px;"></span><span>Success</span>
                </div>
            <?php
            }
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("traitement_error")))) {
                ?>
                <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-ban-circle" style="font-size: 15px;margin-right: 5px;"></span><span>Error</span>
                </div>
            <?php
            }
            if ((isset($_GET['reponse']) && ($_GET['reponse'] == sha1("remplissage_error")))) {
                ?>
                <div class="alert alert-warning">
                    <span class="glyphicon glyphicon-blackboard" style="font-size: 15px;margin-right: 5px;"></span><span>Data error</span>
                </div>
            <?php
            }
            ?>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal" method="POST" action="../contollers/taux/tauxController.php">
                    <div class="form-group-lg">
                        <div class="input-group-lg">
                            <label class="control-label">Date :</label>
                            <input class="form-control" type="date" name="tb_date">
                        </div>
                        <div class="input-group-lg">
                            <label class="control-label">Value in CDF:</label>
                            <input class="form-control" type="number" name="tb_value" placeholder="Value in CDF">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <input class="btn btn-success w-100" type="submit" name="bt_enregistrer" value="Save">
                            </div>
                            <div class="col-md-6">
                                <input class="btn btn-danger w-100" type="reset" value="Cancel">
                            </div>
                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

