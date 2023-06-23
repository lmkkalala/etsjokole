<?php
  include './meta/menu_logistique.php';
  include '../models/crud/db.php';
  $db = new DB();
  $listDriver = $db->getWhere('agent','grade','driver');
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 col-sm-12 text-start mt-3 mb-3">
            <h3 class="text-primary fw-bolder mt-1">TRANSPORT</h3>
        </div>
        <div class="col-md-2 col-sm-12 mt-3 mb-3 text-end">
            <div class="row">
                <button class="btn btn-primary text-white w-100 mt-1" type="button"  data-bs-toggle="modal" data-bs-target="#add_vehicule"><i class="fa fa-car"></i> Ajouter Vehicule</button>
                <button class="btn btn-primary text-white w-100 mt-1" type="button"  data-bs-toggle="modal" data-bs-target="#list_vehicule"><i class="fa fa-car"></i> Liste Vehicule</button>
            </div>
        </div>
        <div class="col-md-2 col-sm-12 mt-3 mb-3 text-end">
            <button class="btn btn-primary text-white w-100 mt-1" type="button"  data-bs-toggle="modal" data-bs-target="#add_conducteur"><i class="fa fa-user-plus"></i> Conducteur</button>
            <button class="btn btn-primary text-white w-100 mt-1" type="button"  data-bs-toggle="modal" data-bs-target="#list_conducteur"><i class="fa fa-user"></i> Liste Conducteur</button>
        </div>
        <div class="col-md-2 col-sm-12 mt-3 mb-3 text-end">
          <button class="btn btn-primary text-white w-100 mt-1" type="button"  data-bs-toggle="modal" data-bs-target="#add_type_depense"><i class="fa fa-money"></i> Type Depense</button>
            <button class="btn btn-primary text-white w-100 mt-1" type="button"  data-bs-toggle="modal" data-bs-target="#list_type_depense"><i class="fa fa-money"></i> Liste Type</button>
        </div>
        <div class="col-md-4 col-sm-12 mt-3 mb-3 text-end">
            <button class="btn btn-primary text-white w-100 mt-1" type="button"  data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fa fa-book"></i> NOUVEAU COURSE</button>
            <button class="btn btn-primary text-white w-100 mt-1" type="button"  data-bs-toggle="modal" data-bs-target="#add_depense"><i class="fa fa-money"></i> NOUVEAU DEPENSE</button>
        </div>
        <div class="col-12">
            <table id="transport_list" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th class="small">DATE</th>
                        <th class="small">CONDUCTEUR</th>
                        <th class="small">PLAQUE</th>
                        <th class="small">DESTINATION</th>
                        <th class="small">DESCRIPTION</th>
                        <th class="small">DEPENSE</th>
                        <th class="small">PLUS</th>
                    </tr>
                </thead>
                <tbody id="list_transport_page">
                    <form action="" method="post" id="">
                      <tr>
                          <td><input class="form-control" type="date" name="" id="" placeholder="" value=""></td>
                          <td><input class="form-control" type="number" name="" id="" placeholder="" value=""></td>
                          <td><input class="form-control" type="text" name="" id="" placeholder="" value=""></td>
                          <td><input class="form-control" type="number" name="" id="" placeholder="" value=""></td>
                          <td><input class="form-control" type="number" name="" id="" placeholder="" value=""></td>
                          <td><input class="form-control" type="number" name="" id="" placeholder="" value="" readonly></td>
                          <td>
                            <button class="btn btn-info mt-1 text-white w-100" type="button" data-bs-toggle="modal" data-bs-target="#add_depense"><i class="fa fa-money"></i></button>
                            <button class="btn btn-info mt-1 text-white w-100" type="submit"><i class="fa fa-pencil"></i> </button>
                            <button class="btn btn-danger mt-1 text-white w-100" type="submit"><i class="fa fa-trash"></i></button>
                          </td>
                      </tr>
                    </form>
                </tbody>
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
              <input class="form-control" type="text" name="montant_type_depense" id="montant_type_depense" placeholder="" required>
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
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">LISTE TYPE DEPENSE</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table  id="driver_list" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Montant En $</th>
                        <th>Plus</th>
                    </tr>
                </thead>
                <tbody id="type_depense_list">
                    <!-- <form action="" method="post" id="">
                        <tr>
                            <td>
                                <input class="form-control" type="text" name="name" id="name" placeholder="">
                            </td>
                            <td>
                                <input class="form-control" type="text" name="phone" id="phone" placeholder="" >
                            </td>
                            <td>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-pencil"></i></button>
                                <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    </form> -->
                </tbody>
            </table>
        </div>
    </div>
  </div>
