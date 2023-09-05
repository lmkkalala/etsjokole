<?php
include './meta/menu_logistique.php';
include '../models/crud/db.php';
$db = new DB();
$listDriver = $db->getWhere('agent','active','1','id');
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
    <div class="col-md-10 col-sm-12 mt-3 mb-3">
        <h3 class="text-primary">DEPENSES</h3>
    </div>
    
    <div class="col-md-2 col-sm-12 mt-3 mb-3 text-end">
        <button class="btn btn-primary text-white w-100" type="button"  data-bs-toggle="modal" data-bs-target="#staticBackdrop">AJOUTER DEPENSES</button>
    </div>
  </div>
  <div class="col-md-12 col-sm-12 mt-3">
      <form action="" method="post" id="FilterForm">
        <div class="row">
            <div class="col-md-2">
                <select class="form-control"  name="filterAgent" id="filterAgent">
                  <option value="">Selection Agent</option>
                  <?php 
                    foreach ($listDriver as $key => $value) { 
                      if ($listDriver[$key]['active'] == '1') {
                        if ($listDriver[$key]['grade'] != 'Admin' and $listDriver[$key]['grade'] != 'admin') {
                  ?>
                    <option value="<?=$listDriver[$key]['id']?>"><?=$listDriver[$key]['nom'].' '.$listDriver[$key]['postnom'].' '.$listDriver[$key]['prenom']?></option>
                  <?php } } } ?>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-control"  name="filterCategorie" id="filterCategorie">
                  <option value="">Rechercher Depense</option>
                  <option value="Boss">Boss</option>
                  <option value="Mere Boss">Mere Boss</option>
                  <option value="Boulangerie">Boulangerie</option>
                  <option value="Chantier Boss">Chantier Boss</option>
                  <option value="Beni">Beni</option>
                  <option value="Ingeniere">Ingeniere</option>
                </select>
            </div>
            <div class="col-md-2">
              <!-- <input class="form-control" type="date" name="filterDate_start" id="filterDate_start"> -->
            </div>
            <div class="col-md-2">
              <input class="form-control" type="date" name="filterDate_start" id="filterDate_start">
            </div>
            <div class="col-md-2">
              <input class="form-control" type="date" name="filterDate_end" id="filterDate_end">
            </div>
            <div class="col-md-2">
              <input type="hidden" name="FilterDepenseForm" id="FilterDepenseForm">
              <button class="btn btn-primary w-100 text-white" type="submit"> <i class="fa fa-search"></i> Rechercher</button>
            </div>
        </div>
      </form>
  </div>
  <div class="row">
    <div class="col-md-12 table-responsive">
        <table id="depense_list" class="table display" style="width:100%">
            <thead>
                <tr>
                    <th>DATE</th>
                    <th>MONTANT</th>
                    <th>CATERORIE</th>
                    <th>DESCRIPTION</th>
                    <th>PLUS</th>
                </tr>
            </thead>
            <tbody id="list_depense_page"></tbody>
        </table>
    </div>
  </div>
</div>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">DEPENSE</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="new_depense">
          <div class="row">
            <div class="col-12">
              <label for="date">Date</label>
              <input class="form-control" type="date" name="date" id="date" placeholder="" required>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <label for="date">Montant</label>
              <input class="form-control" type="number" name="amount" id="amount" placeholder="" required>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <label for="date">Type Monnais</label>
              <select class="form-control" name="currency" id="currency" required>
                  <option value="">Selectionner Monnais</option>
                  <option value="Dollars">$</option>
                  <option value="FC" selected>FC</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <label for="date">Taux de Change</label>
              <input class="form-control" type="number" name="taux" id="taux" value="2500" required>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <label for="date">Categorie</label>
              <select class="form-control" name="category" id="category" required>
                  <option value="">Selectionner Categorie</option>
                  <option value="Boss">Boss</option>
                  <option value="Mere Boss">Mere Boss</option>
                  <option value="Boulangerie">Boulangerie</option>
                  <option value="Chantier Boss">Chantier Boss</option>
                  <option value="Beni">Beni</option>
                  <option value="Ingeniere">Ingeniere</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <label for="date">Description</label>
              <input class="form-control" type="text" name="description" id="description" placeholder="" required>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-12">
              <input type="hidden" name="save_new_depense" id="save_new_depense">
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