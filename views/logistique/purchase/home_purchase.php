<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include './meta/menu_logistique.php';
?>
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
<!-- <div class="row" style="padding: 10px;">
    <div class="col-md-12" style="background-color: whitesmoke;border-radius: 5px; height: 90vh;"> -->
        <!-- <div class="container-fluid">
            <div class="row"> -->

                <?php if (isset($_GET['msg'])) {  ?>
                    <div class="alert alert-success">
                        <span class="glyphicon glyphicon-ok" style="font-size: 15px;margin-right: 5px;"></span><span><?=$_GET['msg']?></span>
                    </div>
                <?php } ?>

                <h2 class="text-secondary fw-bolder"> ENTREE</h2>

                <!-- <div class="col-md-12" style="height: 80vh;overflow: auto;"> -->
                     
                    <div class="row">
                        <div class="col-md-3 mt-1">
                            <a class="btn btn-secondary text-white w-100" style="font-size: 20px; padding: 30px; " href="/views/home.php?link_up=<?= sha1("home_logistique_fournisseur") ?>">
                                <span style="font-size: 40px;" class="fa fa-user-circle-o"></span><br> Fournisseur
                            </a>
                        </div>
                        <div class="col-md-3 mt-1">
                            <a class="btn btn-secondary  w-100" style="font-size: 20px; padding: 30px;" href="/views/home.php?link_up=<?= sha1("home_logistique_attribution_biens") ?>">
                                <span style="font-size: 40px;" class="fa fa-list-alt"></span><br> Commande
                            </a>
                        </div>
                        <div class="col-md-3 mt-1">
                            <a class="btn btn-secondary w-100" style="font-size: 20px; padding: 30px;" href="/views/home.php?link_up=<?= sha1("home_logistique_ravitaillement") ?>">
                                <span style="font-size: 40px;" class="fa fa-download"></span><br> Réception
                            </a>
                        </div>

                        <div class="col-md-3 mt-1">
                            <a class="btn btn-secondary w-100" style="font-size: 20px; padding: 30px;" href="/views/home.php?link_up=<?= sha1("home_logistique_addsin") ?>">
                                <span style="font-size: 40px;" class="fa fa-list"></span><br> Autres Coûts.
                            </a>
                        </div>

                        <div class="col-md-3">
                            <div class="bg-secondary m-2 p-4 border-4 rounded">
                                <!-- <div class="d-flex justify-content-center mt-1">
                                    <span style="font-size: 40px;" class="fa fa-list-alt text-white"></span>
                                </div> -->
                                <span style="font-size: 20px;" class="fa fa-list-alt text-white"></span><a class="btn btn-secondary" style="font-size: 15px;" href="#" data-bs-toggle="modal" data-bs-target="#add_prix_reception_place"> Reçu Prix</a>
                                <span style="font-size: 20px;" class="fa fa-list-alt text-white"></span><a class="btn btn-secondary" style="font-size: 15px;" href="#" data-bs-toggle="modal" data-bs-target="#list_prix_reception_place"> Autre Prix </a>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="bg-secondary m-2 p-4 border-4 rounded">
                                <!-- <div class="d-flex justify-content-center mt-1">
                                    <span style="font-size: 40px;" class="fa fa-list-alt text-white"></span>
                                </div> -->
                                <span style="font-size: 20px;" class="fa fa-list-alt text-white"></span> <a class="btn btn-secondary" style="font-size: 15px;" href="#" data-bs-toggle="modal" data-bs-target="#add_reception_place"> Ajout Lieu</a>
                                <span style="font-size: 20px;" class="fa fa-list-alt text-white"></span> <a class="btn btn-secondary" style="font-size: 15px;" href="#" data-bs-toggle="modal" data-bs-target="#list_reception_place"> List Lieu</a>
                            </div>
                        </div>

                        
                    </div>
                <!-- </div> -->
            <!-- </div>
        </div> -->
    <!-- </div>
</div> -->

