<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../models/attribution-biens/attributionBiens.php';
include '../models/crud/db.php';
$dateStart = '';
$dateEnd = '';
?>
<div class="panel">
    <div class="panel panel-heading">
        <span class="fa fa-list-alt" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-gift" style="color: red; font-size: 30px;margin-right: 5px;"></span>
        <span class="h3">Order</span>
        <span class="glyphicon glyphicon-chevron-right" style="color: black; font-size: 30px;margin-right: 5px;"></span>
        <span class="fa fa-list-ol" style="color: forestgreen; font-size: 30px;margin-right: 5px;"></span>
        <span class="h4">List</span>
    </div>
    <?php
        $date = date('Y-m',time());
        $n = 0;
        $bdattributionbiens = new BdAttributionBiens();
        if (isset($_POST['dateStart']) and isset($_POST['dateEnd'])) {
            $produit = htmlspecialchars($_POST['produit']);
            $more = !empty($produit) ? ' AND b.designation LIKE "%'.$produit.'%" ':'';
            if(!empty($_POST['dateStart']) and !empty($_POST['dateEnd'])){
                $dateStart = htmlspecialchars($_POST['dateStart']);
                $dateEnd = htmlspecialchars($_POST['dateEnd']);
                $attributions = $bdattributionbiens->getAttributionBiensAllDesc($dateStart,$dateEnd,$more);
            }else{
                $attributions = $bdattributionbiens->getAttributionBiensAllDesc($date,'',$more);
            }
        }else{
            $attributions = $bdattributionbiens->getAttributionBiensAllDesc($date);
        }

        $db = new DB();

        if (isset($_POST['attr_id'])) {
            $etat = htmlspecialchars($_POST['etat']);
            $attr_id = htmlspecialchars($_POST['attr_id']);
            $update = $db->update('attribution','etat = ?','id = ?',[''.$etat.'',''.$attr_id.'']);
        }
    ?>
    <form action="../views/home.php?link=863075c3acf4eaf686d1c35afb50038d25af9367&link_up=1f920fef6c620c4660a748aae5dd44da9e74ba9b" method="post">
        <div class="row mt-3">
            <div class="col-3">
                <input class="form-control" type="text" name="produit" id="" placeholder="...">
            </div>
            <div class="col-3">
                <input class="form-control" type="date" name="dateStart" id="" value="<?=$dateStart?>">
            </div>
            <div class="col-3">
                <input class="form-control" type="date" name="dateEnd" id="" value="<?=$dateEnd?>">
            </div>
            <div class="col-3">
                <input class="btn btn-info" type="submit" name="rechercher" id="rechercher" value="Rechercher">
            </div>
        </div>
    </form>
    <div class="panel panel-body">
        <div>
            <fieldset>
                <legend>Orders</legend>
                <table id="list_attribution_biens_all" class="table table-bordered table-responsive-lg table-condensed">
                    <thead>
                    <th>
                        N° Commande
                    </th>
                    <th>
                        Date
                    </th>
                    
                    <th>
                        Biens/produits
                    </th>
                    <th>
                        Gestion
                    </th>
                    <th>
                        Fournisseur
                    </th>
                    <th>
                        Quantité
                    </th>
                    <th>
                        PAU
                    </th>
                    <th>
                        Délai de livraison
                    </th>
                    <th>
                        Etat
                    </th>
                    </thead>
                    <tbody>
                        <?php
                        
                        //$attributions = $bdattributionbiens->getAttributionBiensAllDesc();
                        foreach ($attributions as $attribution) {
                            $n++;

                            if ($attribution['etat']) {
                                $etat = 'Finalisée';
                                $etat_val = 0;
                                $icon_etat = "fa fa-check-square";
                                $btnStyle = 'info';
                            } else {
                                $etat_val = 1;
                                $icon_etat = "fa fa-spinner";
                                $etat = 'En cours';
                                $btnStyle = 'danger';
                            }
                            ?>
                            <tr>
                                <td width="50"><?= $attribution['numeroOrder'] ?></td>
                                <td><?= $attribution['date'] ?></td>
                                
                                <td><?= $attribution['bDesignation']." : ".$attribution['gDesignation'] ?></td>
                                <td><?= $attribution['technique_gestion'] ?></td>
                                <td><?= $attribution['fDesignation']." : ".$attribution['domaine'] ?></td>
                                <td>
                                    <?= $attribution['quantite_minimale'] ?><br>
                                    <span class="text-<?=$btnStyle?>"><?=$etat?></span>
                                </td>
                                <td><?=$attribution['aPrixUnitaire']?></td>
                                <td><?= $attribution['delai_livraison'] ?> Jour<?=($attribution['delai_livraison'] > 1)?"s":""?></td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <form action="../views/home.php?link=863075c3acf4eaf686d1c35afb50038d25af9367&link_up=1f920fef6c620c4660a748aae5dd44da9e74ba9b" method="post">
                                                <input type="hidden" name="attr_id" value="<?=$attribution['aId']?>">
                                                <input type="hidden" name="etat" value="<?=$etat_val?>">
                                                <button type="submit" name="changer_etat" class="btn btn-<?=$btnStyle?>"><i class="<?=$icon_etat?>"></i></button>
                                            </form>
                                        </div>
                                        <div class="col-md-8">
                                            <button type="button" name="payement_add" data-bs-toggle="modal" data-bs-target="#add_payment_form" class="btn btn-primary mt-1" data-id="<?=$attribution['aId']?>"><i class="fa fa-money"></i></button>
                                        </div>
                                        <div class="col-md-8">
                                            <button type="button" name="payement_list" data-bs-toggle="modal" data-bs-target="#list_payment_form" class="btn btn-secondary mt-1" data-id="<?=$attribution['aId']?>"><i class="fa fa-list-alt"></i></button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php
                            
                        }
                        ?>
                    </tbody>
                    <tfoot>
                    <td style="font-size: 20px;">
                        <span>Nombre:</span><span><?= $n ?></span>
                    </td>
                    </tfoot>
                </table>
            </fieldset>
        </div>
    </div>
