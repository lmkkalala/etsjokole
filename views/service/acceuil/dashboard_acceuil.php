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
        <span class="fa fa-keyboard-o" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span><span class="h3">Recherche par mot-clé</span>
        <span class="pull-right" style="color: red; font-size: 30px;margin-right: 0px;">*</span>
        <span class="fa fa-bell-o pull-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-comments-o pull-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-envelope-o pull-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
    </div>
    <div class="panel panel-body">
        <div class="panel panel-body">
            <fieldset>
                <legend>Commandez un bien/produit : </legend>
                <form class="form-horizontal" method="POST" action="../contollers/acceuil-service/acceuilServiceController.php">
                    <div class="form-group-lg">
                        <div class="input-group-lg">
                            <input style="text-align: center;" class="form-control" type="text" name="tb_search">
                            <button type="submit" class="btn btn-primary text-white center-block" name="bt_search" style="color: white;font-size: 20px;margin-top: 10px;"><span class="fa fa-search"></span> Rechercher</button>
                        </div>
                    </div>
                </form>
            </fieldset>
            <?php
            if (isset($_GET['use'])) {
                include 'liste_biens_by_name.php';
            }
            ?>
        </div>
        <div>

        </div>
    </div>
</div>

