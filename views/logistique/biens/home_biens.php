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
<div class="row" style="padding: 10px;">
    <div class="col-md-12" style="background-color: whitesmoke;border-radius: 5px; height: 90vh;">
        <div class="container-fluid">
            <div class="row">
                <div id="menu-gauche" class="col-lg-3">
                    <h3>Item</h3>
                    <ul class="list-menu list-unstyled" style="font-size: 20px;">
                        <li class="list-inline-item"><span style="color: red;font-size: 20px;" class="glyphicon glyphicon-asterisk"></span><a href="/views/home.php?link=<?= sha1("logistique_biens_add")?>&link_up=<?= sha1("home_logistique_biens")?>">New</a></li>
                        <li class="list-inline-item"><span style="color: forestgreen;font-size: 20px;" class="glyphicon glyphicon-adjust"></span><a href="/views/home.php?link=<?= sha1("logistique_biens_update_biens_all")?>&link_up=<?= sha1("home_logistique_biens")?>">Update</a></li>
                        <li class="list-inline-item"><span style="color: darkslategrey;font-size: 20px;" class="glyphicon glyphicon-check"></span><a href="/views/home.php?link=<?= sha1("logistique_biens_active_biens_all")?>&link_up=<?= sha1("home_logistique_biens")?>">Activation</a></li>
                        <li class="list-inline-item"><span style="color: orange;font-size: 20px;" class="glyphicon glyphicon-list"></span><a href="/views/home.php?link=<?= sha1("logistique_biens_liste_biens_all")?>&link_up=<?= sha1("home_logistique_biens")?>">List</a></li>
                        <li class="list-inline-item"><span style="color: dodgerblue;font-size: 20px;" class="glyphicon glyphicon-list"></span><a href="/views/home.php?link=<?= sha1("logistique_biens_liste_biens_value_all")?>&link_up=<?= sha1("home_logistique_biens")?>">Store inventory</a></li>
                        <li class="list-inline-item"><span style="color: tomato;font-size: 20px;" class="glyphicon glyphicon-edit"></span><a href="/views/home.php?link=<?= sha1("logistique_biens_fiche_biens_all")?>&link_up=<?= sha1("home_logistique_biens")?>">View</a></li>
                    </ul>
                    <hr>
                    <h3>Physical inventory</h3>
                    <ul class="list-menu list-unstyled" style="font-size: 20px;">
                        <li class="list-inline-item"><span style="color: red;font-size: 20px;" class="glyphicon glyphicon-asterisk"></span><a href="/views/home.php?link=<?= sha1("logistique_inventaire_fiche_biens_inventaire_all")?>&link_up=<?= sha1("home_logistique_biens")?>">Nouveau inventaire</a></li>
                        <li class="list-inline-item"><span style="color: orange;font-size: 20px;" class="glyphicon glyphicon-list"></span><a href="/views/home.php?link=<?= sha1("logistique_inventaire_liste_inventaire_all")?>&link_up=<?= sha1("home_logistique_biens")?>">Liste de tous les inventaires</a></li>
                        <li class="list-inline-item"><span style="color: darkslategray;font-size: 20px;" class="glyphicon glyphicon-list"></span><span style="color: darkslategray;font-size: 20px;" class="fa fa-gift"></span><a href="/views/home.php?link=<?= sha1("logistique_inventaire_fiche_biens_inventaire_all_fiche")?>&link_up=<?= sha1("home_logistique_biens")?>">Fiche des inventaires par biens/produit</a></li>
                    </ul>
                </div>

                <div id="main_container" class="col-lg-9" style="padding: 10px;height: 80vh;overflow: auto;">
                    
                    <?php
                    if (isset($_GET['link'])) {
                        if ($_GET['link']== sha1("logistique_biens_add")) {
                            include 'logistique/biens/add_biens.php';
                        } else if ($_GET['link']== sha1("logistique_biens_liste_biens_all")) {
                            include 'logistique/biens/liste_biens_all.php';
                        } else if ($_GET['link']== sha1("logistique_biens_liste_biens_value_all")) {
                            include 'logistique/biens/liste_biens_value_all.php';
                        } else if ($_GET['link']== sha1("logistique_biens_update_biens_all")) {
                            include 'logistique/biens/update_biens_all.php';
                        } else if ($_GET['link']== sha1("logistique_biens_active_biens_all")) {
                            include 'logistique/biens/active_biens_all.php';
                        } else if ($_GET['link']== sha1("logistique_biens_fiche_biens_all")) {
                            include 'logistique/biens/fiche_biens_all.php';
                        } else if ($_GET['link']== sha1("logistique_biens_fiche_biens_self")) {
                            include 'logistique/biens/fiche_biens_self.php';
                        } else if ($_GET['link']== sha1("logistique_inventaire_fiche_biens_inventaire_all")) {
                            include 'logistique/inventaire/fiche_biens_inventaire_all.php';
                        } else if ($_GET['link']== sha1("logistique_inventaire_liste_inventaire_all")) {
                            include 'logistique/inventaire/liste_inventaire_all.php';
                        } else if ($_GET['link']== sha1("logistique_inventaire_add")) {
                            include 'logistique/inventaire/add_inventaire.php';
                        } else if ($_GET['link']== sha1("logistique_inventaire_fiche_biens_inventaire_all_fiche")) {
                            include 'logistique/inventaire/fiche_biens_inventaire_all_fiche.php';
                        } else if ($_GET['link']== sha1("logistique_inventaire_fiche_biens_inventaire_self")) {
                            include 'logistique/inventaire/fiche_biens_inventaire_self.php';
                        }
                    } else {
                        include 'logistique/biens/add_biens.php';
                    }
                    
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

