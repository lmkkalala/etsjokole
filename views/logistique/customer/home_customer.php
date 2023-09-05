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
                        <li class="list-inline-item">
                            <span style="color: red;font-size: 20px;" class="fa fa-asterisk"></span>
                            <a href="/views/home.php?link_up=<?= sha1('home_logistique_customer'); ?>">Nouveau</a>
                        </li><br>
                        <li class="list-inline-item">
                            <span style="color: dodgerblue;font-size: 20px;" class="glyphicon glyphicon-list"></span>
                            <a href="/views/home.php?link=<?= sha1('logistique_customer_liste_all'); ?>&link_up=<?= sha1('home_logistique_customer'); ?>">Liste</a>
                        </li>
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
                        if ($_GET['link'] == sha1('logistique_customer_liste_all')) {
                            include 'logistique/customer/liste_customer_all.php';
                        }
                        if ($_GET['link'] == sha1('logistique_customer_update_self')) {
                            include 'logistique/customer/liste_customer_all.php';
                        }
                        
                        // if ($_GET['link'] == sha1('logistique_customer_statistics')) {
                        //     include 'logistique/customer/statistics_addsin.php';
                        // }
                    } else {
                        include 'logistique/customer/add_customer.php';
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

