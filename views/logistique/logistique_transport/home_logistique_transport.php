<?php
  include './meta/menu_logistique.php';
  include '../models/crud/db.php';
  $db = new DB();
  $listDriver = $db->getWhere('agent','grade','driver');
  $listCourse = $db->get('coursetransport','date');
  $listAgent = $db->getWhere('agent','active','1');
  $listTypeDepense = $db->get('typedepense','id');
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
<div class="container-fluid">
    <div class="row">
      <div class="col-md-3 col-sm-12 text-start mt-3 mb-3">
          <h3 class="text-secondary fw-bolder mt-1">TRANSPORT</h3>
          <button class="btn btn-secondary text-white w-100 mt-1" type="button"  data-bs-toggle="modal" data-bs-target="#list_depense"><i class="fa fa-book"></i> LISTE DEPENSE COURSE</button>
      </div>
      <div class="col-md-2 col-sm-12 mt-3 mb-3 text-end">
          <button class="btn btn-secondary text-white w-100 mt-1" type="button"  data-bs-toggle="modal" data-bs-target="#add_conducteur"><i class="fa fa-user-plus"></i> Conducteur</button>
          <button class="btn btn-secondary text-white w-100 mt-1" type="button"  data-bs-toggle="modal" data-bs-target="#list_conducteur"><i class="fa fa-user"></i> Liste Conducteur</button>
      </div>
      <div class="col-md-2 col-sm-12 mt-3 mb-3 text-end">
          <div class="row">
              <button class="btn btn-secondary text-white w-100 mt-1" type="button"  data-bs-toggle="modal" data-bs-target="#add_vehicule"><i class="fa fa-car"></i> Ajouter Vehicule</button>
              <button class="btn btn-secondary text-white w-100 mt-1" type="button"  data-bs-toggle="modal" data-bs-target="#list_vehicule"><i class="fa fa-car"></i> Liste Vehicule</button>
          </div>
      </div>
      <div class="col-md-2 col-sm-12 mt-3 mb-3 text-end">
        <button class="btn btn-secondary text-white w-100 mt-1" type="button"  data-bs-toggle="modal" data-bs-target="#add_type_depense"><i class="fa fa-money"></i> Type Depense</button>
          <button class="btn btn-secondary text-white w-100 mt-1" type="button"  data-bs-toggle="modal" data-bs-target="#list_type_depense"><i class="fa fa-money"></i> Liste Type</button>
      </div>
      <div class="col-md-3 col-sm-12 mt-3 mb-3 text-end">
          <button class="btn btn-secondary text-white w-100 mt-1" type="button"  data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fa fa-book"></i> NOUVEAU COURSE</button>
          <button class="btn btn-secondary text-white w-100 mt-1" type="button"  data-bs-toggle="modal" data-bs-target="#add_depense"><i class="fa fa-money"></i> DEPENSE COURSE</button>
      </div>
    </div>
    <form action="" method="post" id="FilterForm"> 
      <div class="row">
        <div class="col-md-2">
          <select class="form-control" name="Conducteur" id="Conducteur">
              <option value="">Selectionner Conducteur</option>
              <?php
                  $conducteurFullName = '';
                  foreach ($listAgent as $key2 => $value) {
                    $vehicule = $db->getWhere('vehicule','conducteurID',$listAgent[$key2]['id']);
                    if (count($vehicule) > 0) {
                      $plaque = $vehicule[0]['plaqueVehicule'];
                    }else{
                      $plaque = '';
                    }
                      if ($listAgent[$key2]['active'] == '1' and $listAgent[$key2]['grade'] == 'driver') {
                      $conducteurFullName = $listAgent[$key2]['nom'].' '.$listAgent[$key2]['postnom'].' '.$listAgent[$key2]['prenom'];
              ?>
                  <option value="<?=$listAgent[$key2]['id']?>"><?=$conducteurFullName.' PLAQUE : '.$plaque?></option>
              <?php
                    }
                  }
              ?>
          </select>
        </div>
        <div class="col-md-2">
          <input class="form-control" type="text" name="Destination" id="Destination" placeholder="Destination">
        </div>
        <div class="col-md-2">
        <input class="form-control" type="text" value="Date debut et fin" readonly>
        </div>
        <div class="col-md-2">
          <input class="form-control" type="date" name="filterDate_start" id="filterDate_start">
        </div>
        <div class="col-md-2">
          <input class="form-control" type="date" name="filterDate_end" id="filterDate_end">
        </div>
        <div class="col-md-2">
          <input type="hidden" name="FilterFormCourse" id="FilterFormCourse">
          <button class="btn btn-secondary w-100 text-white" type="submit"> <i class="fa fa-search"></i> Rechercher</button>
        </div>
      </div>
    </form>  
      <div class="row">    
        <div class="col-md-12 mt-3 table-responsive">
          <table id="transport_list" class="table display" style="width:100%">
              <thead>
                  <tr>
                      <th class="small">N°</th>
                      <th class="small">DATE</th>
                      <th class="small">CONDUCTEUR/PLAQUE</th>
                      <th class="small">CONTENU/DESTINATION</th>
                      <th class="small">DESCRIPTION</th>
                      <th class="small">Tonne/MONTANT</th>
                      <th class="small">DEPENSE</th>
                      <th class="small">MARGE</th>
                      <th class="small">EXECUTER</th>
                  </tr>
              </thead>
              <tbody></tbody>
              <!-- <tbody id="list_transport_page"></tbody> -->
          </table>
        </div>
      </div>
