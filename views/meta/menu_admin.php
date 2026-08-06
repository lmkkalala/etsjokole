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
    <div id="menu2-a" class="col-lg-12">
        <ul class="nav nav-tabs nav-justified">
            <li role="presentation"><a class="btn btn shadow-none fw-bolder" href="/views/home.php?link_up=<?= sha1("home_admin_acceuil") ?>"><span class="glyphicon glyphicon-home" style="color: #0069d9; margin: 10px;"></span>Acceuil</a></li>

            <?php
            if ($_SESSION['type'] == "admin") {
                ?>
                <li role="presentation"><a class="btn btn shadow-none fw-bolder" href="/views/home.php?link_up=<?= sha1("home_admin_agent") ?>"><span class="glyphicon glyphicon-user" style="color: #0069d9; margin: 10px;"></span>Agent</a></li>
                <li role="presentation"><a class="btn btn shadow-none fw-bolder" href="/views/home.php?link_up=<?= sha1("home_admin_fonction") ?>"><span class="glyphicon glyphicon-edit" style="color: #0069d9; margin: 10px;"></span>Departement</a></li>
                <!-- <li role="presentation"><a href=""><span class="fa fa-recycle" style="color: #0069d9; font-size: 20px;margin: 10px;"></span>Meal configuration</a></li> -->
                <li role="presentation"><a class="btn btn shadow-none fw-bolder" href="/views/home.php?link_up=<?= sha1("home_admin_utilisateur") ?>"><span class="glyphicon glyphicon-user" style="color: #0069d9; margin: 10px;"></span>Utilisateur</a></li>
                <?php
            }
            if (($_SESSION['type'] == "administration") || ($_SESSION['type'] == "admin")) {
                ?>
                <!-- <li role="presentation"><a href=""><span class="glyphicon glyphicon-file" style="color: #0069d9; margin: 10px;"></span>Swaping</a></li> -->
                <li role="presentation"><a class="btn btn shadow-none fw-bolder" href="/views/home.php?link_up=<?= sha1("home_admin_service") ?>"><span class="glyphicon glyphicon-inbox" style="color: #0069d9; margin: 10px;"></span>Service</a></li>
                <?php
            }
            
            if ($_SESSION['type'] == "admin") {
            ?>
                <li role="presentation"><a class="btn btn shadow-none fw-bolder" href="/views/home.php?link_up=<?= sha1("home_admin_affectation_service") ?>"><span class="glyphicon glyphicon-download" style="color: #0069d9; margin: 10px;"></span>Agent Affectation</a></li>
                <li role="presentation"><a class="btn btn shadow-none fw-bolder" href="/views/home.php?link_up=<?= sha1("home_admin_entreprise") ?>"><span class="glyphicon glyphicon-tasks" style="color: #0069d9; margin: 10px;"></span>Configuration</a></li>
            <?php
            }

            if (($_SESSION['type'] == "personnel")) {
                ?>
                <li role="presentation"><a class="btn btn shadow-none fw-bolder" href="/views/home.php?link_up=<?= sha1("home_admin_groupe_swaping") ?>"><span class="glyphicon glyphicon-file" style="color: #0069d9; margin: 10px;"></span>Swaping</a></li>
                <li role="presentation"><a class="btn btn shadow-none fw-bolder" href="/views/home.php?link_up=<?= sha1("home_admin_agent") ?>"><span class="glyphicon glyphicon-user" style="color: #0069d9; margin: 10px;"></span>Agent</a></li>
                <li role="presentation"><a class="btn btn shadow-none fw-bolder" href="/views/home.php?link_up=<?= sha1("home_admin_fonction") ?>"><span class="glyphicon glyphicon-edit" style="color: #0069d9; margin: 10px;"></span>Department</a></li>
                <li role="presentation"><a class="btn btn shadow-none fw-bolder" href="/views/home.php?link_up=<?= sha1("home_admin_affectation_groupe") ?>"><span class="fa fa-recycle" style="color: #0069d9; font-size: 20px;margin: 10px;"></span>Meal configuration</a></li>
                <?php
            }
            if (($_SESSION['type'] == "hr_mb")) {
            ?>
                <li role="presentation"><a class="btn btn shadow-none fw-bolder" href="/views/home.php?link_up=<?= sha1("home_admin_offreemploie") ?>"><span class="glyphicon glyphicon-file" style="color: #0069d9; margin: 5px;"></span>Offre d'emploie</a></li>
                <li role="presentation"><a class="btn btn shadow-none fw-bolder" href="/views/home.php?link_up=<?= sha1("home_admin_candidat") ?>"><span class="glyphicon glyphicon-user" style="color: #0069d9; margin: 5px;"></span>Candidat</a></li>
                <li role="presentation"><a class="btn btn shadow-none fw-bolder" href="/views/home.php?link_up=<?= sha1("home_admin_employe") ?>"><span class="fa fa-users" style="color: #0069d9; margin: 15px;"></span>Employé</a></li>
                <li role="presentation"><a class="btn btn shadow-none fw-bolder" href="/views/home.php?link_up=<?= sha1("home_admin_compte") ?>"><span class="glyphicon glyphicon-usd" style="color: #0069d9; margin: 5px;"></span>Compte</a></li>
                <li role="presentation"><a class="btn btn shadow-none fw-bolder" href="/views/home.php?link_up=<?= sha1("home_admin_chargeconf") ?>"><span class="glyphicon glyphicon-bed" style="color: #0069d9; margin: 5px;"></span>Charge de l'employé</a></li>
                <li role="presentation"><a class="btn btn shadow-none fw-bolder" href="/views/home.php?link_up=<?= sha1("home_admin_promotion") ?>"><span class="glyphicon glyphicon-upload" style="color: #0069d9; margin: 5px;"></span>Promotion</a></li>
                <li role="presentation"><a class="btn btn shadow-none fw-bolder" href="/views/home.php?link_up=<?= sha1("home_admin_bulletin") ?>"><span class="fa fa-file-text-o" style="color: #0069d9; margin: 5px;"></span>Bulletin de paie</a></li>
                <li role="presentation"><a class="btn btn shadow-none fw-bolder" href="/views/home.php?link_up=<?= sha1("home_admin_composantesalaire") ?>"><span class="fa fa-trello" style="color: #0069d9; margin: 5px;"></span>Composante salaire</a></li>
                <li role="presentation"><a class="btn btn shadow-none fw-bolder" href="/views/home.php?link_up=<?= sha1("home_admin_composanteimposition") ?>"><span class="fa fa-twitch" style="color: #0069d9; margin: 5px;"></span>Composante contribution patron</a></li>
                <li role="presentation"><a class="btn btn shadow-none fw-bolder" href="/views/home.php?link_up=<?= sha1("home_admin_categorieM") ?>"><span class="fa fa-ticket" style="color: #0069d9; margin: 15px;"></span>Catégorie salariale</a></li>
                <li role="presentation"><a class="btn btn shadow-none fw-bolder" href="/views/home.php?link_up=<?= sha1("home_admin_typecontrat") ?>"><span class="glyphicon glyphicon-file" style="color: #0069d9; margin: 5px;"></span>Type de contrat</a></li>
                <li role="presentation"><a class="btn btn shadow-none fw-bolder" href="/views/home.php?link_up=<?= sha1("home_admin_serviceM") ?>"><span class="glyphicon glyphicon-inbox" style="color: #0069d9; margin: 5px;"></span>Service</a></li>
                <li role="presentation"><a class="btn btn shadow-none fw-bolder" href="/views/home.php?link_up=<?= sha1("home_admin_fonctionM") ?>"><span class="glyphicon glyphicon-bookmark" style="color: #0069d9; margin: 5px;"></span>Fonction</a></li>
                
            <?php
            }
            ?>

            
        </ul>
    </div>

</div>
<style>
    /* #menu2-a {

    }

    #menu2-b {
    } */

    #menu2-a ul li a {
        color: #0069d9;
        font-size: 16px;
    }
</style>

