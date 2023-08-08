<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/connexion.php';
include '../models/connexionM.php';
include '../models/entreprise/entreprise.php';
?>
<div class="container-fluid d-none d-md-block" style="margin-bottom: 10%;">
    <div class="row w-100 fixed-top bg-primary" style="background-color: #008080;height: auto;">
        <!-- <div id="entete1-logo" class="col-lg-3">
            <span class="fa fa-cube" style="color: white; font-size: 50px;margin: 10px;"></span>
            <a href="#"><h2>InStock</h2></a>
        </div> -->
        <div class="col-md-3" id="entete1-logo">
            <a href="#" class="btn btn-none shadow-none">
                <?php
                $bdentreprise = new BdEntreprise();
                $entreprises = $bdentreprise->getEntreprise();
                foreach ($entreprises as $entreprise) {
                    ?>
                    <img style="margin: 4px;" height="50px" width="50px" src="../media/pictures-entreprise/<?= $entreprise['url_logo'] ?>">
                    <span class="fw-bolder" style="color: white;font-size: 20px;"><?= $entreprise['designation'] ?></span>
                    <?php
                }
            ?>
            </a>
        </div>
        <div class="col-md-9" id="entete1-button">
            <div class="row text-white"> 
                <div class="col-md-8 col-sm-12 mt-1">
                    <span class="fa fa-unlock" style="font-size: 30px;"></span>
                    <span class="h5">
                        <?php
                        $type = $_SESSION['type'];
                        
                        if ($type == "admin") {
                            echo 'Administrateur du système';
                        } else if ($type === "logistique") {
                            echo 'Stock';
                        } else if ($type == "Administration") {
                            echo 'Administration';
                        } else if ($type == "other") {
                            echo $_SESSION['service'];
                        } else if ($type == "personnel") {
                            echo 'Direction du personnel';
                        } else if ($type == "membre") {
                            echo "";
                        } else if ($type == "administration") {
                            echo "Finance";
                        } else if ($type == "hr_mb") {
                            echo "HR";
                        }
                        ?>
                    </span>
                    <span class="glyphicon glyphicon-chevron-right" style="color: forestgreen; font-size: 10px;margin: 10px;"></span>
                    <span class="fa fa-user" style="font-size: 30px;"></span>
                    <span class="h5">
                        <?php
                        if ($type != "membre") {
                            echo $_SESSION['identite'];
                        }
                        ?>
                    </span>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 align-center">
                            <span class="mx-2">
                                <a class="btn btn bg-white text-primary mt-1" href="/views/home.php?link=<?= sha1("admin_utilisateur_update_utilisateur_self") ?>&link_up=<?= sha1("home_admin_utilisateur") ?>">
                                    <i class="fa fa-cog" aria-hidden="true"></i> Parametre
                                </a>
                            </span>
                        </div>
                        <div class="col-md-2 col-sm-12 align-center">
                            <form method="post" action="../contollers/logout/logoutController.php">
                            <span class="mx-2">
                                <button type="submit" name="bt_deconnexion" class="btn btn bg-white text-primary mt-1 fs-5">
                                    <i class="fa fa-sign-out" aria-hidden="true"></i>
                                </button>
                            </span>
                            </form>
                        </div>
                        <div class="col-md-2 col-sm-12 align-center">
                        <span class="mx-2">
                            <button type="button" class="btn btn bg-white text-primary mt-1 fs-5" id="toggle_menu">
                                <i class="fa fa-list"></i>
                            </button>
                        </span>
                        </div>
                    </div>
                </div>   
            </div>
        </div>
    </div>
</div>

