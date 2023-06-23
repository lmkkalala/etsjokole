<?php
include './meta/menu_logistique.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-4 text-start mt-3 mb-3">
            <h3 class="text-primary fw-bolder">BORDEREAU D'EXPEDITION</h3>
        </div>
        <div class="col-md-8 col-sm-12 mt-3 mb-3 text-end">
            <button class="btn btn-primary text-white" type="button"  data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                <i class="fa fa-book"></i> NOUVEL OPERATION
            </button>
        </div>
        <div class="row" id="list_bordereau">
        <!-- <div class="col-4 p-4 rounded-start bg-primary">
            <table class="display" style="width:100%;color:white">
                <form action="" method="post" id="">
                    <tbody>
                        <div class="row">
                            <div class="col-6">
                                <tr>
                                    <th class="small">DATE</th>
                                    <td><input class="form-control" type="date" name="" id="" placeholder="" value="" required></td>
                                </tr>
                                <tr>
                                    <th class="small">NUMERO BORDEREAU</th>
                                    <td><input class="form-control" type="number" name="" id="" placeholder="" value="" required></td>
                                </tr>
                                <tr>
                                    <th class="small">EXPEDITEUR</th>
                                    <td><input class="form-control" type="text" name="" id="" placeholder="" value="" required></td>
                                </tr>
                                <tr>
                                    <th class="small">DESTINATAIRE</th>
                                    <td><input class="form-control" type="text" name="" id="" placeholder="" value="" required></td>
                                </tr>
                                <tr>
                                    <th class="small">TRANSPORTEUR</th>
                                    <td><input class="form-control" type="text" name="" id="" placeholder="" value="" required></td>
                                </tr>
                                <tr>
                                    <th class="small">TELEPHONE</th>
                                    <td><input class="form-control" type="tel" name="" id="" placeholder="" value="" required></td>
                                </tr>
                                <tr>
                                    <th class="small">N° PLAQUE</th>
                                    <td><input class="form-control" type="text" name="" id="" placeholder="" value="" required></td>
                                </tr>
                                <tr>
                                    <th class="small">N° COLIS</th>
                                    <td><input class="form-control" type="text" name="" id="" placeholder="" value="" required></td>
                                </tr>
                                <tr>
                                    <th class="small">NATURE EMBALLAGE</th>
                                    <td><input class="form-control" type="text" name="" id="" placeholder="" value="" required></td>
                                </tr>
                                <tr>
                                    <th class="small">CONTENU</th>
                                    <td><input class="form-control" type="text" name="" id="" placeholder="" value="" required></td>
                                </tr>
                                <tr>
                                    <th class="small">PDS UN KG</th>
                                    <td><input class="form-control" type="text" name="" id="" placeholder="" value="" required></td>
                                </tr>
                                <tr>
                                    <th class="small">PDS TOT TONE</th>
                                    <td><input class="form-control" type="text" name="" id="" placeholder="" value="" required></td>
                                </tr>
                                <tr>
                                    <th class="small">PU TONE</th>
                                    <td><input class="form-control" type="text" name="" id="" placeholder="" value="" required></td>
                                </tr>
                                <tr>
                                    <th class="small">PT TONE</th>
                                    <td><input class="form-control" type="text" name="" id="" placeholder="" value="" required></td>
                                </tr>
                                <tr>
                                    <th class="small">MANQUE</th>
                                    <td><input class="form-control" type="text" name="" id="" placeholder="" value="" required></td>
                                </tr>
                                <tr>
                                    <th class="small">QTE ARRIVEE</th>
                                    <td><input class="form-control" type="text" name="" id="" placeholder="" value="" required></td>
                                </tr>
                                <tr>
                                    <th class="small">AVANCE/DEPENSE</th>
                                    <td><input class="form-control" type="text" name="" id="" placeholder="" value="" required></td>
                                </tr>
                                <tr>
                                    <th class="small">RESTE PAYER</th>
                                    <td><input class="form-control" type="text" name="" id="" placeholder="" value="" required></td>
                                </tr>
                                <tr>
                                    <th class="small">PAYEMENT</th>
                                    <td><input class="form-control" type="text" name="" id="" placeholder="" value="" required></td>
                                </tr>
                                <tr>
                                    <th class="small">SOLDE</th>
                                    <td><input class="form-control" type="text" name="" id="" placeholder="" value="" required></td>
                                </tr>
                            </div>
                            <div class="col-12">
                                <tr>
                                    <td><button class="btn btn-danger mt-1 text-white w-100" type="submit">Supprimer</button></td>
                                    <td><button class="btn btn-info mt-1 bg-white text-primary w-100" type="submit">Modifier</button></td>
                                </tr>
                            </div>
                        </div>
                    </form>
                </tbody>
            </table>
        </div> -->
        </div>
    </div>
