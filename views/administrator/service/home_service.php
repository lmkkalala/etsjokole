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
                        <li class="list-inline-item"><span style="color: red;font-size: 20px;" class="glyphicon glyphicon-asterisk"></span><a href="/views/home.php?link=<?= sha1("admin_service_add")?>&link_up=<?= sha1("home_admin_service")?>">New</a></li>
                        <li class="list-inline-item"><span style="color: forestgreen;font-size: 20px;" class="glyphicon glyphicon-adjust"></span><a href="/views/home.php?link=<?= sha1("admin_service_update_service_all")?>&link_up=<?= sha1("home_admin_service")?>">Update</a></li>
                        <li class="list-inline-item"><span style="color: darkslategrey;font-size: 20px;" class="glyphicon glyphicon-check"></span><a href="/views/home.php?link=<?= sha1("admin_service_active_service_all")?>&link_up=<?= sha1("home_admin_service")?>">Activation</a></li>
                        <li class="list-inline-item"><span style="color: orange;font-size: 20px;" class="glyphicon glyphicon-list"></span><a href="/views/home.php?link=<?= sha1("admin_service_liste_service_all")?>&link_up=<?= sha1("home_admin_service")?>">List</a></li>
                        <li class="list-inline-item"><span style="color: tomato;font-size: 20px;" class="glyphicon glyphicon-edit"></span><a href="/views/home.php?link=<?= sha1("admin_affectation_service_fiche_affectation_service_all")?>&link_up=<?= sha1("home_admin_affectation_service")?>">View</a></li>
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
                        if ($_GET['link']== sha1("admin_service_add")) {
                            include 'administrator/service/add_service.php';
                        } else if ($_GET['link']== sha1("admin_service_liste_service_all")) {
                            include 'administrator/service/liste_service_all.php';
                        } else if ($_GET['link']== sha1("admin_service_update_service_all")) {
                            include 'administrator/service/update_service_all.php';
                        } else if ($_GET['link']== sha1("admin_service_active_service_all")) {
                            include 'administrator/service/active_service_all.php';
                        } else if ($_GET['link']== sha1("admin_agent_fiche_agent_all")) {
                            include 'administrator/agent/fiche_agent_all.php';
                        } else if ($_GET['link']== sha1("admin_agent_fiche_agent_self")) {
                            include 'administrator/agent/fiche_agent_self.php';
                        } else if ($_GET['link']== sha1("admin_affectation_service_fiche_affectation_service_all")) {
                            include 'administrator/affectation-service/fiche_affectation_service_all.php';
                        }  else if ($_GET['link']== sha1("admin_affectation_service_fiche_affectation_service_self")) {
                            include 'administrator/affectation-service/fiche_affectation_service_self.php';
                        }
                    } else {
                        include 'administrator/service/add_service.php';
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

