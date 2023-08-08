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
                        <li class="list-inline-item"><span style="color: red;font-size: 20px;" class="glyphicon glyphicon-asterisk"></span><a href="/views/home.php?link=<?= sha1("logistique_ravitaillement_add")?>&link_up=<?= sha1("home_logistique_ravitaillement")?>">New</a></li><br>
                        <li class="list-inline-item"><span style="color: orange;font-size: 20px;" class="glyphicon glyphicon-list"></span><a href="/views/home.php?link=<?= sha1("logistique_ravitaillement_liste_ravitaillement_all")?>&link_up=<?= sha1("home_logistique_ravitaillement")?>">All receipts</a></li>
                        <li class="list-inline-item"><span style="color: tomato;font-size: 20px;" class="glyphicon glyphicon-user"></span><span style="color: tomato;font-size: 20px;" class="glyphicon glyphicon-edit"></span><a href="/views/home.php?link=<?= sha1("logistique_ravitaillement_fiche_ravitaillement_fournisseur_all")?>&link_up=<?= sha1("home_logistique_ravitaillement")?>">Receipts per supplier</a></li>
                        <li class="list-inline-item"><span style="color: #0069d9;font-size: 20px;" class="fa fa-list-alt"></span><a href="/views/home.php?link=<?= sha1("logistique_ravitaillement_fiche_biens_ravitaillement_all")?>&link_up=<?= sha1("home_logistique_ravitaillement")?>">Receipts per item</a></li>
                        <li class="list-inline-item" style="color: red;"><span style="color: red;font-size: 20px;" class="fa fa-tachometer"></span><a style="color:red;" href="/views/home.php?link=<?= sha1("logistique_ravitaillement_liste_expired_fast")?>&link_up=<?= sha1("home_logistique_ravitaillement")?>">Expired Alert</a></li>
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
                        if ($_GET['link']== sha1("logistique_ravitaillement_add")) {
                            include 'logistique/ravitaillement/add_ravitaillement.php';
                        } else if ($_GET['link']== sha1("logistique_ravitaillement_liste_ravitaillement_all")) {
                            include 'logistique/ravitaillement/liste_ravitaillement_all.php';
                        } else if ($_GET['link']== sha1("logistique_ravitaillement_fiche_ravitaillement_fournisseur_all")) {
                            include 'logistique/ravitaillement/fiche_ravitaillement_fournisseur_all.php';
                        } else if ($_GET['link']== sha1("logistique_ravitaillement_fiche_ravitaillement_fournisseur_self")) {
                            include 'logistique/ravitaillement/fiche_ravitaillement_fournisseur_self.php';
                        } else if ($_GET['link']== sha1("logistique_ravitaillement_fiche_biens_ravitaillement_all")) {
                            include 'logistique/ravitaillement/fiche_biens_ravitaillement_all.php';
                        } else if ($_GET['link']== sha1("logistique_ravitaillement_fiche_biens_ravitaillement_self")) {
                            include 'logistique/ravitaillement/fiche_biens_ravitaillement_self.php';
                        } else if ($_GET['link']== sha1("logistique_attribution_biens_liste_attribution_biens_encours_all")) {
                            include 'logistique/attribution-biens/liste_attribution_biens_encours_all.php';
                        } else if ($_GET['link']== sha1("logistique_attribution_biens_fiche_biens_attribution_all")) {
                            include 'logistique/attribution-biens/fiche_biens_attribution_all.php';
                        } else if ($_GET['link']== sha1("logistique_attribution_biens_fiche_biens_attribution_self")) {
                            include 'logistique/attribution-biens/fiche_biens_attribution_self.php';
                        } else if ($_GET['link']== sha1("logistique_ravitaillement_liste_unite_ravitaillement")) {
                            include 'logistique/ravitaillement/liste_unite_ravitaillement.php';
                        } else if ($_GET['link']== sha1("logistique_ravitaillement_liste_expired_fast")) {
                            include 'logistique/ravitaillement/liste_ravitaillement_fast_expired.php';
                        }
                    } else {
                        include 'logistique/ravitaillement/add_ravitaillement.php';
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

