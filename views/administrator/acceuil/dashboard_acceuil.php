<?php
/*
 * To change this license header, choose License Headers in Project Properties.
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
        <span class="fa fa-dashboard" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span><span class="h3">Tableau de bord</span>
        <span class="pull-right" style="color: red; font-size: 30px;margin-right: 0px;">*</span>
        <span class="fa fa-bell-o pull-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
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
                            <span class="fa fa-users" style="color: #0069d9; font-size: 60px;margin: 10px;"></span><span class="h3">Les utilisateurs</span>
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
                                                    $n = 0;
                                                    $bdutilisateur = new BdUtilisateur();
                                                    $utilisateurs = $bdutilisateur->getUtilisateurAllDesc();
                                                    foreach ($utilisateurs as $utilisateur) {
                                                        $n++;
                                                    }
                                                    echo $n;
                                                    ?>
                                                </b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p>Nombre des utilisateurs actifs :</p>  
                                            </td>
                                            <td style="color: #0069d9">
                                                <b>
                                                    <?php
                                                    $n = 0;
                                                    $bdutilisateur = new BdUtilisateur();
                                                    $utilisateurs = $bdutilisateur->getUtilisateurAllDescActive();
                                                    foreach ($utilisateurs as $utilisateur) {
                                                        $n++;
                                                    }
                                                    echo $n;
                                                    ?> 
                                                </b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p>Nombre des utilisateurs inactifs :</p>  
                                            </td>
                                            <td style="color: #0069d9">
                                                <b>
                                                    <?php
                                                    $n = 0;
                                                    $bdutilisateur = new BdUtilisateur();
                                                    $utilisateurs = $bdutilisateur->getUtilisateurAllDescDesactive();
                                                    foreach ($utilisateurs as $utilisateur) {
                                                        $n++;
                                                    }
                                                    echo $n;
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
                            <span class="fa fa-user" style="color: red; font-size: 60px;margin: 10px;"></span><span class="h3">Les agents</span>
                            </thead>
                            <tbody style="background-color: red;color: white">
                            <td>
                                <div>
                                    <table class="table">
                                        <tr>
                                            <td>
                                                <p>Nombre total :</p>  
                                            </td>
                                            <td style="color: red">
                                                <b>
                                                    <?php
                                                    $n = 0;
                                                    $bdagent=new BdAgent();
                                                    $agents=$bdagent->getAgentAllDesc();
                                                    foreach ($agents as $agent) {
                                                        $n++;
                                                    }
                                                    echo $n;
                                                    ?>
                                                </b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p>Nombre des agents actifs :</p>  
                                            </td>
                                            <td style="color: red">
                                                <b>
                                                    <?php
                                                    $n = 0;
                                                    $agents=$bdagent->getAgentAllDescActive();
                                                    foreach ($agents as $agent) {
                                                        $n++;
                                                    }
                                                    echo $n;
                                                    ?> 
                                                </b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p>Nombre des agents inactifs :</p>  
                                            </td>
                                            <td style="color: red">
                                                <b>
                                                    <?php
                                                    $n = 0;
                                                    $agents=$bdagent->getAgentAllDescDesactive();
                                                    foreach ($agents as $agent) {
                                                        $n++;
                                                    }
                                                    echo $n;
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
                            <span class="fa fa-link" style="color: orange; font-size: 60px;margin: 10px;"></span><span class="h3">Les affectations</span>
                            </thead>
                            <tbody style="background-color: orange;color: white">
                            <td>
                                <div>
                                    <table class="table">
                                        <tr>
                                            <td>
                                                <p>Nombre total :</p>  
                                            </td>
                                            <td style="color: orange">
                                                <b>
                                                    <?php
                                                    $n = 0;
                                                    $bdaffectation=new BdAffectationService();
                                                    $affectations=$bdaffectation->getAffectationServiceAllDesc();
                                                    foreach ($affectations as $affectation) {
                                                        $n++;
                                                    }
                                                    echo $n;
                                                    ?>
                                                </b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p>Nombre des affectations actives :</p>  
                                            </td>
                                            <td style="color: orange">
                                                <b>
                                                    <?php
                                                    $n = 0;
                                                    $affectations=$bdaffectation->getAffectationServiceAllDescActive();
                                                    foreach ($affectations as $affectation) {
                                                        $n++;
                                                    }
                                                    echo $n;
                                                    ?> 
                                                </b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p>Nombre des affectations inactives :</p>  
                                            </td>
                                            <td style="color: orange">
                                                <b>
                                                    <?php
                                                    $affectations=$bdaffectation->getAffectationServiceAllDescDesactive();
                                                    foreach ($affectations as $affectation) {
                                                        $n++;
                                                    }
                                                    echo $n;
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
                            <span class="fa fa-black-tie" style="color: forestgreen; font-size: 60px;margin: 10px;"></span><span class="h3">Les services</span>
                            </thead>
                            <tbody style="background-color: forestgreen;color: white">
                            <td>
                                <div>
                                    <table class="table">
                                        <tr>
                                            <td>
                                                <p>Nombre total :</p>  
                                            </td>
                                            <td style="color:forestgreen">
                                                <b>
                                                    <?php
                                                    $n = 0;
                                                    $bdservice = new BdService();
                                                    $services = $bdservice->getServiceAllDesc();
                                                    foreach ($services as $service) {
                                                        $n++;
                                                    }
                                                    echo $n;
                                                    ?>
                                                </b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p>Nombre des services actifs :</p>  
                                            </td>
                                            <td style="color: forestgreen">
                                                <b>
                                                    <?php
                                                    $n = 0;
                                                    $bdservice = new BdService();
                                                    $services = $bdservice->getServiceAllDescActive();
                                                    foreach ($services as $service) {
                                                        $n++;
                                                    }
                                                    echo $n;
                                                    ?> 
                                                </b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p>Nombre des services inactifs :</p>  
                                            </td>
                                            <td style="color: forestgreen">
                                                <b>
                                                    <?php
                                                    $n = 0;
                                                    $bdservice = new BdService();
                                                    $services = $bdservice->getServiceAllDescDesactive();
                                                    foreach ($services as $service) {
                                                        $n++;
                                                    }
                                                    echo $n;
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

