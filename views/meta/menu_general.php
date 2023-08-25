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
    <div class="row w-100 fixed-top bg-primary" style="background-color: #008080;height: 70px;">
        <div class="col-md-3" id="entete1-logo">
            <a href="#" class="text-decoration-none pt-1">
                <?php
                $bdentreprise = new BdEntreprise();
                $entreprises = $bdentreprise->getEntreprise();
                foreach ($entreprises as $entreprise) {
                    ?>
                    <img style="margin: 4px;" height="40px" width="40px" src="../media/pictures-entreprise/<?= $entreprise['url_logo'] ?>">
                    <span class="fw-bolder" style="color: white;font-size: 20px;"><?= $entreprise['designation'] ?></span>
                    <?php
                }
            ?>
            </a>
        </div>
        <div class="col-md-9" id="entete1-button">
            <div class="row text-white"> 
                <div class="col-md-8 col-sm-12 pt-1">
                    <span class="fa fa-unlock" style="font-size: 20px;"></span>
                    <span class="h6">
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
                    <span class="glyphicon glyphicon-chevron-right" style="color: forestgreen; font-size: 10px;margin-top: 10px;"></span>
                    <span class="fa fa-user" style="font-size: 20px;"></span>
                    <span class="h6">
                        <?php
                        if ($type != "membre") {
                            echo $_SESSION['identite'];
                        }
                        ?>
                    </span>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-6 align-center pt-n1">
                            <span class="">
                                <a class="btn btn bg-white text-primary mt-0 fs-6" href="/views/home.php?link=<?= sha1("admin_utilisateur_update_utilisateur_self") ?>&link_up=<?= sha1("home_admin_utilisateur") ?>">
                                    <i class="fa fa-cog fs-6" aria-hidden="true"></i> <span class="fs-6">Parametre</span>
                                </a>
                            </span>
                        </div>
                        <div class="col-md-2 align-center pt-1">
                            <form method="post" action="../contollers/logout/logoutController.php">
                            <span class="p-1">
                                <button type="submit" name="bt_deconnexion" class="btn btn bg-white text-primary mt-0 fs-6">
                                    <i class="fa fa-sign-out" aria-hidden="true"></i>
                                </button>
                            </span>
                            </form>
                        </div>
                        <div class="col-md-2 align-center pt-1">
                            <span class="p-3">
                                <button type="button" class="btn btn bg-white text-primary mt-0 fs-6" id="toggle_menu">
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