</div>

<div class="modal fade" id="add_type_depense" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">TYPE DEPENSE</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="type_depense_form">
          <div class="row">
            <div class="col-6">
              <label for="date" class="small fw-bolder">Description</label>
              <input class="form-control" type="text" name="description_type_depense" id="description_type_depense" placeholder="" required>
            </div>
            <div class="col-6">
              <label for="date" class="small fw-bolder">Montant ($)</label>
              <input class="form-control" type="number" step=0.01 name="montant_type_depense" id="montant_type_depense" placeholder="" required>
            </div>
            <div class="col-6">
              <label for="date" class="small fw-bolder">Pour aller</label>
              <input class="form-control" type="text" name="dest_type_depense" id="dest_type_depense" placeholder="" required>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-12">
                <input type="hidden" name="type_depense_btn" id="type_depense_btn">
                <button type="submit" class="btn btn-primary">ENREGISTRER</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="list_type_depense" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">LISTE TYPE DEPENSE</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table id="depense_type_list" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Montant En $</th>
                        <th>Aller</th>
                        <th>EXECUTER</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <!-- <tbody id="type_depense_list"></tbody> -->
            </table>
        </div>
    </div>
  </div>
</div>

<div class="modal fade" id="list_depense" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">LISTE DEPENSE COURSE</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="" method="post" id="FilterFormOther"> 
            <div class="row">
              <div class="col-md-2 mt-2">
                <select class="form-control" name="ConducteurDepenseCourse" id="ConducteurDepenseCourse">
                      <option value="">Selectionner Conducteur</option>
                      <?php
                          $conducteurFullName = '';
                          foreach ($listAgent as $key2 => $value) {
                            $vehicule = $db->getWhere('vehicule','conducteurID',$listAgent[$key2]['id']);
                            if (count($vehicule) > 0) {
                              $plaque = $vehicule[0]['plaqueVehicule'];
                            }else{
                              $plaque = '';
                            }
                              if ($listAgent[$key2]['active'] == '1' and $listAgent[$key2]['grade'] == 'driver') {
                              $conducteurFullName = $listAgent[$key2]['nom'].' '.$listAgent[$key2]['postnom'].' '.$listAgent[$key2]['prenom'];
                      ?>
                          <option value="<?=$listAgent[$key2]['id']?>"><?=$conducteurFullName.' PLAQUE : '.$plaque?></option>
                      <?php
                            }
                          }
                      ?>
                </select>
              </div>
              <div class="col-md-2 mt-2">
                <input class="form-control" type="text" value="Date Debut et Fin"  readonly>
              </div>
              <div class="col-md-3 mt-2">
                <input class="form-control" type="date" name="filterDate_startDepenseCourse" id="filterDate_startDepenseCourse">
              </div>
              <div class="col-md-3 mt-2">
                <input class="form-control" type="date" name="filterDate_endDepenseCourse" id="filterDate_endDepenseCourse">
              </div>
              <div class="col-md-2 mt-2">
                <input type="hidden" name="FilterFormDepenseCourse" id="FilterFormDepenseCourse">
                <button class="btn btn-primary w-100 text-white" type="submit"> <i class="fa fa-search"></i> Rechercher</button>
              </div>
            </div>
          </form>  
          <div class="mt-3">
            <table  id="spend_list_transport" class="display table-responsive" style="width:100%">
              <thead>
                  <tr>
                      <th>Date</th>
                      <th>Conducteur</th>
                      <th>Description</th>
                      <th>Les Depenses</th>
                      <th>EXECUTER</th>
                  </tr>
              </thead>
              <tbody></tbody>
              <!-- <tbody id="list_depense_course"></tbody> -->
            </table>
          </div>
        </div>
    </div>
  </div>
