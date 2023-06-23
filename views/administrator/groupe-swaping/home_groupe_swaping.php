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
                        <?php
                        if ($_SESSION['type'] == "personnel") {
                            ?>
                            <li class="list-inline-item"><span style="color: red;font-size: 20px;" class="fa fa-bar-chart-o"></span><a href="/openstock/views/home.php?link=<?= sha1("admin_groupe_swaping_stat") ?>&link_up=<?= sha1("home_admin_groupe_swaping") ?>">Statistics</a></li>
                            <?php
                        } else {
                            ?>
                            <li class="list-inline-item"><span style="color: red;font-size: 20px;" class="fa fa-bar-chart-o"></span><a href="/openstock/views/home.php?link=<?= sha1("admin_groupe_swaping_stat") ?>&link_up=<?= sha1("home_admin_groupe_swaping") ?>">Statistics</a></li>
                            <li class="list-inline-item"><span style="color: red;font-size: 20px;" class="glyphicon glyphicon-asterisk"></span><a href="/openstock/views/home.php?link=<?= sha1("admin_groupe_swaping_add") ?>&link_up=<?= sha1("home_admin_groupe_swaping") ?>">New category</a></li>
                            <li class="list-inline-item"><span style="color: forestgreen;font-size: 20px;" class="glyphicon glyphicon-adjust"></span><a href="/openstock/views/home.php?link=<?= sha1("admin_groupe_swaping_update_groupe_swaping_all") ?>&link_up=<?= sha1("home_admin_groupe_swaping") ?>">Update category</a></li>
                            <li class="list-inline-item"><span style="color: darkslategrey;font-size: 20px;" class="glyphicon glyphicon-check"></span><a href="/openstock/views/home.php?link=<?= sha1("admin_groupe_swaping_active_groupe_swaping_all") ?>&link_up=<?= sha1("home_admin_groupe_swaping") ?>">Activation</a></li>
                            <li class="list-inline-item"><span style="color: orange;font-size: 20px;" class="glyphicon glyphicon-list"></span><a href="/openstock/views/home.php?link=<?= sha1("admin_groupe_swaping_liste_groupe_swaping_all") ?>&link_up=<?= sha1("home_admin_groupe_swaping") ?>">Categories</a></li>
                            
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
                <div class="col-lg-9" style="padding: 10px;height: 80vh;overflow: auto;">
                    <?php
                    if (isset($_GET['link'])) {
                        if ($_GET['link'] == sha1("admin_groupe_swaping_add")) {
                            include 'administrator/groupe-swaping/add_groupe_swaping.php';
                        } else if ($_GET['link'] == sha1("admin_groupe_swaping_liste_groupe_swaping_all")) {
                            include 'administrator/groupe-swaping/liste_groupe_swaping_all.php';
                        } else if ($_GET['link'] == sha1("admin_groupe_swaping_update_groupe_swaping_all")) {
                            include 'administrator/groupe-swaping/update_groupe_swaping_all.php';
                        } else if ($_GET['link'] == sha1("admin_groupe_swaping_active_groupe_swaping_all")) {
                            include 'administrator/groupe-swaping/active_groupe_swaping_all.php';
                        } else if ($_GET['link'] == sha1("admin_groupe_swaping_stat")) {
                            include 'administrator/groupe-swaping/stat_groupe_swaping.php';
                        } else if ($_GET['link'] == sha1("admin_groupe_swaping_stat_simple")) {
                            include 'administrator/groupe-swaping/stat_groupe_swaping_simple.php';
                        } else if ($_GET['link'] == sha1("admin_agent_fiche_agent_self")) {
                            include 'administrator/agent/fiche_agent_self.php';
                        } else if ($_GET['link'] == sha1("admin_affectation_service_fiche_affectation_service_all")) {
                            include 'administrator/affectation-service/fiche_affectation_service_all.php';
                        } else if ($_GET['link'] == sha1("admin_affectation_service_fiche_affectation_service_self")) {
                            include 'administrator/affectation-service/fiche_affectation_service_self.php';
                        }
                    } else {
                        include 'administrator/groupe-swaping/stat_groupe_swaping.php';
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

