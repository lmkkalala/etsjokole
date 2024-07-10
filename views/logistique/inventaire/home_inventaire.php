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
                <div class="col-md-12" style="height: 80vh;overflow: auto;">
                    <h1 class="text-secondary fw-bolder">INVENTAIRE</h1>  
                    <div class="row">
                        <div class="col-md-6 mt-2">
                            <a class="btn btn-secondary w-100" style="font-size: 30px; padding: 40px;" href="/views/home.php?link_up=<?= sha1("home_logistique_categorie") ?>">
                            <span style="font-size: 70px; margin: 20px;" class="fa fa-database"></span>Catégorie</a>
                        </div>
                        <div class="col-md-6 mt-2">
                            <a class="btn btn-secondary w-100" style="font-size: 30px; padding: 40px;" href="/views/home.php?link_up=<?= sha1("home_logistique_biens") ?>">
                            <span style="font-size: 70px; margin: 20px;" class="fa fa-cube"></span>Produit</a>
                        </div>
                    </div>
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