</div>

<div class="modal fade" id="add_depense" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">DEPENSE SUR COURSE</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="depense_course_form">
          <div class="row">
          <div class="row">
            <div class="col-6">
              <label for="date" class="small fw-bolder">Transport Course De</label>
              <select class="form-control" name="depense_course_conducteur_id" id="depense_course_conducteur_id" required>
                <option value="">Selectionner Course</option>
                <?php
                $conducteurFullName = '';
                  foreach ($listCourse as $key => $value) {
                    foreach ($listAgent as $key2 => $value) {
                      if ($listCourse[$key]['conducteur'] == $listAgent[$key2]['id']) {
                        if ($listAgent[$key2]['active'] == '1') {
                        $conducteurFullName = $listAgent[$key2]['nom'].' '.$listAgent[$key2]['postnom'].' '.$listAgent[$key2]['prenom'];
                ?>
                  <option value="<?=$listCourse[$key]['conducteur']?>"><?=$conducteurFullName.' Le '.$listCourse[$key]['date']?></option>
                <?php
                        }
                      }
                    }
                  }
                ?>
              </select>
            </div>
            <div class="col-6">
              <label for="date" class="small fw-bolder">Date</label>
              <input class="form-control" type="date" name="course_date" id="course_date" placeholder="" required>
            </div>
          </div>
          <div class="col-6">
              <label for="date" class="small fw-bolder">Course Transport</label>
              <select class="form-control" name="course_transport_id" id="course_transport_id" required>
                <option value="">Selectionner Course</option>
                <?php
                $conducteurFullName = '';
                  foreach ($listCourse as $key => $value) {
                    foreach ($listAgent as $key2 => $value) {
                      if ($listCourse[$key]['conducteur'] == $listAgent[$key2]['id']) {
                        if ($listAgent[$key2]['active'] == '1') {
                        $conducteurFullName = $listAgent[$key2]['nom'].' '.$listAgent[$key2]['postnom'].' '.$listAgent[$key2]['prenom'];
                ?>
                    <option value="<?=$listCourse[$key]['id']?>"><?=' Le '.$listCourse[$key]['date'].' '.$conducteurFullName.' Destination '.$listCourse[$key]['destination']?></option>
                <?php
                        }
                      }
                    }
                  }
                ?>
              </select>
            </div>
            <div class="col-6">
              <label for="date" class="small fw-bolder">Depense</label>
              <select class="form-control" name="description_depense_course_id" id="description_depense_course_id" required>
                <option value="">Selectionner Depense</option>
                <?php
                  foreach ($listTypeDepense as $key => $value) {
                    if ($listTypeDepense[$key]['status'] == '1') {
                ?>
                  <option value="<?=$listTypeDepense[$key]['id']?>"><?=$listTypeDepense[$key]['description'].' '.$listTypeDepense[$key]['montant'].'$ Pour '.$listTypeDepense[$key]['destination']?></option>
                <?php
                    }
                  }
                ?>
              </select>
            </div>
            <div class="col-6">
              <label for="date" class="small fw-bolder">Montant</label>
              <input class="form-control" type="number" step=0.01 name="montant_depense_course" id="montant_depense_course" placeholder="Saisisser le montant" required>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-12">
                  <input type="hidden" name="depense_course_btn" id="depense_course_btn">
                <button type="submit" class="btn btn-primary">ENREGISTRER</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">NOUVEAU COURSE TRANSPORT</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="add_course_form">
          <div class="row">
            <div class="col-6">
              <label for="date" class="small fw-bolder">Date</label>
              <input class="form-control" type="date" name="course_date" id="course_date" placeholder="" required>
            </div>
          
            <div class="col-6">
              <label for="date" class="small fw-bolder">Conducteur</label>
              <select class="form-control" name="course_conducteur" id="course_conducteur" required>
                <option value="">Selectionner Conducteur</option>
                  <?php 
                    foreach ($listDriver as $key => $value) { 
                      if ($listDriver[$key]['active'] == '1') {
                  ?>
                    <option value="<?=$listDriver[$key]['id']?>"><?=$listDriver[$key]['nom'].' '.$listDriver[$key]['postnom'].' '.$listDriver[$key]['prenom']?></option>
                  <?php } } ?>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <label for="date" class="small fw-bolder">Destination</label>
              <input class="form-control" type="text" name="course_destination" id="course_destination" placeholder="" required>
            </div>
            <div class="col-6">
              <label for="date" class="small fw-bolder">Contenu Transporter</label>
              <input class="form-control" type="text" name="course_contenu" id="course_contenu" placeholder="" required>
            </div>
            <div class="col-6">
              <label for="date" class="small fw-bolder">Tonage Contenu</label>
              <input class="form-control" type="text" name="course_contenu_tone" id="course_contenu_tone" placeholder="" required>
            </div>
            <div class="col-6">
              <label for="date" class="small fw-bolder">Prix COURSE</label>
              <input class="form-control" type="number" step=0.01 name="course_prix" id="course_prix" placeholder="" required>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <label for="date" class="small fw-bolder">Description</label>
              <input class="form-control" type="text" name="description_course" id="description_course" placeholder="" required>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-12">
                <input type="hidden" name="add_course_btn" id="add_course_btn">
                <button type="submit" class="btn btn-primary">ENREGISTRER</button>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">FERMER</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="add_vehicule" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">NOUVEAU VEHICULE</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="add_vehicule_form">
          <div class="row">
          <div class="col-6">
              <label for="date" class="small fw-bolder">Date Ajout</label>
              <input class="form-control" type="date" name="date_vehicule" id="date_vehicule" placeholder="" required>
            </div>
            <div class="col-6">
              <label for="date" class="small fw-bolder">Type vehicule</label>
              <input class="form-control" type="text" name="type_vehicule" id="type_vehicule" placeholder="" required>
            </div>
            <div class="col-6">
              <label for="date" class="small fw-bolder">Marque Vehicule</label>
              <input class="form-control" type="text" name="marque_vehicule" id="marque_vehicule" placeholder="" required>
            </div>
            <div class="col-6">
              <label for="date" class="small fw-bolder">Plaque vehicule</label>
              <input class="form-control" type="text" name="plaque_vehicule" id="plaque_vehicule" placeholder="" required>
            </div>
            <div class="col-6">
              <label for="date" class="small fw-bolder">Couleur Vehicule</label>
              <input class="form-control" type="text" name="couleur_vehicule" id="couleur_vehicule" placeholder="" required>
            </div>
            <div class="col-6">
              <label for="date" class="small fw-bolder">Conducteur</label>
              <select class="form-control" name="conducteur_vehicule" id="conducteur_vehicule" required>
                  <option value="">Selectionner Conducteur</option>
                <?php 
                  foreach ($listDriver as $key => $value) { 
                    if ($listDriver[$key]['active'] == '1') {
                ?>
                  <option value="<?=$listDriver[$key]['id']?>"><?=$listDriver[$key]['nom'].' '.$listDriver[$key]['postnom'].' '.$listDriver[$key]['prenom']?></option>
                <?php } } ?>
              </select>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-12">
                  <input type="hidden" name="add_vehicule_btn" id="add_vehicule_btn">
                <button type="submit" class="btn btn-primary" >ENREGISTRER</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="list_vehicule" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">LISTE VEHICULE</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table  id="vehicule_list" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Plaque</th>
                        <th>Type</th>
                        <th>Marque</th>
                        <th>Couleur</th>
                        <th>Conducteur</th>
                        <th>Plus</th>
                    </tr>
                </thead>
                <tbody id="vehicule_list_data"></tbody>
            </table>
        </div>
    </div>
  </div>