</div>

<div class="modal fade" id="add_payment_form" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">AJOUTER DEPOT</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <form action="" method="post" id="add_deposit_form">
              <div class="row">
                <div class="col-md-12">
                  <label for="date" class="small fw-bolder">Date</label>
                  <input class="form-control" type="date" name="date_is" id="date_is" placeholder="" required>
                </div>
                <div class="col-md-12">
                  <label for="date" class="small fw-bolder">Transporteur</label>
                  <input class="form-control" type="text" name="transporteur" id="transporteur" placeholder="" required>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <label for="date" class="small fw-bolder">Receveur</label>
                  <input class="form-control" type="text" name="reveveur" id="reveveur" placeholder="" required>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <label for="date" class="small fw-bolder">Montant</label>
                  <input class="form-control" type="number" step="0.0000" name="montant" id="montant" placeholder="" required>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <label for="date" class="small fw-bolder">Bordereau</label>
                  <input class="form-control" type="file" name="recu" id="recu">
                </div>
              </div>
              <div class="row mt-2">
                <div class="col-md-12">
                    <input class="form-control" type="hidden" name="attribution_id" id="attribution_id">
                    <input class="form-control" type="hidden" name="save_deposit_data" id="save_deposit_data">
                    <button type="submit" class="btn btn-primary w-100 mt-2">ENREGISTRER</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">FERMER</button> -->
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="list_payment_form" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Liste depot argent sur commande</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <table id="payement_fournisseurData" class="display table" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="small">DATE</th>
                                    <th class="small">Transporteur</th>
                                    <th class="small">Receveur</th>
                                    <th class="small">Preuve</th>
                                    <th class="small">Plus</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">FERMER</button> -->
            </div>
        </div>
    </div>
</div>

