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
<?php
include './meta/menu_logistique.php';
?>
<div class="row" style="padding: 10px;">
    <div class="col-md-12" style="background-color: whitesmoke;border-radius: 5px; height: 90vh;">
        <div class="container-fluid">
            <div class="row">
                <div id="menu-gauche" class="col-lg-2">
                    <ul class="list-menu list-unstyled" style="font-size: 20px;">
                        <li class="list-inline-item"><span style="color: orange;font-size: 20px;" class="glyphicon glyphicon-plus"></span><a href="/views/home.php?link_up=<?= sha1("home_logistique_taux")?>">New</a></li><br>
                        <li class="list-inline-item"><span style="color: red;font-size: 20px;" class="glyphicon glyphicon-list"></span><a href="/views/home.php?link=<?= sha1("logistique_taux_liste_taux_all")?>&link_up=<?= sha1("home_logistique_taux")?>">List</a></li>
                        <li class="list-inline-item">
                            <!-- <span style="color: red;" class="glyphicon glyphicon-time"></span> -->
                            <span style="color: forestgreen;" class="glyphicon glyphicon-ok-circle"></span>
                            <a href="/views/home.php?link=<?= sha1("logistique_taux_active_taux_all")?>&link_up=<?= sha1("home_logistique_taux")?>">Activation</a>
                        </li>
                    </ul>
                </div>
                
                <div class="col-lg-10" style="padding: 10px;height: 80vh;overflow: auto;">
                    <?php
                    if (isset($_GET['link'])) {
                        if ($_GET['link']== sha1("logistique_taux_liste_taux_all")) {
                            include 'logistique/taux/liste_taux_all.php';
                        } else if ($_GET['link']== sha1("logistique_taux_active_taux_all")) {
                            include 'logistique/taux/active_taux_all.php';
                        }
                    } else {
                        include 'logistique/taux/add_taux.php';
                    }
                    
                    ?>
                </div>
            </div>
        </div>
    </div>
    <style>
        
    </style>
</div>

