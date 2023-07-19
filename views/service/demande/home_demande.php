<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php
include './meta/menu_service.php';
?>
<div class="row" style="padding: 10px;">
    <div class="col-md-12" style="background-color: whitesmoke;border-radius: 5px; height: 90vh;">
        <div class="container-fluid">
            <div class="row">
                <div id="menu-gauche" class="col-md-3 bg-white">
                    <ul class="list-menu list-unstyled" style="font-size: 20px;">
                        <li class="list-inline-item"><span style="color: red;font-size: 20px;" class="glyphicon glyphicon-asterisk"></span><a href="/views/home.php?link=<?= sha1("service_demande_add") ?>&link_up=<?= sha1("home_service_demande") ?>">Nouvelle demande</a></li>
                        <?php
                        if ($_SESSION['type'] == "other") {
                            ?>
                            <li class="list-inline-item"><span style="color: orange;font-size: 20px;" class="glyphicon glyphicon-list"></span><a href="/views/home.php?link=<?= sha1("service_demande_liste_demande_all") ?>&link_up=<?= sha1("home_service_demande") ?>">Liste de toutes les commandes</a></li>
                            <li class="list-inline-item"><span style="color: red;font-size: 20px;" class="glyphicon glyphicon-list"></span><span style="color: red;font-size: 20px;" class="glyphicon glyphicon-time"></span><a href="/views/home.php?link=<?= sha1("service_demande_liste_demande_encours") ?>&link_up=<?= sha1("home_service_demande") ?>">Liste des demandes encours</a></li>
                            <li class="list-inline-item"><span style="color: forestgreen;font-size: 20px;" class="glyphicon glyphicon-list"></span><span style="color: forestgreen;font-size: 20px;" class="glyphicon glyphicon-ok-circle"></span><a href="/views/home.php?link=<?= sha1("service_demande_liste_demande_finalise") ?>&link_up=<?= sha1("home_service_demande") ?>">Liste des demandes finalisées</a></li>
                            <li class="list-inline-item"><span style="color: darkslategray;font-size: 20px;" class="glyphicon glyphicon-list"></span><span style="color: darkslategray;font-size: 20px;" class="fa fa-gift"></span><a href="/views/home.php?link=<?= sha1("service_demande_fiche_biens_demande_all") ?>&link_up=<?= sha1("home_service_demande") ?>">Fiche de demandes par biens/produit</a></li>
                            <hr>
                            <li class="list-inline-item"><span style="color: red;font-size: 20px;" class="glyphicon glyphicon-list"></span><span style="color: red;font-size: 20px;" class="glyphicon glyphicon-time"></span><a href="/views/home.php?link=<?= sha1("service_demande_liste_demande_encours_interne") ?>&link_up=<?= sha1("home_service_demande") ?>">Liste des demandes encours Interne</a></li>
                            <li class="list-inline-item"><span style="color: green;font-size: 20px;" class="glyphicon glyphicon-list"></span><span style="color: green;font-size: 20px;" class="glyphicon glyphicon-ok"></span><a href="/views/home.php?link=<?= sha1("service_demande_liste_demande_finalise_interne") ?>&link_up=<?= sha1("home_service_demande") ?>">Liste des demandes finalisées Interne</a></li>
                            <?php
                        }
                        ?>

                    </ul>
                </div>
                <style>
                    #menu-gauche {
                        border-right-style: solid;
                        border-right-color: black;
                    }

                    #menu-gauche ul li {
                        padding: 8px;
                    }

                    #menu-gauche ul li a {
                        text-decoration: none;
                    }

                    #menu-gauche ul li span {
                        margin-right: 5px;
                    }
                </style>
                <div class="col-md-9" style="padding: 10px;height: 80vh;overflow: auto;">
                    <?php
                    if (isset($_GET['link'])) {
                        if ($_GET['link'] == sha1("service_demande_add")) {
                            include 'service/demande/add_demande.php';
                        } else if ($_GET['link'] == sha1("service_demande_liste_demande_all")) {
                            include 'service/demande/liste_demande_all.php';
                        } else if ($_GET['link'] == sha1("service_demande_liste_demande_encours")) {
                            include 'service/demande/liste_demande_encours.php';
                        } else if ($_GET['link'] == sha1("service_demande_liste_demande_finalise")) {
                            include 'service/demande/liste_demande_finalise.php';
                        } else if ($_GET['link'] == sha1("service_demande_fiche_biens_demande_all")) {
                            include 'service/demande/fiche_biens_demande_all.php';
                        } else if ($_GET['link'] == sha1("service_demande_fiche_biens_demande_self")) {
                            include 'service/demande/fiche_biens_demande_self.php';
                        } else if ($_GET['link'] == sha1("admin_affectation_service_fiche_affectation_service_all")) {
                            include 'administrator/affectation-service/fiche_affectation_service_all.php';
                        } else if ($_GET['link'] == sha1("admin_affectation_service_fiche_affectation_service_self")) {
                            include 'administrator/affectation-service/fiche_affectation_service_self.php';
                        } else if ($_GET['link'] == sha1("service_demande_liste_demande_encours_interne")) {
                            include 'service/demande/liste_demande_encours_interne.php';
                        } else if ($_GET['link'] == sha1("service_demande_liste_demande_finalise_interne")) {
                            include 'service/demande/liste_demande_finalise_interne.php';
                        }
                    } else {
                        include 'service/demande/add_demande.php';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <style>
        #entete1-logo a {
            text-decoration: none;
            color: white;
            display: inline-block;
        }

        body {
            margin: 0;
        }

        #entete1-button {
            padding: 15px;
            padding-left: 5px;
        }
    </style>
</div>

