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
<style>
    #text-dark-moderated{
        color: #000e1f;
    }
</style>
<div class="container-fluid d-none d-md-block" style="margin-bottom: 10%;">
    <div class="row w-100 fixed-top mt-1" style="height: 70px; background-color: #000e1f;">
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
                <div class="col-md-8 pt-1">
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
                        <div class="col-md-2 pt-1">
                            <span class="mx-1">
                                <a class="btn btn bg-white text-dark-moderated" style="color: #000e1f;" href="/views/home.php?link=<?= sha1("admin_utilisateur_update_utilisateur_self") ?>&link_up=<?= sha1("home_admin_utilisateur") ?>">
                                    <i class="fa fa-cog fs-5" aria-hidden="true"></i>
                                </a>
                            </span>
                        </div>
                        <div class="col-md-2 pt-1">
                            <span class="mx-2">
                                <a class="btn btn bg-white text-dark-moderated" style="color: #000e1f;" href="/views/home.php?link=<?= sha1("logistique_ravitaillement_liste_expired_fast")?>&link_up=<?= sha1("home_logistique_ravitaillement") ?>">
                                    <i class="fa fa-bell fs-5" aria-hidden="true"></i>
                                </a>
                            </span>
                        </div>
                        <div class="col-md-2 pt-1">
                            <form method="post" action="../contollers/logout/logoutController.php">
                            <span class="mx-3">
                                <button type="submit" name="bt_deconnexion" class="btn btn bg-white text-dark-moderated" style="color: #000e1f;">
                                    <i class="fa fa-sign-out fs-5" aria-hidden="true"></i>
                                </button>
                            </span>
                            </form>
                        </div>
                        <div class="col-md-2 pt-1">
                            <span class="mx-4">
                                <button type="button" class="btn btn bg-white text-dark-moderated" id="toggle_menu" style="color: #000e1f;">
                                    <i class="fa fa-list fs-5"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>   
            </div>
        </div>
    </div>
</div>

