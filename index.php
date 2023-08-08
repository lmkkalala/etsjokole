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
            <div class="container">
                <div class="row mt-5">
                    <!-- <div class="col-8 contenu"> -->
                    <div class="col-md-6">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-12">
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
                                
                                    if ((isset($_GET['reponse'])) && ($_GET['reponse'] == sha1("remplissage_error"))) {
                                ?>
                                    <div class="alert alert-warning">
                                        <span class="fa fa-pencil-square-o" style="color: darkred;font-size: 20px;"></span>
                                        <span class="h4" style="color: darkred">Erreur de remplissage, Recommencer SVP</span>
                                    </div>
                                <?php
                                    }
                                
                                    if ((isset($_GET['reponse'])) && ($_GET['reponse'] == sha1("logout"))) {
                                ?>
                                    <div class="alert alert-success">
                                        <span class="fa fa-plug" style="color: forestgreen;font-size: 20px;"></span>
                                        <span class="h4" style="color: forestgreen">Vous êtes deconnecté</span>
                                    </div>
                                <?php
                                    }
                                
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
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h1 class="text-center mt-3 text-white">Ets JOKOLE</h1>
                                <p class="text-center text-white">Dieu est GRAND.</p>
                            </div>
                            <div class="col-12">
                                <h4 class="text-center mt-1 text-white">Connexion</h4>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">

                                    </div>
                                    <div class="col-md-6">
                                        <form class="" method="POST" action="contollers/login/loginController.php">
                                            <div class="form-group">
                                                <input style="margin-top: 10vh" type="text" class="form-control form-control-lg w-100" name="tb_nomutilisateur" placeholder="Nom d'utilisteur">
                                                <input style="margin-top: 5vh" type="password" class="form-control form-control-lg w-100" name="tb_motdepasse" placeholder="Mot de passe">
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
                    <div class="col-md-6 p-4 bg-white shadow rounded-end-4 mt-3">
                        <div class="row d-flex justify-content-center">
                            <h4 class="text-start text-danger"> <i class="fa fa-question-circle fs-1"></i> A PROPOS NOUS</h4>
                            <div class="col-md-7">
                                <p class="text-start">Nous sommes un etablissement de vente et approvisonnement des produits de premiere necessite, nous effectuons la distribution des articles comme le sucre, le farine de fromant, de l'huile, et bien d'autres produits diverts.</p>
                            </div>
                            <div class="col-md-5">
                                    <h3 class="text-danger text-end">CONCTATS</h3>
                                <ul class="list-unstyled">
                                    <li><i class="fa fa-phone"> <a href="tel:+243996848331" class="text-decoration-none text-black">+243 996 848 331</a></i></li>
                                    <li><i class="fa fa-envelope-o"> <a href="mailto:contact@etsjokole.com" class="text-decoration-none text-black">contact@etsjokole.com</a></i></li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                            <img src="media/pictures-system/rice.avif" class="img-responsive" width="150" alt="">
                            </div>
                            <div class="col-md-6">
                                <img src="media/pictures-system/truck2.jpg" class="img-responsive" width="200" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>
    <?php
    include './views/meta/metabottom.php';
    ?>
</html>



