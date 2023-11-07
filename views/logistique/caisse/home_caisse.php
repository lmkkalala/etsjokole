<?php
include './meta/menu_logistique.php';
include '../models/crud/db.php';
$db = new DB();
$listDriver = $db->getWhere('agent','active','1','id');
$compteBanque = $db->getWhere('comptebanque','status','1','date');
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
        <div class="col-md-2 text-start mt-3 mb-3">
            <h5 class="text-secondary fw-bolder mt-4">JOURNAL CAISSE</h5>
        </div>
        <div class="col-md-10 mt-3">
          <form action="" method="post" id="FilterForm">
            <div class="row">
                <div class="col-md-2 mt-1">
                  <input class="form-control" type="text" name="filterNom" id="filterNom" placeholder="Effectuer Par">
                </div>
                <div class="col-md-2 mt-1">
                  <input class="form-control" type="text" name="filterNomApprover" id="filterNomApprover" placeholder="Approbateur">
                </div>
                <div class="col-md-2 mt-1">
                  <input class="form-control" type="text" name="filterNBordereau" id="filterNBordereau" placeholder="N° Bordereau">
                </div>
                <div class="col-md-2 mt-1">
                  <select class="form-control" name="FilterBanque" id="FilterBanque">
                    <option value="">Selectionner Banque</option>
                    <option name="cadeco" class="uppercase">cadeco</option>
                    <?php foreach ($compteBanque as $key => $banques) { ?>
                      <option name="cadeco" value="<?=$compteBanque[$key]['n_compte']?>" class="uppercase"><?=$compteBanque[$key]['banque']?></option>
                    <?php  } ?>
                  </select>
                </div>
                <div class="col-md-2 mt-1">
                  <input class="form-control" type="date" name="filterDate_start" id="filterDate_start">
                </div>
                <div class="col-md-2 mt-1">
                  <input class="form-control" type="date" name="filterDate_end" id="filterDate_end">
                </div>
                <div class="col-md-2 mt-1">
                  <input type="hidden" name="FilterFormCaisse" id="FilterFormCaisse">
                  <button class="btn btn-secondary text-white w-100" type="submit"> <i class="fa fa-search"></i> Rechercher</button>
                </div>
                <div class="col-md-2 mt-1">
                    <button class="btn btn-secondary text-white w-100" type="button"  data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fa fa-book"></i> OPERATION</button>
                </div>
                <div class="col-md-2 mt-1">
                    <button class="btn btn-secondary text-white w-100" type="button"  data-bs-toggle="modal" data-bs-target="#banque_list"><i class="fa fa-book"></i> COMPTE</button>
                </div>
                <div class="col-md-2 mt-1">
                    <button class="btn btn-secondary text-white w-100" type="button"  data-bs-toggle="modal" data-bs-target="#banque_list_add"><i class="fa fa-book"></i> LISTE COMPTE</button>
                </div>
            </div>
          </form>
        </div>
        
        <div class="row mt-2 mb-2">
          <div class="col-md-4 bg-secondary text-start border-end border-bottom">
            <h5 class="fw-bolder text-white mt-3"><span id="dollars">0</span></h5>
          </div>
          <div class="col-md-4 bg-secondary text-start border-end border-bottom">
              <h5 class="fw-bolder text-white mt-3"><span id="fc">0</span></h5>
          </div>
          <div class="col-md-4 bg-secondary text-start">
              <h5 class="fw-bolder text-white mt-3"><span id="frw">0</span></h5>
          </div>
        </div>
        <h3>DEBIT CAISSE</h3>
        <div class="col-md-12 table-responsive" style="height: 500px;overflow:scroll;">
          <table id="caisse_list_entre" class="table display" style="width:100%">
              <thead>
                  <tr>
                      <th class="small">DATE</th>
                      <th class="small">BANQUE</th>
                      <th class="small">N° BORDEREAU</th>
                      <th class="small">DESCRIPTION</th>
                      <th class="small">DEPOT $</th>
                      <th class="small">DEPOT FC</th>
                      <th class="small">DEPOT FRW</th>
                      <th class="small">DEBITE PAR</th>
                      <th class="small">APPROUVE PAR</th>
                      <th class="small">PLUS</th>
                  </tr>
              </thead>
              <tbody></tbody>
              <!-- <tbody id="list_caisse_entre_page"></tbody> -->
          </table>
        </div>
        <h3>CREDIT CAISSE</h3>
        <div class="col-md-12 col-sm-12 mt-3">
          <form action="" method="post" id="FilterFormOther">
            <div class="row">
                <div class="col-md-2 mt-1">
                  <input class="form-control" type="text" name="filterNomCredit" id="filterNomCredit" placeholder="Effectuer Par">
                </div>
                <div class="col-md-2 mt-1">
                  <input class="form-control" type="text" name="filterNomApproverCredit" id="filterNomApproverCredit" placeholder="Approbateur">
                </div>
                <div class="col-md-2 mt-1">
                  <input class="form-control" type="text" name="filterNBordereauCredit" id="filterNBordereauCredit" placeholder="N° Bordereau">
                </div>
                <div class="col-md-2 mt-1">
                  <select class="form-control" name="FilterBanqueCredit" id="FilterBanqueCredit">
                    <option value="">Selectionner Banque</option>
                    <option name="cadeco">cadeco</option>
                    <?php foreach ($compteBanque as $key => $banques) { ?>
                      <option name="cadeco" value="<?=$compteBanque[$key]['n_compte']?>" class="uppercase"><?=$compteBanque[$key]['banque']?></option>
                    <?php  } ?>
                  </select>
                </div>
                <div class="col-md-2 mt-1">
                  <input class="form-control" type="date" name="filterDate_startCredit" id="filterDate_startCredit">
                </div>
                <div class="col-md-2 mt-1">
                  <input class="form-control" type="date" name="filterDate_endCredit" id="filterDate_endCredit">
                </div>
                <div class="col-md-2 mt-1">
                  <input type="hidden" name="FilterFormCaisseCredit" id="FilterFormCaisseCredit">
                  <button class="btn btn-secondary text-white w-100" type="submit"> <i class="fa fa-search"></i> Rechercher</button>
                </div>
            </div>
          </form>
        </div>
        <div class="col-12 mt-3 table-responsive" style="height: 500px;overflow:scroll;">
            <table id="caisse_list_sortie" class="display table" style="width:100%">
              <thead>
                <tr>
                  <th class="small">DATE</th>
                  <th class="small">BANQUE</th>
                  <th class="small">N° BORDEREAU</th>
                  <th class="small">DESCRIPTION</th>
                  <th class="small">RETRAIT $</th>
                  <th class="small">RETRAIT FC</th>
                  <th class="small">RETRAIT FRW</th>
                  <th class="small">CREDITE PAR</th>
                  <th class="small">APPROUVE PAR</th>
                  <th class="small">PLUS</th>
                </tr>
              </thead>
            <tbody></tbody>
            <!-- <tbody id="list_caisse_sortie_page"></tbody> -->
          </table>
        </div>
    </div>
