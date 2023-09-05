
<?php
    include '../models/agent/agent.php';
    include '../models/crud/db.php';
    
    include './meta/menu_service.php';

    $db = new BdAgent();
    $BD = new DB();
    $allAgent = $db->getAgentById($_SESSION['agentID']);
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
            <h3 class="text-primary">LES FACTURES </h3>
        </div>
    
        <div class="col-md-8 mt-3">
          <form action="" method="post" id="FilterForm">
                <div class="row">
                    <div class="col-md-3">
                        <select class="form-control" name="Agent" id="Agent">
                        <option value="">Selectionner Agent</option>
                          <?php
                            foreach($allAgent as $key => $agent){
                              if ($allAgent[$key]['active'] == '1') {
                                if ($allAgent[$key]['grade'] != 'Admin' and $allAgent[$key]['grade'] != 'admin') {
                          ?>
                              <option value="<?=$allAgent[$key]['id']?>" selected><?=$allAgent[$key]['nom'].' '.$allAgent[$key]['postnom'].' '.$allAgent[$key]['prenom']?></option>
                          <?php 
                                }
                              }
                            }
                          ?>
                      </select>
                    </div>
                    <div class="col-md-3">
                      <input class="form-control" type="date" name="filterDate_start" id="filterDate_start">
                    </div>
                    <div class="col-md-3">
                      <input class="form-control" type="date" name="filterDate_end" id="filterDate_end">
                    </div>
                    <div class="col-md-3">
                    <input type="hidden" name="FilterFormFacture" id="FilterFormFacture">
                      <button class="btn btn-primary w-100 text-white" type="submit"><i class="fa fa-search"></i> Rechercher</button>
                    </div>
                </div>
          </form>
        </div>
        <div class="col-md-2 col-sm-12 mt-3 mb-3 text-end">
            <button class="btn btn-primary w-100 text-white" type="button"  data-bs-toggle="modal" data-bs-target="#staticBackdrop">PAYER FACTURE</button>
        </div>
        <div class="col-12">
            <table id="dette_list" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>DATE</th>
                        <th>AGENT</th>
                        <th>MONTANT</th>
                        <th>DESCRIPTION</th>
                        <th>SITUATION</th>
                        <th>PLUS <?=$_SESSION['agentID']?></th>
                    </tr>
                </thead>
                <tbody id="list_facture_page"></tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">NOUVELLE FACTURE</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="add_facture_form">
          <div class="row">
            <div class="col-12">
              <label for="date">Date</label>
              <input class="form-control" type="date" name="date" id="date" placeholder="" require>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <label for="date">Facture Liste</label>
              <select class="form-control" name="facture" id="facture" require>
                <option value="">Selectionner Facture</option>
                    <?php
                      $factureList = $BD->getWhereMultiple('facture','agentID = '.$_SESSION['agentID'].' and status = 0');
                      foreach($factureList as $key => $value){
                    ?>
                    <option value="<?=$factureList[$key]['id']?>"><?=' Facture du '.$factureList[$key]['date'].' de '.$factureList[$key]['montant']?></option>
              <?php
                }
              ?>
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
            <div class="col-12 mt-2">
              <input type="hidden" name="operation_new_facture" id="operation_new_facture">
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