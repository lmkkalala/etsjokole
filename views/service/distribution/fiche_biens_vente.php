<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/biens/biens.php';
include '../models/crud/db.php';

?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-cube" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-hand-stop-o" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">POS</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-gift" style="color: orange; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-file-text-o" style="color: orange; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">Ventes par biens/produit</span>
    </div>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <div class="row mt-3">
                    <form class="form-inline" method="POST" id="listVenteGlobal">
                        <div class="row form-group-lg">
                            <div class="col-md-3">
                                <select class="form-control select2" name="cb_service">
                                    <option value="0">Choisir un POS/Departement/Service</option>
                                    <?php
                                    $bdservice = new DB();
                                    $services = $bdservice->getWhereMultipleMore(' * , mutation.id as mID, service.id as sID FROM mutation INNER JOIN service ON service.id = mutation.service_id ',' mutation.active = 1 ',' ORDER BY mutation.id DESC ');
                                    foreach ($services as $service) {
                                        if (($service['sID'] == $_SESSION['idservice']) || ($_SESSION['type']=="logistique")) {
                                            if (($service['sID'] == $_SESSION['idservice']) && ($_SESSION['type']!="logistique")) {
                                                $selected =  ' selected ';
                                            }else{
                                                $selected = '';
                                            }
                                    ?>
                                        <option <?=$selected?>  value="<?= $service['mID'] ?>"><?= $service['designation'] ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="date" class="form-control" name="start_date" id="start_date" value="<?=date('Y-m-d')?>" placeholder="Mot-clé">  
                            </div>
                            <div class="col-md-3">
                                <input type="date" class="form-control" name="end_date" id="end_date" value="<?=date('Y-m-d')?>" placeholder="Mot-clé"> 
                            </div> 
                            <div class="col-md-3">
                            <button type="submit" class="btn btn-success" name="search_data"><span class="glyphicon glyphicon-search" style="color: white; font-size: 15px;margin-right: 5px;"></span> Rechercher</button>
                            </div>                          
                        </div>
                    </form>
                </div>
                <legend>Liste des biens/produits</legend>
                <table class="table table-bordered table-responsive-lg">
                    <thead>
                        <th>
                            N°
                        </th>
                        <th>
                            Désignation
                        </th>
                        <th>
                            Quantite vendu
                        </th>
                        <th>
                            Prix Moyen Vente
                        </th>
                        <th>
                            Prix de vente
                        </th>
                    </thead>
                    <tbody id="VenteProduitGlobal"></tbody>
                </table>
            </fieldset>
        </div>
    </div>
</div>

