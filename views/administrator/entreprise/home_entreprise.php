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
                    <?php
                    
                    ?>
                    <ul class="list-menu list-unstyled" style="font-size: 20px;">
                        <li class="list-inline-item"><span style="color: red;font-size: 20px;" class="glyphicon glyphicon-equalizer"></span><a href="/views/home.php?link=<?= sha1("admin_entreprise_add")?>&link_up=<?= sha1("home_admin_entreprise")?>">Configuration primaire</a></li>
                        <li class="list-inline-item"><span style="color: forestgreen;font-size: 20px;" class="glyphicon glyphicon-adjust"></span><a href="/views/home.php?link=<?= sha1("admin_entreprise_update")?>&link_up=<?= sha1("home_admin_entreprise")?>">Mise à jour</a></li>
                        <li class="list-inline-item"><span style="color: blueviolet;font-size: 20px;" class="glyphicon glyphicon-copy"></span><a href="/views/home.php?link=<?= sha1("admin_entreprise_fiche_entreprise_self")?>&link_up=<?= sha1("home_admin_entreprise")?>">Fiche de l'entreprise</a></li>
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
                        if ($_GET['link']== sha1("admin_entreprise_add")) {
                            include 'administrator/entreprise/add_entreprise.php';
                        } else if ($_GET['link']== sha1("admin_entreprise_update")) {
                            include 'administrator/entreprise/update_entreprise_self.php';
                        } else if ($_GET['link']== sha1("admin_entreprise_fiche_entreprise_self")) {
                            include 'administrator/entreprise/fiche_entreprise_self.php';
                        } else if ($_GET['link']== sha1("admin_agent_active_agent_all")) {
                            include 'administrator/agent/active_agent_all.php';
                        } else if ($_GET['link']== sha1("admin_agent_fiche_agent_all")) {
                            include 'administrator/agent/fiche_agent_all.php';
                        } else if ($_GET['link']== sha1("admin_agent_fiche_agent_self")) {
                            include 'administrator/agent/fiche_agent_self.php';
                        }
                    } else {
                        include 'administrator/entreprise/add_entreprise.php';
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

