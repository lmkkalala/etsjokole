<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/demande/demande.php';
include '../models/distribution/distribution.php';
include '../models/livraison/livraison.php';
include '../models/affectation-service/affectationService.php';
include '../models/service/service.php';
include '../models/biens/biens.php';
include '../models/crud/db.php';
$DB = new DB();
$bdbiens = new BdBiens();
$bdaffectation = new BdAffectationService();
$mutationID = '';
$serviceID = '';
$serviceName = '';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-cube" style="color: #0069d9; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-recycle" style="color: #0069d9; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Liste des ventes</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-list-ol" style="color: darkgray; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Liste des ventes annulees</span>
    </div>
    <div class="panel panel-body">
        <div>
            <div class="row mt-3">
                <form class="form-inline" method="POST" action="/views/home.php?link=<?= sha1("service_liste_annulation_all")?>&link_up=<?= sha1("home_service_annulation")?>">
                    <div class="row form-group-lg">
                        <div class="col-md-3 mt-2">
                            <select class="form-control w-100 select2" name="cb_service">
                                    <option value="0">Choisir un POS/Departement/Service</option>
                                <?php
                                    $bdservice = new DB();
                                    $services = $bdservice->getWhereMultipleMore(' * , mutation.id as mID, service.id as sID FROM mutation INNER JOIN service ON service.id = mutation.service_id INNER JOIN agent ON agent.id = mutation.agent_id ',' mutation.active = 1 ',' ORDER BY mutation.id DESC ');
                                    foreach ($services as $service) {
                                        
                                        if (($service['sID'] == $_SESSION['idservice']) || ($_SESSION['type']=="logistique") || ($_SESSION['grade']=="Seller")) {
                                            if (($service['sID'] == $_SESSION['idservice']) && ($_SESSION['type']!="logistique")) {
                                                $selected = 'selected';
                                                $mutationID = $service['mID'];
                                                $serviceID = $service['sID'];
                                                $serviceName = $service['designation'];
                                            }else{
                                                $selected = '';
                                            }
                                ?>
                                    <option <?=$selected?>  value="<?= $service['mID'] ?>"><?= $service['designation']. ' / AGENT: '.$service['nom'] ?></option>
                                <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3 mt-2">
                            <input type="date" class="form-control w-100" name="start_date" id="start_date" value="<?=date('Y-m-d')?>" placeholder="Mot-clé">  
                        </div>
                        <div class="col-md-3 mt-2">
                            <input type="date" class="form-control w-100" name="end_date" id="end_date" value="<?=date('Y-m-d')?>" placeholder="Mot-clé"> 
                        </div> 
                        <div class="col-md-3 mt-2">
                        <button type="submit" class="btn btn-secondary w-100" name="search_data"><span class="glyphicon glyphicon-search" style="color: white; font-size: 15px;margin-right: 5px;"></span> Rechercher</button>
                        </div>                          
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="col-md-12 overflow-auto">
                    <h4>Liste <?=$serviceName?></h4>
                    <table class="table table-bordered table-responsive-lg">
                        <thead>
                        <th>
                            N°
                        </th>
                        <th>
                            Date/Heure Suppression
                        </th>
                        <th>
                            N° Vente
                        </th>
                        <th>
                            Client
                        </th>
                        <th>
                            Produit
                        </th>
                        <th>
                            Quantite
                        </th>
                        <th>
                            Prix U/T
                        </th>
                        <th>
                            Depot
                        </th>
                        <th>
                            Date/Heure Vente
                        </th>
                        <th>
                            Par
                        </th>
                        </thead>
                        <tbody>
                        <?php
                            $n = 1;
                        
                            $cb_service = isset(($_POST["cb_service"])) ? htmlspecialchars($_POST["cb_service"]) : "";
                            $start_date = isset(($_POST["start_date"])) ? htmlspecialchars($_POST["start_date"]) : date('Y-m-d',time());
                            $end_date = isset(($_POST["end_date"])) ? htmlspecialchars($_POST["end_date"]) : date('Y-m-d',time());

                            if (($serviceID == $_SESSION['idservice'])) {
                                $condition_ = " annulation_vente.mutation_id = ".$mutationID." AND";
                            }else{
                                if (!empty($cb_service)) {
                                    $condition_ = " annulation_vente.mutation_id = ".$cb_service." AND";
                                }else{
                                    $condition_ = " ";
                                }  
                            }

                            $biens = $bdbiens->getBiensAllDescActive();
                            foreach ($biens as $bien) {
                                $select = " *, biens.id as bid, annulation_vente.price as aPrix, annulation_vente.nombre as aN FROM annulation_vente INNER JOIN distrubution ON distrubution.id = annulation_vente.distribution_id INNER JOIN demande ON demande.id = distrubution.demande_id INNER JOIN biens ON demande.biens_id = biens.id ";
                                $condition = $condition_." biens.id = ".$bien['bId']." AND annulation_vente.date_annulation >= '".$start_date."' AND annulation_vente.date_annulation <= '".$end_date."' ";
                                $affectations = $DB->getWhereMultipleMore($select,$condition,' ORDER BY annulation_vente.date_annulation DESC ');
                                foreach ($affectations as $affectation) {    
                                    if (count($affectations) > 0) { 
                                    $affectation_services = $bdservice->getWhereMultipleMore(' * , mutation.id as mID, service.id as sID FROM mutation INNER JOIN service ON service.id = mutation.service_id INNER JOIN agent ON agent.id = mutation.agent_id ',' mutation.active = 1 AND mutation.id = '.$affectation['mutation_id'].'',' ORDER BY mutation.id DESC ');   
                                    
                                    if (count($affectation_services) > 0) {
                                        foreach ($affectation_services as $affectation_service) {
                                            $service_name = $affectation_service['designation'];
                                        } 
                                    }else{
                                        $service_name = '';
                                    }   
                        ?>
                                        <tr>
                                            <td><?= $n ?></td>
                                            <td><?= $affectation['date_annulation'].' / '.$affectation['time_annulation'] ?></td>
                                            <td><?= $affectation['venteposId'] ?></td>
                                            <td><?= $affectation['identiteClient'] ?></td>
                                            <td><?= $affectation['designation']?></td>
                                            <td><?= $affectation['nombre'] ?></td>
                                            <td><?= $affectation['price'] ?></td>
                                            <td><?= $service_name ?></td>
                                            <td><?= $affectation['date_vente'].' / '.$affectation['time_vente'] ?></td>
                                            <td><?= $affectation['added_by'] ?></td>
                                        </tr>
                            <?php
                                        $n = $n + 1;
                                    }
                                }
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