</div>

<div class="modal fade" id="add_conducteur" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">NOUVEAU CONDUCTEUR</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="add_driver_form">
          <div class="row">
            <div class="col-6">
              <label for="date" class="small fw-bolder">NOM</label>
              <input class="form-control" type="text" name="f_name" id="f_name" placeholder="" required>
            </div>
            <div class="col-6">
              <label for="date" class="small fw-bolder">POSTNOM</label>
              <input class="form-control" type="text" name="s_name" id="s_name" placeholder="" required>
            </div>
            <div class="col-6">
              <label for="date" class="small fw-bolder">PRENOM</label>
              <input class="form-control" type="text" name="l_name" id="l_name" placeholder="" required>
            </div>
            <div class="col-6">
              <label for="date" class="small fw-bolder">NUMERO PERMIS DE CONDUIRE</label>
              <input class="form-control" type="text" name="n_permis" id="n_permis" placeholder="" required>
            </div>
            <div class="col-6">
              <label for="date" class="small fw-bolder">Genre</label>
              <select class="form-control" name="genre" id="genre" required>
              <option value="">Genre</option>
                <option value="Homme">Homme</option>
                <option value="Femme">Femme</option>
              </select>
            </div>
            <div class="col-6">
              <label for="date" class="small fw-bolder">Date De Naissance</label>
              <input class="form-control" type="date" name="born_date" id="born_date" placeholder="" required>
            </div>
            <div class="col-6">
              <label for="date" class="small fw-bolder">Date D'Engagement</label>
              <input class="form-control" type="date" name="eng_date" id="eng_date" placeholder="" required>
            </div>
            <div class="col-6">
              <label for="date" class="small fw-bolder">Fonction</label>
              <input class="form-control" type="text" name="function" id="function" value="driver" placeholder="" readonly>
            </div>
            <div class="col-6">
              <label for="date" class="small fw-bolder">Telephone</label>
              <input class="form-control" type="tel" name="phone" id="phone" placeholder="" required>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-12">
                <input type="hidden" name="add_new_driver" id="add_new_driver">
                <button type="submit" class="btn btn-primary">ENREGISTRER</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="list_conducteur" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">LISTE CONDUCTEUR</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body  table-responsive">
            <table  id="driver_list" class="display table" style="width:100%">
                <thead>
                    <tr>
                        <th>NOM</th>
                        <th>POSTNOM</th>
                        <th>PRESNOM</th>
                        <th>PERMIS</th>
                        <th>DATE N</th>
                        <th>DATE EN</th>
                        <th>SEXE</th>
                        <th>TELEPHONE</th>
                        <th>Plus</th>
                    </tr>
                </thead>
                <tbody id="driver_list_data"></tbody>
            </table>
        </div>
    </div>
  </div>
</div>