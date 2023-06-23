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
                <div class="col-lg-12" style="padding: 10px;height: 80vh;overflow: auto;">
                    <?php
                    if (isset($_GET['link'])) {
                        if ($_GET['link']== sha1("admin_affectation_service_add")) {
                            include 'administrator/affectation-service/add_affectation_service.php';
                        } else if ($_GET['link']== sha1("admin_affectation_service_liste_affectation_service_all")) {
                            include 'administrator/affectation-service/liste_affectation_service_all.php';
                        } else if ($_GET['link']== sha1("admin_affectation_service_update_affectation_service_all")) {
                            include 'administrator/affectation-service/update_affectation_service_all.php';
                        } else if ($_GET['link']== sha1("admin_affectation_service_active_affectation_service_all")) {
                            include 'administrator/affectation-service/active_affectation_service_all.php';
                        } else if ($_GET['link']== sha1("admin_affectation_service_fiche_affectation_service_all")) {
                            include 'administrator/affectation-service/fiche_affectation_service_all.php';
                        }  else if ($_GET['link']== sha1("admin_affectation_service_fiche_affectation_service_self")) {
                            include 'administrator/affectation-service/fiche_affectation_service_self.php';
                        }
                    } else {
                        include 'administrator/acceuil/dashboard_acceuil.php';
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

