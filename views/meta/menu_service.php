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
<div class="row">
    <div id="menu2-a" class="col-12">
        <ul class="nav nav-tabs nav-justified">
            <?php
            if (!empty($_SESSION['temp_admin_session'])) {
            ?>
                <li role="presentation"> <a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 15px; color: #000e1f;" class="active" href="/contollers/transition/transition.php"><span><i class="fa fa-backward"></i> GESTION</span></a></li>
            <?php
            }

            if ($_SESSION['type'] != 'membre') {
                ?>
                <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 15px; color: #000e1f;" class="active" href="/views/home.php?link_up=<?= sha1('home_service_acceuil'); ?>"><span class="fa fa-home"></span> Accueil</a></li>
                <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 15px; color: #000e1f;" href="/views/home.php?link_up=<?= sha1('home_service_requisition'); ?>"><span class="fa fa-upload" ></span> Demande</a></li>
                <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 15px; color: #000e1f;" href="/views/home.php?link_up=<?= sha1('home_service_reception'); ?>"><span class="fa fa-download" ></span> Entrée</a></li>
                <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 15px; color: #000e1f;" href="/views/home.php?link=<?= sha1("service_reception_inventory") ?>&link_up=<?= sha1("home_service_reception") ?>"><span class="fa fa-list-ol" ></span> Inventaire</a></li>
                <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 15px; color: #000e1f;" href="/views/home.php?link_up=<?= sha1('home_service_sale'); ?>"><span class="fa fa-dollar" ></span> Vente production</a></li>
                <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 15px; color: #000e1f;" href="/views/home.php?link_up=<?= sha1('home_service_distribution'); ?>"><span class="fa fa-dollar" ></span> Vente sur stock</a></li>
                <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 15px; color: #000e1f;" href="/views/home.php?link_up=<?= sha1('home_service_recuperation'); ?>"><span class="fa fa-undo" ></span> Annuler vente</a></li>
                <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 15px; color: #000e1f;" href="/views/home.php?link_up=<?= sha1('home_service_productionglobal'); ?>"><span class="fa fa-recycle" ></span> Production</a></li>
                <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 15px; color: #000e1f;" href="/views/home.php?link_up=<?= sha1('home_service_participation'); ?>"><span class="fa fa-cube" ></span> Consommation MP</a></li>
                <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 15px; color: #000e1f;" href="/views/home.php?link_up=<?= sha1('home_logistique_depense'); ?>"><span class="fa fa-dollar" ></span> DEPENSES</a></li>
                <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 15px; color: #000e1f;" href="/views/home.php?link_up=<?= sha1('home_logistique_dette'); ?>"><span class="fa fa-dollar" ></span> DETTES</a></li>
                <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 15px; color: #000e1f;" href="/views/home.php?link_up=<?= sha1('home_facture'); ?>"><span class="fa fa-pencil-square" ></span> Mes Factures</a></li>
                <?php
            } elseif ($_SESSION['type'] == 'membre') {
            ?>
                <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 15px; color: #000e1f;" href="/views/home.php?link_up=<?= sha1('home_service_swaping'); ?>"><span class="fa fa-download" style="color: #0069d9; font-size: 15px;"></span>Swaping</a></li>
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

