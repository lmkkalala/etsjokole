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
                <div id="menu-gauche" class="col-md-4 col-lg-3">
                    <ul class="list-menu list-unstyled" style="font-size: 20px;">
                        <li class="list-inline-item"><span style="color: red;font-size: 20px;" class="glyphicon glyphicon-asterisk"></span><a href="/views/home.php?link=<?= sha1("logistique_attribution_biens_add")?>&link_up=<?= sha1("home_logistique_attribution_biens")?>">Ajout</a></li><br>
                        <li class="list-inline-item"><span style="color: forestgreen;font-size: 20px;" class="glyphicon glyphicon-adjust"></span><a href="/views/home.php?link=<?= sha1("logistique_attribution_biens_update_attribution_biens_all")?>&link_up=<?= sha1("home_logistique_attribution_biens")?>">Modification</a></li>
                        <li class="list-inline-item"><span style="color: orange;font-size: 20px;" class="glyphicon glyphicon-list"></span><a href="/views/home.php?link=<?= sha1("logistique_attribution_biens_liste_attribution_biens_all")?>&link_up=<?= sha1("home_logistique_attribution_biens")?>">Toutes les commandes</a></li>
                        <li class="list-inline-item"><span style="color: darkslategray;font-size: 20px;" class="glyphicon glyphicon-time"></span><a href="/views/home.php?link=<?= sha1("logistique_attribution_biens_liste_attribution_biens_encours_all")?>&link_up=<?= sha1("home_logistique_attribution_biens")?>">Commandes en attente</a></li>
                        <li class="list-inline-item"><span style="color: tomato;font-size: 20px;" class="glyphicon glyphicon-user"></span><span style="color: tomato;font-size: 20px;" class="glyphicon glyphicon-edit"></span><a href="/views/home.php?link=<?= sha1("logistique_attribution_biens_fiche_attribution_fournisseur_all")?>&link_up=<?= sha1("home_logistique_attribution_biens")?>">Commandes par fourn.</a></li>
                        <li class="list-inline-item"><span style="color: #0069d9;font-size: 20px;" class="fa fa-list-alt"></span><a href="/views/home.php?link=<?= sha1("logistique_attribution_biens_fiche_biens_attribution_all")?>&link_up=<?= sha1("home_logistique_attribution_biens")?>">Commandes par produit</a></li>
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
                <div class="col-md-8 col-lg-9" style="padding: 10px;height: 80vh;overflow: auto;">
                    <?php
                    if (isset($_GET['link'])) {
                        if ($_GET['link']== sha1("logistique_attribution_biens_add")) {
                            include 'logistique/attribution-biens/add_attribution_biens.php';
                        } else if ($_GET['link']== sha1("logistique_attribution_biens_liste_attribution_biens_all")) {
                            include 'logistique/attribution-biens/liste_attribution_biens_all.php';
                        } else if ($_GET['link']== sha1("logistique_attribution_biens_update_attribution_biens_all")) {
                            include 'logistique/attribution-biens/update_attribution_biens_all.php';
                        } else if ($_GET['link']== sha1("logistique_biens_active_biens_all")) {
                            include 'logistique/biens/active_biens_all.php';
                        } else if ($_GET['link']== sha1("logistique_attribution_biens_fiche_attribution_fournisseur_all")) {
                            include 'logistique/attribution-biens/fiche_attribution_fournisseur_all.php';
                        } else if ($_GET['link']== sha1("logistique_attribution_biens_fiche_attribution_fournisseur_self")) {
                            include 'logistique/attribution-biens/fiche_attribution_fournisseur_self.php';
                        } else if ($_GET['link']== sha1("logistique_attribution_biens_liste_attribution_biens_encours_all")) {
                            include 'logistique/attribution-biens/liste_attribution_biens_encours_all.php';
                        } else if ($_GET['link']== sha1("logistique_attribution_biens_fiche_biens_attribution_all")) {
                            include 'logistique/attribution-biens/fiche_biens_attribution_all.php';
                        } else if ($_GET['link']== sha1("logistique_attribution_biens_fiche_biens_attribution_self")) {
                            include 'logistique/attribution-biens/fiche_biens_attribution_self.php';
                        }
                    } else {
                        include 'logistique/attribution-biens/add_attribution_biens.php';
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

