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
                        <li class="list-inline-item"><span style="color: red;font-size: 20px;" class="glyphicon glyphicon-asterisk"></span><a href="/views/home.php?link=<?= sha1("logistique_livraison_add")?>&link_up=<?= sha1("home_logistique_livraison")?>">Nouvelle livraison</a></li>
                        <li class="list-inline-item"><span style="color: dodgerblue;font-size: 20px;" class="fa fa-bar-chart-o"></span><a href="/views/home.php?link=<?= sha1("logistique_livraison_liste_livraison_all")?>&link_up=<?= sha1("home_logistique_livraison")?>">Statistiques Cost All</a></li>
                        <li class="list-inline-item"><span style="color: tomato;font-size: 20px;" class="fa fa-gift"></span><span style="color: tomato;font-size: 20px;" class="fa fa-share-alt"></span><a href="/views/home.php?link=<?= sha1("logistique_livraison_fiche_biens_livraison_all")?>&link_up=<?= sha1("home_logistique_livraison")?>">Les livraisons par biens/produit</a></li>
                        <li class="list-inline-item"><span style="color: #0069d9;font-size: 20px;" class="fa fa-briefcase"></span><span style="color: #0069d9;font-size: 20px;" class="fa fa-share-alt"></span><a href="/views/home.php?link=<?= sha1("logistique_livraison_fiche_service_livraison_all")?>&link_up=<?= sha1("home_logistique_livraison")?>">Les livraisons par service/département</a></li>
                    </ul>
                    <h3>Vente par POS / Services / Départements</h3>
                    <ul class="list-menu list-unstyled" style="font-size: 20px;">
                        <li class="list-inline-item"><span style="color: orange;font-size: 20px;" class="glyphicon glyphicon-list"></span><a href="/views/home.php?link=<?= sha1("service_distribution_liste_distribution_all")?>&link_up=<?= sha1("home_logistique_livraison")?>">Liste de toutes les ventes</a></li>
                        <li class="list-inline-item"><span style="color: forestgreen;font-size: 20px;" class="glyphicon glyphicon-list"></span><span style="color: forestgreen;font-size: 20px;" class="glyphicon glyphicon-ok-circle"></span><a href="/views/home.php?link=<?= sha1("service_distribution_liste_distribution_totale")?>&link_up=<?= sha1("home_logistique_livraison")?>">Liste des ventes récupérées</a></li>
                        <li class="list-inline-item"><span style="color: darkslategray;font-size: 20px;" class="fa fa-gift"></span><span style="color: darkslategray;font-size: 20px;" class="fa fa-file-text"></span><a href="/views/home.php?link=<?= sha1("service_distribution_fiche_biens_distribution_all")?>&link_up=<?= sha1("home_logistique_livraison")?>">Fiche des ventes par biens/produit</a></li>
                        <li class="list-inline-item"><span style="color: darkslategray;font-size: 20px;" class="fa fa-list"></span><span style="color: darkslategray;font-size: 20px;" class="fa fa-file-text"></span><a href="/views/home.php?link=<?= sha1("demand_distribution_fiche_vente_distribution_all")?>&link_up=<?= sha1("home_logistique_livraison")?>">Demand sur vente</a></li>
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
                <div id="main_container" class="col-lg-9" style="padding: 10px;height: 80vh;overflow: auto;">
                    <?php
                    if (isset($_GET['link'])) {
                        if ($_GET['link']== sha1("logistique_livraison_add")) {
                            include 'logistique/livraison/add_livraison.php';
                        } else if ($_GET['link']== sha1("logistique_livraison_liste_livraison_all")) {
                            include 'logistique/livraison/liste_livraison_all.php';
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
                        } else if ($_GET['link']== sha1("logistique_livraison_panier_livraison_add")) {
                            include 'logistique/livraison/add_panier_livraison.php';
                        } else if ($_GET['link']== sha1("service_distribution_liste_distribution_all")) {
                            include 'service/distribution/liste_distribution_all.php';
                        } else if ($_GET['link']== sha1("service_distribution_liste_distribution_partielle")) {
                            include 'service/distribution/liste_distribution_partielle.php';
                        } else if ($_GET['link']== sha1("service_distribution_liste_distribution_totale")) {
                            include 'service/distribution/liste_distribution_totale.php';
                        } else if ($_GET['link']== sha1("service_distribution_fiche_biens_distribution_all")) {
                            include 'service/distribution/fiche_biens_distribution_all.php';
                        }else if ($_GET['link']== sha1("demand_distribution_fiche_vente_distribution_all")) {
                            include 'service/distribution/demand_distribution_fiche_vente_distribution_all.php';
                        } else if ($_GET['link']== sha1("service_distribution_fiche_biens_distribution_self")) {
                            include 'service/distribution/fiche_biens_distribution_self.php';
                        }
                    } else {
                        include 'logistique/livraison/add_livraison.php';
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

