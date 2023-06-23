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
                        <li class="list-inline-item"><span style="color: orange;font-size: 20px;" class="glyphicon glyphicon-list"></span><a href="/views/home.php?link=<?= sha1("logistique_demande_liste_demande_all")?>&link_up=<?= sha1("home_logistique_demande")?>">Liste de toutes les commandes</a></li>
                        <li class="list-inline-item"><span style="color: red;font-size: 20px;" class="glyphicon glyphicon-list"></span><span style="color: red;font-size: 20px;" class="glyphicon glyphicon-time"></span><a href="/views/home.php?link=<?= sha1("logistique_demande_liste_demande_encours")?>&link_up=<?= sha1("home_logistique_demande")?>">Liste des demandes encours</a></li>
                        <li class="list-inline-item"><span style="color: forestgreen;font-size: 20px;" class="glyphicon glyphicon-list"></span><span style="color: forestgreen;font-size: 20px;" class="glyphicon glyphicon-ok-circle"></span><a href="/views/home.php?link=<?= sha1("logistique_demande_liste_demande_finalise")?>&link_up=<?= sha1("home_logistique_demande")?>">Liste des demandes finalisées</a></li>
                        <li class="list-inline-item"><span style="color: darkslategray;font-size: 20px;" class="glyphicon glyphicon-file"></span><span style="color: darkslategray;font-size: 20px;" class="fa fa-gift"></span><a href="/views/home.php?link=<?= sha1("logistique_demande_fiche_biens_demande_all")?>&link_up=<?= sha1("home_logistique_demande")?>">Fiche de demandes par biens/produit</a></li>
                        <li class="list-inline-item"><span style="color: #0069d9;font-size: 20px;" class="glyphicon glyphicon-file"></span><a href="/views/home.php?link=<?= sha1("logistique_demande_fiche_service_demande_all")?>&link_up=<?= sha1("home_logistique_demande")?>">Fiche de demandes par service</a></li>
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
                        if ($_GET['link']== sha1("logistique_demande_liste_demande_all")) {
                            include 'logistique/demande/liste_demande_all.php';
                        } else if ($_GET['link']== sha1("logistique_demande_liste_demande_encours")) {
                            include 'logistique/demande/liste_demande_encours.php';
                        } else if ($_GET['link']== sha1("logistique_demande_liste_demande_finalise")) {
                            include 'logistique/demande/liste_demande_finalise.php';
                        } else if ($_GET['link']== sha1("logistique_demande_fiche_biens_demande_all")) {
                            include 'logistique/demande/fiche_biens_demande_all.php';
                        } else if ($_GET['link']== sha1("logistique_demande_fiche_biens_demande_self")) {
                            include 'logistique/demande/fiche_biens_demande_self.php';
                        } else if ($_GET['link']== sha1("logistique_demande_fiche_service_demande_all")) {
                            include 'logistique/demande/fiche_service_demande_all.php';
                        }  else if ($_GET['link']== sha1("logistique_demande_fiche_service_demande_self")) {
                            include 'logistique/demande/fiche_service_demande_self.php';
                        }
                    } else {
                        include 'logistique/demande/liste_demande_all.php';
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

