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
                <div id="menu-gauche" class="col-lg-3">
                    <ul class="list-menu list-unstyled" style="font-size: 20px;">
                        <li class="list-inline-item"><span style="color: red;font-size: 20px;" class="glyphicon glyphicon-asterisk"></span><a href="/views/home.php?link=<?= sha1("service_nourriture_add")?>&link_up=<?= sha1("home_service_nourriture")?>">New</a></li>
                        <li class="list-inline-item"><span style="color: forestgreen;font-size: 20px;" class="glyphicon glyphicon-adjust"></span><a href="/views/home.php?link=<?= sha1("service_nourriture_update_nourriture_all")?>&link_up=<?= sha1("home_service_nourriture")?>">Mise à jour</a></li>
                        <li class="list-inline-item"><span style="color: darkslategrey;font-size: 20px;" class="glyphicon glyphicon-check"></span><a href="/views/home.php?link=<?= sha1("service_nourriture_active_nourriture_all")?>&link_up=<?= sha1("home_service_nourriture")?>">Activation</a></li>
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
                        if ($_GET['link']== sha1("service_nourriture_add")) {
                            include 'service/nourriture/add_nourriture.php';
                        } else if ($_GET['link']== sha1("logistique_categorie_liste_categorie_all")) {
                            include 'logistique/categorie/liste_categorie_all.php';
                        } else if ($_GET['link']== sha1("service_nourriture_update_nourriture_all")) {
                            include 'service/nourriture/update_nourriture_all.php';
                        } else if ($_GET['link']== sha1("service_nourriture_active_nourriture_all")) {
                            include 'service/nourriture/active_nourriture_all.php';
                        } else if ($_GET['link']== sha1("logistique_categorie_fiche_categorie_all")) {
                            include 'logistique/categorie/fiche_categorie_all.php';
                        } else if ($_GET['link']== sha1("logistique_categorie_fiche_categorie_self")) {
                            include 'logistique/categorie/fiche_categorie_self.php';
                        } else if ($_GET['link']== sha1("admin_affectation_service_fiche_affectation_service_all")) {
                            include 'administrator/affectation-service/fiche_affectation_service_all.php';
                        }  else if ($_GET['link']== sha1("admin_affectation_service_fiche_affectation_service_self")) {
                            include 'administrator/affectation-service/fiche_affectation_service_self.php';
                        }
                    } else {
                        include 'service/nourriture/add_nourriture.php';
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

