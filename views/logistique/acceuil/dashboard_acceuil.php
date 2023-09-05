<?php
/*
 * To change this license $lien = , choose License $lien = s in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/agent/agent.php';
include '../models/service/service.php';
include '../models/affectation-service/affectationService.php';
include '../models/utilisateur/utilisateur.php';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-line-chart" style="color: forestgreen; font-size: 50px;margin-right: 5px;"></span><span class="h3">Tableau de bord</span>
        <span class="pull-right" style="color: red; font-size: 30px;margin-right: 0px;">*</span>
        <span class="pull-right"><a class="btn btn text-primary" href="/views/home.php?link=<?= sha1("logistique_ravitaillement_liste_expired_fast")?>&link_up=<?= sha1("home_logistique_ravitaillement") ?>"><span class="fa fa-bell-o" style="color: black; font-size: 30px;"></span></a></span>
        <span class="fa fa-comments-o pull-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-envelope-o pull-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
    </div>
    <div class="panel panel-body">
        <div>
            <table class="table table-condensed table-responsive">
                <tr>
                    <td>
                        <table class="table table-bordered table-responsive">
                            <thead>
                            <span class="fa fa-gift" style="color: #0069d9; font-size: 60px;margin: 10px;"></span><span class="h3">Les biens/produits</span>
                            </thead>
                            <tbody style="background-color: #0069d9;color: white">
                            <td>
                                <div>
                                    <table class="table table-responsive">
                                        <tr>
                                            <td>
                                                <p>Nombre total :</p>  
                                            </td>
                                            <td style="color: #0069d9">
                                                <b>
                                                    <?php
                                                    
                                                    ?>
                                                </b>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                            </tbody>
                        </table>
                    </td>
                    <td>
                        <table class="table table-bordered table-responsive">
                            <thead>
                            <span class="fa fa-database" style="color: red; font-size: 60px;margin: 10px;"></span><span class="h3">Les catégories</span>
                            </thead>
                            <tbody style="background-color: red;color: white">
                            <td>
                                <div>
                                    <table class="table table-responsive">
                                        <tr>
                                            <td>
                                                <p>Nombre total :</p>  
                                            </td>
                                            <td style="color: red">
                                                <b>
                                                    <?php
                                                    
                                                    ?>
                                                </b>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="table table-bordered table-responsive">
                            <thead>
                            <span class="fa fa-shopping-cart" style="color: orange; font-size: 60px;margin: 10px;"></span><span class="h3">Les commandes</span>
                            </thead>
                            <tbody style="background-color: orange;color: white">
                            <td>
                                <div>
                                    <table class="table table-responsive">
                                        <tr>
                                            <td>
                                                <p>Nombre total :</p>  
                                            </td>
                                            <td style="color: orange">
                                                <b>
                                                    <?php
                                                    
                                                    ?>
                                                </b>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                            </tbody>
                        </table>
                    </td>
                    <td>
                        <table class="table table-bordered table-responsive">
                            <thead>
                            <span class="fa fa-download" style="color: forestgreen; font-size: 60px;margin: 10px;"></span><span class="h3">Les ravitaillements</span>
                            </thead>
                            <tbody style="background-color: forestgreen;color: white">
                            <td>
                                <div>
                                    <table class="table table-responsive">
                                        <tr>
                                            <td>
                                                <p>Nombre total :</p>  
                                            </td>
                                            <td style="color: forestgreen">
                                                <b>
                                                    <?php
                                                    
                                                    ?>
                                                </b>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1>LES DEPOTS EN PLACES</h1>
        </div>
    </div>
    <div class="row">
    <?php
        $n = 0;
        $lien = '';
        $reponse = '';
        $BdUtilisateur = new BdUtilisateur();
        $utilisateurs = $BdUtilisateur->getUtilisateurAllDesc();
        foreach ($utilisateurs as $utilisateur) {
            if ($utilisateur['type'] == "admin") {
                $lien = 'http://' . $_SERVER['SERVER_NAME'] .'/views/home.php?link_up=' . sha1("home_admin_acceuil") . '&reponse=' . sha1($reponse).'&mutationID='.$utilisateur['mutation_id'];
                
            } else if ($utilisateur['type'] == "logistique") {
                $lien = 'http://' . $_SERVER['SERVER_NAME'] .'/views/home.php?link_up=' . sha1("home_logistique_acceuil") . '&reponse=' . sha1($reponse).'&mutationID='.$utilisateur['mutation_id'];
                
            } else if ($utilisateur['type'] == "other") {
                $lien = 'http://' . $_SERVER['SERVER_NAME'] .'/views/home.php?link_up=' . sha1("home_service_acceuil") . '&reponse=' . sha1($reponse).'&mutationID='.$utilisateur['mutation_id'];
                
            } else if ($utilisateur['type'] == "personnel") {
                $lien = 'http://' . $_SERVER['SERVER_NAME'] .'/views/home.php?link_up=' . sha1("home_admin_acceuil") . '&reponse=' . sha1($reponse).'&mutationID='.$utilisateur['mutation_id'];
                
            } else if ($utilisateur['type'] == "membre") {
                $lien = 'http://' . $_SERVER['SERVER_NAME'] .'/views/home.php?link_up=' . sha1("home_service_swaping") . '&reponse=' . sha1($reponse).'&mutationID='.$utilisateur['mutation_id'];
                
            } else if ($utilisateur['type'] == "administration") {
                $lien = 'http://' . $_SERVER['SERVER_NAME'] .'/views/home.php?link_up=' . sha1("home_admin_acceuil") . '&reponse=' . sha1($reponse).'&mutationID='.$utilisateur['mutation_id'];
                
            } else if ($utilisateur['type'] == "hr_mb") {
                $lien = 'http://' . $_SERVER['SERVER_NAME'] .'/views/home.php?link_up=' . sha1("home_admin_acceuil") . '&reponse=' . sha1($reponse).'&mutationID='.$utilisateur['mutation_id'];
                
            }
            // "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']

           if($utilisateur['type'] == 'other'){
            $n = $n + 1;
    ?>
        <div class="col-sm-12 col-md-3">
            <a class="btn btn-primary mt-2 w-100 text-uppercase" href="<?=$lien?>"  rel="noopener noreferrer"> <i class="fa fa-home"></i> <?=$utilisateur['nomUtilisateur']?></a>
        </div>
    <?php
           }
    }
    ?>
    </div>
</div>

