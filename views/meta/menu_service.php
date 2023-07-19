<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php
include 'meta/menu_general.php';
?>
<div class="row"  style="margin-top: 12%;">
    <div id="menu2-a" class="col-12">
        <ul class="nav nav-tabs nav-justified">
            <?php
            if (!empty($_SESSION['temp_admin_session'])) {
            ?>
                <li role="presentation"> <a class="btn btn-primary text-white shadow-none text-uppercase fw-bolder" style="font-size: 15px;" class="active" href="/contollers/transition/transition.php"><span><i class="fa fa-backward"></i> GESTIONNAIRE</span></a></li>
            <?php
            }

            if ($_SESSION['type'] != 'membre') {
                ?>
                <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 25px;" class="active" href="/views/home.php?link_up=<?= sha1('home_service_acceuil'); ?>"><span class="fa fa-home" style="color: #0069d9; "></span> Accueil</a></li>
                <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 15px;" href="/views/home.php?link_up=<?= sha1('home_service_requisition'); ?>"><span class="fa fa-upload" style="color: #0069d9; "></span> Demande</a></li>
                <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 15px;" href="/views/home.php?link_up=<?= sha1('home_service_reception'); ?>"><span class="fa fa-download" style="color: #0069d9; "></span> Entrée</a></li>
                <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 15px;" href="/views/home.php?link_up=<?= sha1('home_service_sale'); ?>"><span class="fa fa-dollar" style="color: #0069d9; "></span> Vente production</a></li>
                <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 15px;" href="/views/home.php?link_up=<?= sha1('home_service_distribution'); ?>"><span class="fa fa-dollar" style="color: #0069d9; "></span> Vente sur stock</a></li>
                <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 15px;" href="/views/home.php?link_up=<?= sha1('home_service_recuperation'); ?>"><span class="fa fa-undo" style="color: #0069d9; "></span> Annuler vente</a></li>
                <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 15px;" href="/views/home.php?link_up=<?= sha1('home_service_productionglobal'); ?>"><span class="fa fa-recycle" style="color: #0069d9; "></span> Production</a></li>
                <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 15px;" href="/views/home.php?link_up=<?= sha1('home_service_participation'); ?>"><span class="fa fa-cube" style="color: #0069d9; "></span> Consommation MP</a></li>
                <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 15px;" href="/views/home.php?link_up=<?= sha1('home_logistique_depense'); ?>"><span class="fa fa-dollar" style="color: #0069d9; "></span> DEPENSES</a></li>
                <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 15px;" href="/views/home.php?link_up=<?= sha1('home_logistique_dette'); ?>"><span class="fa fa-dollar" style="color: #0069d9;"></span> DETTES</a></li>
                <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 15px;" href="/views/home.php?link_up=<?= sha1('home_facture'); ?>"><span class="fa fa-pencil-square" style="color: #0069d9;"></span> Mes Factures</a></li>
                <?php
            } elseif ($_SESSION['type'] == 'membre') {
            ?>
                <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" href="/views/home.php?link_up=<?= sha1('home_service_swaping'); ?>"><span class="fa fa-download" style="color: #0069d9; font-size: 15px;"></span>Swaping</a></li>
            <?php
            }
            ?>

        </ul>
    </div>
</div>
<style>
    #menu2-a ul li a {
        color: #0069d9;
        font-size: 15px;
    }
</style>