</div>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">CAISSE</h1>
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
              <label for="date" class="small fw-bolder">Banque</label>
              <select class="form-control" name="banque" id="banque" required>
                <option value="">Selectionner Banque</option>
                <option name="cadeco" class="uppercase">cadeco</option>
                <?php foreach ($compteBanque as $key => $banques) { ?>
                      <option name="cadeco" value="<?=$compteBanque[$key]['n_compte']?>" class="uppercase"><?=$compteBanque[$key]['banque']?></option>
                    <?php  } ?>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <label for="date" class="small fw-bolder">Numero Bordereau</label>
              <input class="form-control" type="number" name="nBordereau" id="nBordereau" placeholder="" required>
            </div>
            <div class="col-6">
              <label for="date" class="small fw-bolder">Operation</label>
              <select class="form-control" name="operation" id="operation" required>
                <option value="">Selectionner Operation</option>
                <option value="Debiter">Debiter</option>
                <option value="Crediter">Crediter</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label for="date" class="small fw-bolder">Description</label>
              <input class="form-control" type="text" name="description" id="description" placeholder="" required>
            </div>
          </div>
          <div class="row" id="champ_depot">
            <div class="col-md-4">
              <label for="date" class="small fw-bolder">Montant deposé $</label>
              <input class="form-control" type="text" name="depotDollars" id="depotDollars" placeholder="" value="0">
            </div>
            <div class="col-md-4">
              <label for="date" class="small fw-bolder">Montant deposé FC</label>
              <input class="form-control" type="text" name="depotFC" id="depotFC" placeholder="" value="0">
            </div>
            <div class="col-md-4">
              <label for="date" class="small fw-bolder">Montant deposé FRW</label>
              <input class="form-control" type="text" name="depotFRW" id="depotFRW" placeholder="" value="0">
            </div>
          </div>
          <div class="row" id="champ_retrait">
            <div class="col-md-4">
              <label for="date" class="small fw-bolder">Montant retiré $</label>
              <input class="form-control" type="text" name="retraitDollars" id="retraitDollars" placeholder="" value="0">
            </div>
            <div class="col-md-4">
              <label for="date" class="small fw-bolder">Montant retiré FC</label>
              <input class="form-control" type="text" name="retraitFC" id="retraitFC" placeholder="" value="0">
            </div>
            <div class="col-md-4">
              <label for="date" class="small fw-bolder">Montant retiré FRW</label>
              <input class="form-control" type="text" name="retraitFRW" id="retraitFRW" placeholder="" value="0">
            </div>
          </div>
          <div class="row">
            <div class="col-md-6" id="depotParDiv">
              <label for="date" class="small fw-bolder">Debiter Par</label>
              <input class="form-control" type="text" name="depotPar" id="depotPar" placeholder="">
            </div>
            <div class="col-md-6" id="creditParDiv">
              <label for="date" class="small fw-bolder">Crediter Par</label>
              <input class="form-control" type="text" name="creditPar" id="creditPar" placeholder="">
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label for="date" class="small fw-bolder">Approuver Par</label>
              <input class="form-control" type="text" name="approuverPar" id="approuverPar" placeholder="" required>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-md-12">
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