<div class="modal fade" id="add_reception_place" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">AJOUTER RECEPTION</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="add_lieu_reception_form">
          <div class="row">
            <div class="col-md-12">
              <label for="date" class="small fw-bolder">Lieu de recepiton</label>
              <input class="form-control" type="text" name="lieu" id="lieu" placeholder="Kamanyola" required>
            </div>
            <div class="col-md-12">
              <label for="date" class="small fw-bolder">Address</label>
              <input class="form-control" type="text" name="address" id="address" placeholder="Kamanyola" required>
            </div>
            <div class="col-md-12">
              <label for="date" class="small fw-bolder">Ville</label>
              <input class="form-control" type="text" name="ville" id="ville" placeholder="Kamanyola" required>
            </div>
            <div class="col-md-12">
              <label for="date" class="small fw-bolder">Pays</label>
              <input class="form-control" type="text" name="pays" id="pays" placeholder="RDC" required>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-12">
                <input type="hidden" name="add_lieu_reception" id="add_lieu_reception">
                <button type="submit" class="btn btn-secondary w-100">ENREGISTRER</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="list_reception_place" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Lieu de Reception</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <table id="data_list_reception_place" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Lieu</th>
                        <th>Address</th>
                        <th>Ville</th>
                        <th>Pays</th>
                        <th>Autre</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <!-- <tbody id="type_depense_list"></tbody> -->
            </table>
      </div>
    </div>
  </div>
</div>


<div class="modal fade"  id="add_prix_reception_place" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">PRIX DE RECETION PRINCIPALE</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <form action="#" method="post" id="FilterForm">
                    <div class="row">
                        <div class="col-md-2 col-12">
                            <label for="">Article</label>
                            <input type="text" id="article" name="article" class="form-control">
                        </div>
                        <div class="col-md-2 col-12">
                            <label for="">Date Debut</label>
                            <input type="date" id="filterDate_start" name="filterDate_start" class="form-control">
                        </div>
                        <div class="col-md-2 col-12">
                            <label for="">Date Fin</label>
                            <input type="date" id="filterDate_end" name="filterDate_end" class="form-control">
                        </div>
                        <div class="col-md-2 col-12">
                            <label for=""></label>
                            <input type="hidden" id="FilterFormReception" name="FilterFormReception">
                            <button type="submit" name="" class="form-control bg-secondary text-white">Enregistrer</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-12 mt-3 table-responsive">
            <table id="ListReceptionData" class="table display table-bordered table-responsive-lg">
                <thead>
                    <th>
                        Date
                    </th>
                    <th width="100">
                        Article
                    </th>
                    <th>
                        Receptionner
                    </th>
                    <th>
                        Prix Reception
                    </th>
                    <th>
                        PU Place
                    </th>
                </thead>
                <tbody> </tbody>
            </table>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade"  id="list_prix_reception_place" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">PRIX DE RECETION</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <form action="#" method="post" id="FilterFormOther">
                    <div class="row">
                        <div class="col-md-2 col-12">
                            <label for="">Article</label>
                            <input type="text" id="articlePlace" name="articlePlace" class="form-control">
                        </div>
                        <div class="col-md-2 col-12">
                            <label for="">Date Debut</label>
                            <input type="date" id="filterDate_startPlace" name="filterDate_startPlace" class="form-control">
                        </div>
                        <div class="col-md-2 col-12">
                            <label for="">Date Fin</label>
                            <input type="date" id="filterDate_endPlace" name="filterDate_endPlace" class="form-control">
                        </div>
                        <div class="col-md-2 col-12">
                            <label for=""></label>
                            <input type="hidden" id="FilterFormReceptionPlace" name="FilterFormReceptionPlace">
                            <button type="submit" name="" class="form-control bg-secondary text-white">Enregistrer</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-12 mt-3 table-responsive">
                <table id="ListReceptionDataAutrePlace" class="table display table-bordered table-responsive-lg">
                    <thead>
                        <th>
                            Date
                        </th>
                        <th width="100">
                            Article
                        </th>
                        <th>
                            Receptionner
                        </th>
                        <th>
                            Prix Reception
                        </th>
                        <th>
                            PU Place
                        </th>
                        <th>
                            Place
                        </th>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>