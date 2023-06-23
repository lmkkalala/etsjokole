<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php
include './meta/menu_admin.php';
?>
<div class="row" style="padding: 10px;">
    <div class="col-md-12" style="background-color: whitesmoke;border-radius: 5px; height: 90vh;">
        <div class="container-fluid">
            <div class="row">
                <div id="menu-gauche" class="col-lg-3">
                    <ul class="list-menu list-unstyled" style="font-size: 20px;">
                        <li class="list-inline-item"><span style="color: red;font-size: 20px;" class="glyphicon glyphicon-asterisk"></span><a href="/views/home.php?link=<?= sha1("admin_affectation_groupe_add") ?>&link_up=<?= sha1("home_admin_affectation_groupe") ?>">New</a></li>
                        <li class="list-inline-item"><span style="color: orange;font-size: 20px;" class="glyphicon glyphicon-lock"></span><a href="/views/home.php?link=<?= sha1("admin_affectation_groupe_blockage") ?>&link_up=<?= sha1("home_admin_affectation_groupe") ?>">Lock</a></li>
                        <li class="list-inline-item"><span style="color: forestgreen;font-size: 20px;" class="glyphicon glyphicon-check"></span><a href="/views/home.php?link=<?= sha1("admin_affectation_groupe_deblockage") ?>&link_up=<?= sha1("home_admin_affectation_groupe") ?>">unlock</a></li>
                        <li class="list-inline-item"><span style="color: dodgerblue;font-size: 20px;" class="glyphicon glyphicon-list"></span><a href="/views/home.php?link=<?= sha1("admin_affectation_groupe_liste_active") ?>&link_up=<?= sha1("home_admin_affectation_groupe") ?>">List of  active's configuration</a></li>
                        <li class="list-inline-item"><span style="color: red;font-size: 20px;" class="glyphicon glyphicon-list"></span><a href="/views/home.php?link=<?= sha1("admin_affectation_groupe_liste_blocke") ?>&link_up=<?= sha1("home_admin_affectation_groupe") ?>">List of  desactive's configuration</a></li>
                        <li class="list-inline-item"><span style="color: red;font-size: 20px;" class="glyphicon glyphicon-list"></span><a href="/views/home.php?link=<?= sha1("admin_affectation_groupe_liste_desactive") ?>&link_up=<?= sha1("home_admin_affectation_groupe") ?>">List of for evermore desactived</a></li>
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
                <div class="col-lg-9" style="padding: 10px;height: 80vh;overflow: auto;">
                    <?php
                    if (isset($_GET['link'])) {
                        if ($_GET['link'] == sha1("admin_affectation_groupe_add")) {
                            include 'administrator/affectation-groupe/add_affectation_groupe.php';
                        } else if ($_GET['link'] == sha1("admin_affectation_groupe_blockage")) {
                            include 'administrator/affectation-groupe/blockage_affectation_groupe.php';
                        } else if ($_GET['link'] == sha1("admin_affectation_groupe_deblockage")) {
                            include 'administrator/affectation-groupe/deblockage_affectation_groupe.php';
                        } else if ($_GET['link'] == sha1("admin_affectation_groupe_liste_active")) {
                            include 'administrator/affectation-groupe/liste_affectation_groupe_active.php';
                        } else if ($_GET['link'] == sha1("admin_affectation_groupe_liste_blocke")) {
                            include 'administrator/affectation-groupe/liste_affectation_groupe_blocke.php';
                        } else if ($_GET['link'] == sha1("admin_affectation_groupe_liste_desactive")) {
                            include 'administrator/affectation-groupe/liste_affectation_groupe_desactive.php';
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
                        include 'administrator/affectation-groupe/add_affectation_groupe.php';
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

