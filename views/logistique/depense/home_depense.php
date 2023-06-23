<?php
include './meta/menu_logistique.php';
?>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-4 col-sm-12 mt-3 mb-3">
        <h3 class="text-primary">DEPENSES</h3>
    </div>
    
    <div class="col-md-8 col-sm-12 mt-3 mb-3 text-end">
        <button class="btn btn-primary text-white" type="button"  data-bs-toggle="modal" data-bs-target="#staticBackdrop">AJOUTER DEPENSES</button>
    </div>
  </div>
  <div class="col-md-12 col-sm-12 mt-3">
      <form action="" method="post" id="FilterDepenseForm">
        <div class="row">
            <div class="col-3">
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
            <div class="col-3">
              <input class="form-control" type="date" name="filterDate_start" id="filterDate_start">
            </div>
            <div class="col-3">
              <input class="form-control" type="date" name="filterDate_end" id="filterDate_end">
            </div>
            <div class="col-3">
              <button class="btn btn-primary text-white" type="submit"> <i class="fa fa-search"></i> Rechercher</button>
            </div>
        </div>
      </form>
    </div>
  <div class="row">
    <div class="col-12">
        <table id="depense_list" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>DATE</th>
                    <th>MONTANT</th>
                    <th>CATERORIE</th>
                    <th>DESCRIPTION</th>
                    <th>PLUS</th>
                </tr>
            </thead>
            <tbody id="list_depense_page">
                <!-- <form action="" method="post">
                  <tr>
                      <td><input class="form-control" type="date" name="" id="" placeholder="" value=""></td>
                      <td><input class="form-control" type="number" name="" id="" placeholder="" value=""></td>
                      <td>
                        <select class="form-control" name="category" id="category">
                            <option value="">Selectionner Categorie</option>
                            <option value="Boss">Boss</option>
                            <option value="Mere Boss">Mere Boss</option>
                            <option value="Boulangerie">Boulangerie</option>
                            <option value="Chantier Boss">Chantier Boss</option>
                            <option value="Beni">Beni</option>
                            <option value="Ingeniere">Ingeniere</option>
                        </select>
                      </td>
                      <td><input class="form-control" type="text" name="" id="" placeholder="" value=""></td>
                      <td>
                        <button class="btn btn-info mt-1 text-white w-100" type="submit">Modifier</button>
                        <button class="btn btn-danger mt-1 text-white w-100" type="submit">Supprimer</button>
                      </td>
                  </tr>
                </form> -->
            </tbody>
        </table>
    </div>
  </div>
</div>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
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