</div>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">BORDEREAU</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="" method="post" id="bordereau_expedition_form">
                    <tbody id="list_bordereau_page">
                        <tr>
                            <th class="small">DATE</th>
                            <td><input class="form-control" type="date" name="date" id="date" placeholder="" value="" required></td>
                        </tr>
                        <tr>
                            <th class="small">NUMERO BORDEREAU</th>
                            <td><input class="form-control" type="number" name="n_bordereau" id="n_bordereau" placeholder="" value="" required></td>
                        </tr>
                        <tr>
                            <th class="small">EXPEDITEUR</th>
                            <td><input class="form-control" type="text" name="expediteur" id="expediteur" placeholder="" value="" required></td>
                        </tr>
                        <tr>
                            <th class="small">DESTINATAIRE</th>
                            <td><input class="form-control" type="text" name="destinateur" id="destinateur" placeholder="" value="" required></td>
                        </tr>
                        <tr>
                            <th class="small">TRANSPORTEUR</th>
                            <td><input class="form-control" type="text" name="transporteur" id="transporteur" placeholder="" value="" required></td>
                        </tr>
                        <tr>
                            <th class="small">TELEPHONE</th>
                            <td><input class="form-control" type="tel" name="telephone" id="telephone" placeholder="" value="" required></td>
                        </tr>
                        <tr>
                            <th class="small">N° PLAQUE</th>
                            <td><input class="form-control" type="text" name="n_plaque" id="n_plaque" placeholder="" value="" required></td>
                        </tr>
                        <tr>
                            <th class="small">N° COLIS</th>
                            <td><input class="form-control" type="text" name="n_colis" id="n_colis" placeholder="" value="" required></td>
                        </tr>
                        <tr>
                            <th class="small">NATURE EMBALLAGE</th>
                            <td>
                                <select class="form-control" name="nature_emballage" id="nature_emballage" required>
                                    <option value="">Selectionner</option>
                                    <option value="Sacs">Sacs</option>
                                    <option value="Bidons">Bidons</option>
                                    <option value="Cartons">Cartons</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th class="small">CONTENU</th>
                            <td><input class="form-control" type="text" name="contenu" id="contenu" placeholder="" value="" required></td>
                        </tr>
                        <tr>
                            <th class="small">PDS UN KG</th>
                            <td><input class="form-control" type="text" name="pds_un_kg" id="pds_un_kg" placeholder="" value="" required></td>
                        </tr>
                        <tr>
                            <th class="small">PDS TOT TONE</th>
                            <td><input class="form-control" type="text" name="pds_tot_tone" id="pds_tot_tone" placeholder="" value="" required></td>
                        </tr>
                        <tr>
                            <th class="small">PU TONE</th>
                            <td><input class="form-control" type="text" name="pu_tone" id="pu_tone" placeholder="" value="" required></td>
                        </tr>
                        <tr>
                            <th class="small">PT TONE</th>
                            <td><input class="form-control" type="text" name="pt_tone" id="pt_tone" placeholder="" value="" required></td>
                        </tr>
                        <tr>
                            <th class="small">MANQUE</th>
                            <td><input class="form-control" type="text" name="manque" id="manque" placeholder="" value="" required></td>
                        </tr>
                        <tr>
                            <th class="small">QTE ARRIVEE</th>
                            <td><input class="form-control" type="text" name="qte_arrive" id="qte_arrive" placeholder="" value="" required></td>
                        </tr>
                        <tr>
                            <th class="small">AVANCE/DEPENSE</th>
                            <td><input class="form-control" type="text" name="charge" id="charge" placeholder="" value="" required></td>
                        </tr>
                        <tr>
                            <th class="small">RESTE PAYER</th>
                            <td><input class="form-control" type="text" name="reste_payer" id="reste_payer" placeholder="" value="" required></td>
                        </tr>
                        <tr>
                            <th class="small">PAYEMENT</th>
                            <td><input class="form-control" type="text" name="payement" id="payement" placeholder="" value="" required></td>
                        </tr>
                        <tr>
                            <th class="small">SOLDE</th>
                            <td><input class="form-control" type="text" name="solde" id="solde" placeholder="" value="" required></td>
                        </tr>
                        <tr>
                            <td>
                                <input type="hidden" name="bordereau_expedition_btn" id="bordereau_expedition_btn">
                                <button class="btn btn-info mt-1 text-white w-100" id="bordereau_add" type="submit">ENREGISTRER</button>
                            </td>
                        </tr>
                    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">FERMER</button>
      </div>
    </div>
  </div>
</div>