<div class="modal fade" id="banque_list_add" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">AJOUTER DES BANQUES</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <form action="" method="post" id="add_banque_form">
              <div class="row">
                <div class="col-md-12">
                  <label for="date" class="small fw-bolder">Date</label>
                  <input class="form-control" type="date" name="dateCompte" id="dateCompte" placeholder="" required>
                </div>
                <div class="col-md-12">
                  <label for="date" class="small fw-bolder">Banque</label>
                  <input class="form-control" type="text" name="Banque" id="Banque" placeholder="" required>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <label for="date" class="small fw-bolder">Numero COMPTE</label>
                  <input class="form-control" type="text" name="nCompte" id="nCompte" placeholder="" required>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <label for="date" class="small fw-bolder">Description</label>
                  <textarea class="form-control" type="text" name="descriptionBanque" id="descriptionBanque" placeholder="" required></textarea>
                </div>
              </div>
              <div class="row mt-2">
                <div class="col-md-12">
                    <input type="hidden" name="add_banque" id="add_banque">
                    <button type="submit" class="btn btn-primary w-100">ENREGISTRER</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">FERMER</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="banque_list" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">LIST DES BANQUES</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
          <table id="banque_table" class="display table" style="width:100%">
              <thead>
                <tr>
                  <th class="small">DATE</th>
                  <th class="small">BANQUE/N°COMPTE</th>
                  <th class="small">DESCRIPTION</th>
                  <th class="small">PLUS</th>
                </tr>
              </thead>
            <tbody></tbody>
          </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">FERMER</button>
      </div>
    </div>
  </div>
</div>