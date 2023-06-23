<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        include './views/meta/metatop.php';
        if(isset($_SESSION['idutilisateur'])){
            if ($_SESSION['idutilisateur'] != '') {
                header('Location: contollers/login/loginController.php');
            }
        }
        ?>
        <title>
            Ets JOKOLE
        </title>
    </head>
    <body id="index">
        <section id="principalcover">
            <div class="container-fluid">
                <!-- <div class="row">
                    <div class="col-lg-12 spacetop">
                    </div>
                </div> -->
                <div class="row d-flex justify-content-center mt-5">
                    <!-- <div class="col-8 contenu"> -->
                    <div class="col-8">
                        <div class="row" style="color: white">
                            <?php
                            if ((isset($_GET['reponse'])) && ($_GET['reponse'] == sha1("nomutilisateur_error"))) {
                                ?>
                                <div class="alert alert-danger">
                                    <span class="fa fa-user-times" style="color: darkred;font-size: 20px;"></span>
                                    <span class="h4" style="color: darkred">Nom d'utilisateur ou mot de passe incorrects</span>
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                            if ((isset($_GET['reponse'])) && ($_GET['reponse'] == sha1("motdepasse_error"))) {
                                ?>
                                <div class="alert alert-danger">
                                    <span class="fa fa-won" style="color: darkred;font-size: 20px;"></span>
                                    <span class="h4" style="color: darkred">Mot de passe incorrect</span>
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                            if ((isset($_GET['reponse'])) && ($_GET['reponse'] == sha1("remplissage_error"))) {
                                ?>
                                <div class="alert alert-warning">
                                    <span class="fa fa-pencil-square-o" style="color: darkred;font-size: 20px;"></span>
                                    <span class="h4" style="color: darkred">Erreur de remplissage, Recommencer SVP</span>
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                            if ((isset($_GET['reponse'])) && ($_GET['reponse'] == sha1("logout"))) {
                                ?>
                                <div class="alert alert-success">
                                    <span class="fa fa-plug" style="color: forestgreen;font-size: 20px;"></span>
                                    <span class="h4" style="color: forestgreen">Vous êtes deconnecté</span>
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                            if ((isset($_GET['reponse'])) && ($_GET['reponse'] == sha1("activation_error"))) {
                                ?>
                                <div class="alert alert-info">
                                    <span class="fa fa-lock" style="color: #0069d9;font-size: 20px;"></span>
                                    <span class="h4" style="color: #0069d9">Ce compte est désactivé, Contactez l'administrateur du système</span>
                                </div>
                                <?php
                            }
                            ?>
                            
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h3 class="text-center mt-3 text-white">Ets JOKOLE</h3>
                            </div>
                            <div class="col-12">
                                <h4 class="text-center mt-3 text-white">Connexion</h4>
                            </div>
                        </div>
                        <div class="row" style="text-align: center">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">

                                    </div>
                                    <div class="col-md-6">
                                        <form class="" method="POST" action="contollers/login/loginController.php">
                                            <div class="form-group">
                                                <input style="margin-top: 10vh" type="text" class="form-control form-control-lg" name="tb_nomutilisateur" placeholder="Nom d'utilisteur">
                                                <input style="margin-top: 5vh" type="password" class="form-control form-control-lg" name="tb_motdepasse" placeholder="Mot de passe">
                                                <input style="margin-top: 5vh" type="submit" class="btn btn-success btn-lg w-100" name="bt_connexion" value="Valider">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-3">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class=" col-lg-12 spacebottom" style="color: white;">
                    </div>
                </div>
            </div>
        </section>
    </body>
    <?php
    include './views/meta/metabottom.php';
    ?>
</html>