</div>

<div class="modal fade" id="add_depense" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">DEPENSE</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="depense_vehicule_course">
          <div class="row">
          <div class="row">
            <div class="col-6">
              <label for="date" class="small fw-bolder">Date</label>
              <input class="form-control" type="date" name="date" id="date" placeholder="" required>
            </div>
          
            <div class="col-6">
              <label for="date" class="small fw-bolder">Conducteur</label>
              <select class="form-control" name="banque" id="banque" required>
                <option name="Wasafi">Wasafi</option>
                <option name="Amani">Amani</option>
              </select>
            </div>
          </div>
            <div class="col-6">
              <label for="date" class="small fw-bolder">Description</label>
              <input class="form-control" type="text" name="description_depense_course" id="description_depense_course" placeholder="" required>
            </div>
            <div class="col-6">
              <label for="date" class="small fw-bolder">Montant</label>
              <input class="form-control" type="text" name="montant_depense_course" id="montant_depense_course" placeholder="" required>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-12">
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
        <h1 class="modal-title fs-5" id="staticBackdropLabel">NOUVEAU COURSE</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="operation_caisse">
          <div class="row">
            <div class="col-6">
              <label for="date" class="small fw-bolder">Date</label>
              <input class="form-control" type="date" name="date" id="date" placeholder="" required>
            </div>
          
            <div class="col-6">
              <label for="date" class="small fw-bolder">Conducteur</label>
              <select class="form-control" name="banque" id="banque" required>
                <option name="Wasafi">Wasafi</option>
                <option name="Amani">Amani</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <label for="date" class="small fw-bolder">Destination</label>
              <input class="form-control" type="number" name="nBordereau" id="nBordereau" placeholder="" required>
            </div>
            <div class="col-6">
              <label for="date" class="small fw-bolder">Prix COURSE</label>
              <input class="form-control" type="text" name="prix_course" id="prix_course" placeholder="" required>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <label for="date" class="small fw-bolder">Description</label>
              <input class="form-control" type="text" name="description" id="description" placeholder="" required>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-12">
                <input type="hidden" name="operation_caisse_new" id="operation_caisse_new">
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
                <?php foreach ($listDriver as $key => $value) { ?>
                  <option value="<?=$listDriver[$key]['id']?>"><?=$listDriver[$key]['nom'].' '.$listDriver[$key]['postnom'].' '.$listDriver[$key]['prenom']?></option>
                <?php } ?>
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
  <div class="modal-dialog modal-xl">
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
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">LISTE CONDUCTEUR</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table  id="driver_list" class="display" style="width:100%">
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
                <tbody id="driver_list_data">
                    <!-- <form action="" method="post" id="driver_list_data_form">
                        <tr>
                            <td>
                                <input class="form-control" type="text" name="name" id="name" placeholder="">
                            </td>
                            <td>
                                <input class="form-control" type="text" name="name" id="name" placeholder="">
                            </td>
                            <td>
                                <input class="form-control" type="text" name="name" id="name" placeholder="">
                            </td>
                            <td>
                                <select class="form-control" name="genre" id="genre" >
                                    <option name="" value="Homme">Homme</option>
                                    <option name="" value="Femme">Femme</option>
                                </select>
                            </td>
                            <td>
                                <input class="form-control" type="tel" name="phone" id="phone" placeholder="" >
                            </td>
                            <td>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-pencil"></i></button>
                                <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    </form> -->
                </tbody>
            </table>
        </div>
    </div>
  </div>
</div>