<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php
include './meta/menu_admin.php';
?>
<div class="row" style="padding: 10px;">
    <div class="col-md-12" style="background-color: whitesmoke;border-radius: 5px; height: 90vh;">
        <div class="container-fluid">
            <div class="row">
                <div id="menu-gauche" class="col-lg-3">
                    <ul class="list-menu list-unstyled" style="font-size: 20px;">
                        <li class="list-inline-item"><span style="color: red;font-size: 20px;" class="glyphicon glyphicon-asterisk"></span><a href="/openstock/views/home.php?link=<?= sha1("admin_composanteimposition_add")?>&link_up=<?= sha1("home_admin_composanteimposition")?>">New</a></li>
                        <li class="list-inline-item"><span style="color: forestgreen;font-size: 20px;" class="glyphicon glyphicon-adjust"></span><a href="/openstock/views/home.php?link=<?= sha1("admin_composanteimposition_update_composanteimposition_all")?>&link_up=<?= sha1("home_admin_composanteimpositione")?>">Update</a></li>
                        <li class="list-inline-item"><span style="color: darkslategrey;font-size: 20px;" class="glyphicon glyphicon-check"></span><a href="/openstock/views/home.php?link=<?= sha1("admin_composanteimposition_active_composanteimposition_all")?>&link_up=<?= sha1("home_admin_composanteimposition")?>">Activation</a></li>
                        <li class="list-inline-item"><span style="color: orange;font-size: 20px;" class="glyphicon glyphicon-list"></span><a href="/openstock/views/home.php?link=<?= sha1("admin_composanteimposition_liste_composanteimposition_all")?>&link_up=<?= sha1("home_admin_composanteimposition")?>">List</a></li>
                    </ul>
                    <hr>
                    <h3>Configuration des contributions</h3>
                    <ul class="list-menu list-unstyled" style="font-size: 20px;">
                        <li class="list-inline-item"><span style="color: red;font-size: 20px;" class="glyphicon glyphicon-asterisk"></span><a href="/openstock/views/home.php?link=<?= sha1("admin_confimposition_add")?>&link_up=<?= sha1("home_admin_composanteimposition")?>">New</a></li>
                        <li class="list-inline-item"><span style="color: forestgreen;font-size: 20px;" class="glyphicon glyphicon-adjust"></span><a href="/openstock/views/home.php?link=<?= sha1("admin_confimposition_update_confimposition_all")?>&link_up=<?= sha1("home_admin_composanteimposition")?>">Update</a></li>
                        <li class="list-inline-item"><span style="color: darkslategrey;font-size: 20px;" class="glyphicon glyphicon-check"></span><a href="/openstock/views/home.php?link=<?= sha1("admin_confimposition_active_confimposition_all")?>&link_up=<?= sha1("home_admin_composanteimposition")?>">Activation</a></li>
                        <li class="list-inline-item"><span style="color: orange;font-size: 20px;" class="glyphicon glyphicon-list"></span><a href="/openstock/views/home.php?link=<?= sha1("admin_confimposition_liste_confimposition_all")?>&link_up=<?= sha1("home_admin_composanteimposition")?>">List</a></li>
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
                        if ($_GET['link']== sha1("admin_composanteimposition_add")) {
                            include 'administrator/composante-imposition/add_composanteimposition.php';
                        } else if ($_GET['link']== sha1("admin_composanteimposition_liste_composanteimposition_all")) {
                            include 'administrator/composante-imposition/liste_composanteimposition_all.php';
                        } else if ($_GET['link']== sha1("admin_composanteimposition_update_composanteimposition_all")) {
                            include 'administrator/composante-imposition/update_composanteimposition_all.php';
                        } else if ($_GET['link']== sha1("admin_composanteimposition_active_composanteimposition_all")) {
                            include 'administrator/composante-imposition/active_composanteimposition_all.php';
                        }
                        
                        if ($_GET['link']== sha1("admin_confimposition_add")) {
                            include 'administrator/composante-imposition/add_confimposition.php';
                        } else if ($_GET['link']== sha1("admin_confimposition_liste_confimposition_all")) {
                            include 'administrator/composante-imposition/liste_confimposition_all.php';
                        } else if ($_GET['link']== sha1("admin_confimposition_update_confimposition_all")) {
                            include 'administrator/composante-imposition/update_confimposition_all.php';
                        } else if ($_GET['link']== sha1("admin_confimposition_active_confimposition_all")) {
                            include 'administrator/composante-imposition/active_confimposition_all.php';
                        }
                    } else {
                        include 'administrator/composante-imposition/add_composanteimposition.php';
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

