<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php
include './meta/menu_logistique.php';
?>
<div class="row" style="padding: 10px;">
    <div class="col-md-12" style="background-color: whitesmoke;border-radius: 5px; height: 90vh;">
        <div class="container-fluid">
            <div class="row">
                <div id="menu-gauche" class="col-lg-3">
                    <ul class="list-menu list-unstyled" style="font-size: 20px;">
                    <?php
                        if ($_SESSION['type'] == 'logistique') {
                    ?>
                        <li class="list-inline-item"><span style="color: red;font-size: 20px;" class="glyphicon glyphicon-asterisk"></span><a href="/views/home.php?link=<?= sha1("logistique_recuperation_add")?>&link_up=<?= sha1("home_logistique_recuperation")?>">Nouvelle récuperation</a></li>
                    <?php } ?>    
                        <li class="list-inline-item"><span style="color: orange;font-size: 20px;" class="glyphicon glyphicon-list"></span><a href="/views/home.php?link=<?= sha1("logistique_recuperation_liste_recuperation_all")?>&link_up=<?= sha1("home_logistique_recuperation")?>">Liste de toutes les récuperations</a></li>
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
                        if ($_GET['link']== sha1("logistique_recuperation_add")) {
                            include 'logistique/recuperation/add_recuperation.php';
                        } else if ($_GET['link']== sha1("logistique_recuperation_liste_recuperation_all")) {
                            include 'logistique/recuperation/liste_recuperation_all.php';
                        } else if ($_GET['link']== sha1("logistique_livraison_fiche_biens_livraison_all")) {
                            include 'logistique/livraison/fiche_biens_livraison_all.php';
                        } else if ($_GET['link']== sha1("logistique_livraison_fiche_biens_livraison_self")) {
                            include 'logistique/livraison/fiche_biens_livraison_self.php';
                        } else if ($_GET['link']== sha1("logistique_livraison_fiche_service_livraison_all")) {
                            include 'logistique/livraison/fiche_service_livraison_all.php';
                        } else if ($_GET['link']== sha1("logistique_livraison_fiche_service_livraison_self")) {
                            include 'logistique/livraison/fiche_service_livraison_self.php';
                        } else if ($_GET['link']== sha1("logistique_attribution_biens_liste_attribution_biens_encours_all")) {
                            include 'logistique/attribution-biens/liste_attribution_biens_encours_all.php';
                        } else if ($_GET['link']== sha1("logistique_attribution_biens_fiche_biens_attribution_all")) {
                            include 'logistique/attribution-biens/fiche_biens_attribution_all.php';
                        } else if ($_GET['link']== sha1("logistique_attribution_biens_fiche_biens_attribution_self")) {
                            include 'logistique/attribution-biens/fiche_biens_attribution_self.php';
                        }
                    } else {
                        include 'logistique/recuperation/add_recuperation.php';
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

