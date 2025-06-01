<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php
    if ($_SESSION['type']=="logistique") {
        include './meta/menu_logistique.php';
    }else{
        include './meta/menu_service.php';
    }
    
?>
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
<div class="row" style="padding: 10px;">
    <div class="col-md-12" style="background-color: whitesmoke;border-radius: 5px; height: 90vh;">
        <div class="container-fluid">
            <div class="row">
                <div id="menu-gauche" class="col-md-2">
                    <ul class="list-menu list-unstyled" style="font-size: 20px;">
                        <li class="list-inline-item"><span style="color: orange;font-size: 20px;" class="glyphicon glyphicon-list"></span>
                        <a href="/views/home.php?link=<?= sha1("service_liste_annulation_all")?>&link_up=<?= sha1("home_service_annulation")?>">Liste</a></li>
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
                <div id="main_container" class="col-md-10" style="padding: 10px;height: 80vh;overflow: auto;">
                    <?php
                    if (isset($_GET['link'])) {
                        if ($_GET['link']== sha1("service_liste_annulation_all")) {
                            include 'list_annulation_vente.php';
                        }
                    }else{
                        include 'list_annulation_vente.php';
                    }
                    
                    ?>
                </div>
            </div>
        </div>
    </div>
    
</div>

