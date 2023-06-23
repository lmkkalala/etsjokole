<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php
include './meta/menu_service.php';
?>
<div class="row" style="padding: 10px;">
    <div class="col-md-12" style="background-color: whitesmoke;border-radius: 5px; height: 90vh;">
        <div class="container-fluid">
            <div class="row">
                <div id="menu-gauche" class="col-lg-3">
                    <ul class="list-menu list-unstyled" style="font-size: 20px;">
                        <li class="list-inline-item"><span style="color: orange;font-size: 20px;" class="glyphicon glyphicon-list"></span><span style="color: orange;font-size: 20px;" class="fa fa-share-alt"></span><a href="/views/home.php?link=<?= sha1("service_reception_liste_reception_all") ?>&link_up=<?= sha1("home_service_reception") ?>">Report</a></li>
                        <li class="list-inline-item"><span style="color: darkslategray;font-size: 20px;" class="fa fa-file-text"></span><span style="color: darkslategray;font-size: 20px;" class="fa fa-share-alt"></span><a href="/views/home.php?link=<?= sha1("service_reception_fiche_biens_reception_all") ?>&link_up=<?= sha1("home_service_reception") ?>">Lister Par Item</a></li>
                        <li class="list-inline-item"><span style="color: orange;font-size: 20px;" class="fa fa-file-o"></span><a href="/views/home.php?link=<?= sha1("service_reception_inventory") ?>&link_up=<?= sha1("home_service_reception") ?>">Inventoraire</a></li>
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
                        if ($_GET['link'] == sha1("service_reception_liste_reception_all")) {
                            include 'service/reception/liste_reception_all.php';
                        } else if ($_GET['link'] == sha1("service_reception_fiche_biens_reception_all")) {
                            include 'service/reception/fiche_biens_reception_all.php';
                        } else if ($_GET['link'] == sha1("service_reception_fiche_biens_reception_self")) {
                            include 'service/reception/fiche_biens_reception_self.php';
                        } else if ($_GET['link'] == sha1("service_demande_fiche_biens_demande_all")) {
                            include 'service/demande/fiche_biens_demande_all.php';
                        } else if ($_GET['link'] == sha1("service_demande_fiche_biens_demande_self")) {
                            include 'service/demande/fiche_biens_demande_self.php';
                        } else if ($_GET['link'] == sha1("service_reception_inventory")) {
                            include 'service/reception/reception_inventory.php';
                        }
                    } else {
                        include 'service/reception/liste_reception_all.php';
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

