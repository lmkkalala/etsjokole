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
                <div class="col-lg-12" style="height: 80vh;overflow: auto;">
                    <div class="row">
                        <legend class="text-secondary fw-bolder"> SORTIE</legend>
                        <div class="col-md-4 mt-1">
                            <a class="btn btn-secondary" style="font-size: 30px; padding: 30px;" href="/views/home.php?link_up=<?= sha1("home_logistique_demande") ?>"><span style="font-size: 70px; margin: 20px;" class="fa fa-bell-o"></span>Requisition</a>
                        </div>
                        <div class="col-md-4 mt-1">
                            <a class="btn btn-secondary" style="font-size: 30px; padding: 30px;" href="/views/home.php?link_up=<?= sha1("home_logistique_livraison") ?>"><span style="font-size: 70px; margin: 20px;" class="fa fa-support"></span>Livraison</a>
                        </div>
                    </div>
                    <?php
                    
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

