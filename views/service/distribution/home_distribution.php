<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ($_SESSION['type'] == 'logistique') {
    include './meta/menu_logistique.php';
}else{
    include './meta/menu_service.php';
}

?>
<div class="row" style="padding: 10px;">
    <div class="col-md-12" style="background-color: whitesmoke;border-radius: 5px; height: 90vh;">
        <div class="container-fluid">
            <div class="row">
                <div id="menu-gauche" class="col-lg-3">
                    <ul class="list-menu list-unstyled" style="font-size: 20px;">
                        <li class="list-inline-item"><span style="color: red;font-size: 20px;" class="glyphicon glyphicon-asterisk"></span><a href="/views/home.php?link=<?= sha1("service_distribution_add")?>&link_up=<?= sha1("home_service_distribution")?>">Ajout vente</a></li>
                        <li class="list-inline-item"><span style="color: orange;font-size: 20px;" class="glyphicon glyphicon-list"></span><a href="/views/home.php?link=<?= sha1("service_distribution_liste_distribution_all")?>&link_up=<?= sha1("home_service_distribution")?>">Rapport vente</a></li>
                        <li class="list-inline-item"><span style="color: darkslategray;font-size: 20px;" class="fa fa-gift"></span><span style="color: darkslategray;font-size: 20px;" class="fa fa-file-text"></span><a href="/views/home.php?link=<?= sha1("service_distribution_fiche_biens_distribution_all")?>&link_up=<?= sha1("home_service_distribution")?>">Fiche de ventes par biens/produit</a></li>
                        <li class="list-inline-item"><span style="color: #0069d9;font-size: 20px;" class="fa fa-user"></span><span style="color: #0069d9;font-size: 20px;" class="fa fa-file-text"></span><a href="/views/home.php?link=<?= sha1("service_distribution_fiche_agent_distribution_all")?>&link_up=<?= sha1("home_service_distribution")?>">Fiche de ventes par agent</a></li>
                        <li class="list-inline-item"><span style="color: #0069d9;font-size: 20px;" class="fa fa-file-text"></span><a href="/views/home.php?link=<?= sha1("service_distribution_fiche_agent_distribution_retirer")?>&link_up=<?= sha1("home_service_distribution")?>">Fiche des ventes à retirer</a></li>
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
                        if ($_GET['link']== sha1("service_distribution_add")) {
                            include 'service/distribution/add_distribution.php';
                        } else if ($_GET['link']== sha1("service_distribution_liste_distribution_all")) {
                            include 'service/distribution/liste_distribution_all.php';
                        } else if ($_GET['link']== sha1("service_distribution_liste_distribution_partielle")) {
                            include 'service/distribution/liste_distribution_partielle.php';
                        } else if ($_GET['link']== sha1("service_distribution_liste_distribution_totale")) {
                            include 'service/distribution/liste_distribution_totale.php';
                        } else if ($_GET['link']== sha1("service_distribution_fiche_biens_distribution_all")) {
                            include 'service/distribution/fiche_biens_distribution_all.php';
                        } else if ($_GET['link']== sha1("service_distribution_fiche_biens_distribution_self")) {
                            include 'service/distribution/fiche_biens_distribution_self.php';
                        } else if ($_GET['link']== sha1("service_distribution_fiche_agent_distribution_all")) {
                            include 'service/distribution/fiche_agent_distribution_all.php';
                        } else if ($_GET['link']== sha1("service_distribution_fiche_agent_distribution_self")) {
                            include 'service/distribution/fiche_agent_distribution_self.php';
                        } else if ($_GET['link']== sha1("service_distribution_panier_distribution_add")) {
                            include 'service/distribution/add_panier_distribution.php';
                        } else if ($_GET['link']== sha1("fiche_biens_vente")) {
                            include 'service/distribution/fiche_biens_vente.php';
                        } else if ($_GET['link']== sha1("service_distribution_fiche_agent_distribution_retirer")) {
                            include 'service/distribution/fiche_agent_distribution_retirer.php';
                        }
                    } else {
                        include 'service/distribution/add_distribution.php';
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

