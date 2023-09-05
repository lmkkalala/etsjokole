
<?php
    include '../models/agent/agent.php';
    
    include './meta/menu_logistique.php';

    $db = new BdAgent();
    $allAgent = $db->getAgentAll();
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
        <div class="col-10 text-start mt-3 mb-3">
            <h3 class="text-primary">DETTES</h3>
        </div>
        
        <div class="col-md-2 col-sm-12 mt-3 mb-3 text-end">
            <button class="btn btn-primary w-100 text-white" type="button"  data-bs-toggle="modal" data-bs-target="#staticBackdrop">AJOUTER DETTE</button>
        </div>
        <div class="col-12 mt-3">
          <form action="" method="post" id="FilterForm">
                <div class="row">
                    <div class="col-md-2">
                        <select class="form-control" name="Agent" id="Agent">
                        <option value="">Selectionner Agent</option>
                          <?php
                            foreach($allAgent as $key => $agent){
                              if ($allAgent[$key]['active'] == '1') {
                                if ($allAgent[$key]['grade'] != 'Admin' and $allAgent[$key]['grade'] != 'admin') {
                          ?>
                              <option value="<?=$allAgent[$key]['id']?>"><?=$allAgent[$key]['nom'].' '.$allAgent[$key]['postnom'].' '.$allAgent[$key]['prenom']?></option>
                          <?php 
                                }
                              }
                            }
                          ?>
                      </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-control" name="Raison" id="Raison">
                            <option value="">Selectionner Raison</option>
                            <option value="Dette argent">Dette argent</option>
                            <option value="Dette produit">Dette produit</option>
                            <option value="Manquant">Manquant</option>
                            <option value="Amande">Amande</option>
                            <option value="Absence">Absence</option>
                            <option value="Aucun">Aucun</option>
                      </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-control" name="Operation" id="Operation">
                        <option value="">Selectionner Operation</option>
                          <option value="Dette">Dette</option>
                          <option value="Rembourser">Rembourser</option>
                      </select>
                    </div>
                    
                    <div class="col-md-2">
                      <input class="form-control" type="date" name="filterDate_start" id="filterDate_start">
                    </div>
                    <div class="col-md-2">
                      <input class="form-control" type="date" name="filterDate_end" id="filterDate_end">
                    </div>
                    <div class="col-md-2">
                    <input type="hidden" name="FilterFormDette" id="FilterFormDette">
                      <button class="btn btn-primary w-100 text-white" type="submit"><i class="fa fa-search"></i> Rechercher</button>
                    </div>
                </div>
          </form>
        </div>
        <div class="col-12  table-responsive">
            <table id="dette_list" class="table display" style="width:100%">
                <thead>
                    <tr>
                        <th>DATE</th>
                        <th>AGENT</th>
                        <th>RAISON</th>
                        <th>MONTANT</th>
                        <th>OPERATION</th>
                        <th>PLUS</th>
                    </tr>
                </thead>
                <tbody id="list_dette_page"></tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">DETTE</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="add_dette_form">
          <div class="row">
            <div class="col-12">
              <label for="date">Date</label>
              <input class="form-control" type="date" name="date" id="date" placeholder="" require>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <label for="date">Agent</label>
              <select class="form-control" name="agent" id="agent" require>
                <option value="">Selectionner agent</option>
              <?php
                foreach($allAgent as $key => $agent){
                  if ($allAgent[$key]['active'] == '1') {
                    if ($allAgent[$key]['grade'] != 'Admin' and $allAgent[$key]['grade'] != 'admin') {
              ?>
                    <option value="<?=$allAgent[$key]['id']?>"><?=$allAgent[$key]['nom'].' '.$allAgent[$key]['postnom'].' '.$allAgent[$key]['prenom']?></option>
              <?php 
                    }
                  }
                }
              ?>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <label for="date">Raison</label>
                <select class="form-control" name="raison" id="raison" require>
                  <option value="Dette argent">Dette argent</option>
                  <option value="Dette produit">Dette produit</option>
                  <option value="Manquant">Manquant</option>
                  <option value="Amande">Amande</option>
                  <option value="Absence">Absence</option>
                  <option value="Aucun">Aucun</option>
                </select>
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
              <label for="date">Montant</label>
              <input class="form-control" type="number" name="amount" id="amount" placeholder="" require>
            </div>
          </div>
          
          <div class="row">
            <div class="col-12">
              <label for="date">Operation</label>
                <select class="form-control" name="operation" id="operation" require>
                    <option value="Dette">Dette</option>
                    <option value="Rembourser">Rembourser</option>
                </select>
            </div>
          </div>

          <div class="row">
            <div class="col-12 mt-2">
              <input type="hidden" name="operation_new_dette_page" id="operation_new_dette_page">
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