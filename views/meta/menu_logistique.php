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
<div class="row" style="margin-top: 12%;">
<?php
if ($_SESSION['type'] == 'logistique') {
?>
    <div id="menu2-a" class="col-lg-12 col-md-12 col-sm-12">
        <ul class="nav nav-tabs nav-justified">
            <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 25px;" class="active" href="/views/home.php?link_up=<?= sha1('home_logistique_acceuil'); ?>"><span class="fa fa-home" style="color: #0069d9;margin: 10px;"></span>Accueil</a></li>
            <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 15px;" href="/views/home.php?link_up=<?= sha1('home_logistique_purchase'); ?>"><span class="fa fa-download" style="color: #0069d9;margin: 10px;"></span>Entrée</a></li>
            <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 15px;" href="/views/home.php?link_up=<?= sha1('home_logistique_sales'); ?>"><span class="fa fa-share-square-o" style="color: #0069d9;margin: 10px;"></span>Sortie</a></li>
            <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 15px;" href="/views/home.php?link_up=<?= sha1('home_logistique_inventaire'); ?>"><span class="fa fa-archive" style="color: #0069d9;margin: 10px;"></span>Inventaire</a></li>
            <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 15px;" href="/views/home.php?link_up=<?= sha1('home_logistique_recuperation'); ?>"><span class="fa fa-undo" style="color: #0069d9;margin: 10px;"></span>Récuperation</a></li>
            <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 15px;" href="/views/home.php?link_up=<?= sha1('home_logistique_customer'); ?>"><span class="fa fa-user" style="color: #0069d9;margin: 10px;"></span>Clients</a></li>
            <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 15px;" href="/views/home.php?link_up=<?= sha1('home_logistique_transport'); ?>"><span class="fa fa-bus" style="color: #0069d9;margin: 10px;"></span>Transport</a></li>
            <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 15px;" href="/views/home.php?link_up=<?= sha1('home_logistique_depense'); ?>"><span class="fa fa-dollar" style="color: #0069d9;margin: 10px;"></span>Depenses</a></li>
            <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 15px;" href="/views/home.php?link_up=<?= sha1('home_logistique_caisse'); ?>"><span class="fa fa-dollar" style="color: #0069d9;margin: 10px;"></span>Caisses</a></li>
            <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 15px;" href="/views/home.php?link_up=<?= sha1('home_logistique_dette'); ?>"><span class="fa fa-dollar" style="color: #0069d9;margin: 10px;"></span>Dettes</a></li>
            <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 15px;" href="/views/home.php?link_up=<?= sha1('home_logistique_taux'); ?>"><span class="fa fa-dollar" style="color: #0069d9;margin: 10px;"></span>Devise</a></li>
            <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 15px;" href="/views/home.php?link_up=<?= sha1('home_logistique_amortissement'); ?>"><span class="fa fa-minus-circle" style="color: #0069d9;margin: 10px;"></span>Amortissement</a></li>
            <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 15px;" href="/views/home.php?link_up=<?= sha1('home_logistique_bordereau_expedition'); ?>"><span class="fa fa-book" style="color: #0069d9;margin: 10px;"></span>Bordereau d'expedition</a></li>
            <li role="presentation"><a class="btn btn shadow-none text-uppercase fw-bolder" style="font-size: 15px;" href="/views/home.php?link_up=<?= sha1('home_facture_client'); ?>"><span class="fa fa-pencil-square" style="color: #0069d9;margin: 10px;"></span>Facture A Payer</a></li>
            <!--<li role="presentation"><a style="font-size: 15px;" href=""><span class="fa fa-dollar" style="color: #0069d9; font-size: 30px;"></span>Vente en gros</a></li>-->
        </ul>
    </div>
<?php
}else{
?>
<div class="col-4">
<a class="btn btn-primary shadow-none text-white" style="font-size: 15px;" class="active" href="/views/home.php?link_up=<?= sha1('home_service_acceuil');?>"><span><i class="fa fa-backward"></i> TRAVAILLEUR</span></a>
</div>
<?php
}
?>
</div>

<style>
    #menu2-a ul li a {
        color: #0069d9;
        font-size: 15px;
    }
</style>

