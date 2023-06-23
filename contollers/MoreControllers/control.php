<?php

session_start();

include '../../models/connexion.php';

include '../../models/crud/db.php';
    
function add($table,$field,$prepared,$value){
    $DB = new db();
    return $DB->insert($table,$field,$prepared,$value);
}

function securise($donnee) {
    $donnee = trim($donnee);
    $donnee = stripslashes($donnee);
    $donnee = strip_tags($donnee);
    return $donnee;
}

if(isset($_GET['code']) and $_GET['code'] == sha1('loadDataList')){
    if (isset($_POST['filterCategorie'])) {
        
    }

    if (isset($_POST['filterDate_start'])) {
        
    }

    if (isset($_POST['filterDate_end'])) {
        
    }

    $DB = new db();
    $allAgent = $DB->get('agent');
    $select = '';
    foreach($allAgent as $key => $agent){
        if ($allAgent[$key]["active"] == "1") {
            if ($allAgent[$key]["grade"] != "Admin" and $allAgent[$key]["grade"] != "admin") {  
            $select = $select."<option value=".$allAgent[$key]['id'].">".$allAgent[$key]['nom']."".$allAgent[$key]['postnom']."".$allAgent[$key]['prenom']."</option>";
            }
        }
    }

    $detteTotal = 0;
    $rembourserTotal = 0;
    if ($_SESSION['type'] == 'logistique') {
        $listDette = $DB->get('dette','id');
    }else{
        $listDette = $DB->getWhere('dette','addedbyID',$_SESSION['type'],'id');
    }
    $listDetteData = '';
    foreach ($listDette as $key => $value) {
        if ($listDette[$key]['operation'] == 'Dette') {
            $detteTotal = $detteTotal + $listDette[$key]['montant'];
        }
        if ($listDette[$key]['operation'] == 'Rembourser') {
            $rembourserTotal = $rembourserTotal + $listDette[$key]['montant'];
        }
        $agent = $DB->getWhere('agent','id',$listDette[$key]['agentID']);
        $fullName = $agent[0]['nom'].' '.$agent[0]['postnom'].' '.$agent[0]['prenom'];
        $listDetteData = $listDetteData.'<form action="" method="post" id="">
        <tr>
        <td>
            <input class="form-control" type="date" name="" id=""  placeholder="yyyy-MM-dd" value="'.$listDette[$key]['date'].'">
        </td>
        <td>
            <select class="form-control" name="" id="">
            <option value="'.$listDette[$key]['agentID'].'">'.$fullName.'</option>'.$select.'
            </select>
        </td>
        <td>
            <select class="form-control" name="" id="">
                <option value="'.$listDette[$key]['raison'].'">'.$listDette[$key]['raison'].'</option>
                <option value="Dette argent">Dette argent</option>
                <option value="Dette produit">Dette produit</option>
                <option value="Manquant">Manquant</option>
                <option value="Amande">Amande</option>
                <option value="Absence">Absence</option>
                <option value="Aucun">Aucun</option>
            </select>
        </td>
        <td><input class="form-control" type="number" name="" id="" placeholder="" value="'.$listDette[$key]['montant'].'"></td>
        <td>
            <select class="form-control" name="" id="">
                <option value="'.$listDette[$key]['operation'].'">'.$listDette[$key]['operation'].'</option>
                <option value="Dette">Dette</option>
                <option value="Rembourser">Rembourser</option>
            </select>
        </td>
        <td>
            <button class="btn btn-primary mt-1 text-white w-100" type="submit">Modifier</button>
            <button class="btn btn-danger mt-1 text-white w-100" type="submit">Supprimer</button>
        </td>
        </tr>
    </form>';
    }
    $listDetteData = $listDetteData.
    '<tr>
    <td class="fw-bolder">MONTANT DETTE</td>
    <td class="h3 fw-bolder bg-primary text-white p-2">'.$detteTotal.'</td>
    <td class="fw-bolder">MONTANT REMBOURSER</td>
    <td class="h3 fw-bolder bg-primary text-white p-2">'.$rembourserTotal.'</td>
    <td class="fw-bolder">RESTE A PAYER</td>
    <td class="h3 fw-bolder bg-primary text-white p-2">'.$detteTotal-$rembourserTotal.'</td>
    </tr>';

    if ($_SESSION['type'] == 'logistique') {
        $listDepense = $DB->get('depense','id');
    }else{
        $listDepense = $DB->getWhere('depense','addedbyID',$_SESSION['type'],'id');
    }
    $listDepenseData = '';
    $depenseTotal = 0;
    foreach ($listDepense as $key => $value) {
    $depenseTotal = $depenseTotal + $listDepense[$key]['montant'];
    $listDepenseData = $listDepenseData.
    '<form action="" method="post" id="DepenseUpdateForm_'.$listDepense[$key]['id'].'">
        <tr>
            <td><input class="form-control" type="date" name="DepenseUpdateName_'.$listDepense[$key]['id'].'" id="DepenseUpdateName_'.$listDepense[$key]['id'].'"  placeholder="yyyy-MM-dd" value="'.$listDepense[$key]['date'].'"></td>
            <td><input class="form-control" type="number" name="DepenseUpdateAmount_'.$listDepense[$key]['id'].'" id="DepenseUpdateAmount_'.$listDepense[$key]['id'].'" placeholder="" value="'.$listDepense[$key]['montant'].'"></td>
            <td>
                <select class="form-control" name="DepenseUpdateCategorie_'.$listDepense[$key]['id'].'" id="DepenseUpdateCategorie_'.$listDepense[$key]['id'].'" required>
                    <option value="'.$listDepense[$key]['categorieDepense'].'">'.$listDepense[$key]['categorieDepense'].'</option>
                    <option value="Boss">Boss</option>
                    <option value="Mere Boss">Mere Boss</option>
                    <option value="Boulangerie">Boulangerie</option>
                    <option value="Chantier Boss">Chantier Boss</option>
                    <option value="Beni">Beni</option>
                    <option value="Ingeniere">Ingeniere</option>
                </select>
            </td>
            <td><input class="form-control" type="text" name="DepenseUpdateDescription_'.$listDepense[$key]['id'].'" id="DepenseUpdateDescription_'.$listDepense[$key]['id'].'" placeholder="" value="'.$listDepense[$key]['description'].'"></td>
            <td>
            <button class="btn btn-primary mt-1 text-white w-100" type="submit">Modifier</button>
            <button class="btn btn-danger mt-1 text-white w-100" type="submit">Supprimer</button>
            </td>
        </tr>
    </form>';
    }
    $listDepenseData = $listDepenseData.
    '<tr>
    <td class="fw-bolder">MONTANT TOTAL DEPENSE</td>
    <td></td>
    <td></td>
    <td></td>
    <td class="h4 fw-bolder bg-primary text-white p-2">'.$depenseTotal.'</td>
    </tr>';

    $listCaisse = $DB->getWhere('caisse','operation','Debiter','id');
    $listCaisseData = '';
    $totalDebitDollars = 0;
    $totalDebitFc = 0;
    $totalDebitFrw = 0;
    foreach ($listCaisse as $key => $value) {

        $totalDebitDollars = $totalDebitDollars + $listCaisse[$key]['montantDeposeDollars'];
        $totalDebitFc = $totalDebitFc + $listCaisse[$key]['montantDeposeFC'];
        $totalDebitFrw = $totalDebitFrw + $listCaisse[$key]['montantDeposeFRW'];
        
        $listCaisseData = $listCaisseData.'
        <form action="" method="post" id="CaisseUpdateForm_'.$listCaisse[$key]['id'].'">
        <tr>
            <td><input class="form-control" type="date" name="" id="" placeholder="" value="'.$listCaisse[$key]['date'].'" placeholder="yyyy-MM-dd"></td>
            <td><input class="form-control" type="text" name="" id="" placeholder="" value="'.$listCaisse[$key]['banque'].'"></td>
            <td><input class="form-control" type="number" name="" id="" placeholder="" value="'.$listCaisse[$key]['nBordereau'].'"></td>
            <td><input class="form-control" type="text" name="" id="" placeholder="" value="'.$listCaisse[$key]['description'].'"></td>
            <td><input class="form-control" type="number" name="" id="" placeholder="" value="'.$listCaisse[$key]['montantDeposeDollars'].'"></td>
            <td><input class="form-control" type="number" name="" id="" placeholder="" value="'.$listCaisse[$key]['montantDeposeFC'].'"></td>
            <td><input class="form-control" type="text" name="" id="" placeholder="" value="'.$listCaisse[$key]['montantDeposeFRW'].'"></td>
            <td><input class="form-control" type="text" name="" id="" placeholder="" value="'.$listCaisse[$key]['debitePar'].'"></td>
            <td><input class="form-control" type="text" name="" id="" placeholder="" value="'.$listCaisse[$key]['approuverPar'].'"></td>
            <td>
                <button class="btn btn-primary mt-1 text-white w-100" type="submit">Modifier</button>
                <button class="btn btn-danger mt-1 text-white w-100" type="submit">Supprimer</button>
            </td>
        </tr>
    </form>';
    }
    $listCaisseData = $listCaisseData.
    '<tr class="bg-warning text-white">
        <td>TOTAL DEBIT Dollors</td>
        <td></td>
        <td>'.$totalDebitDollars.'</td>
        <td>TOTAL DEBIT FC</td>
        <td></td>
        <td>'.$totalDebitFc.'</td>
        <td>TOTAL DEBIT FRW</td>
        <td></td>
        <td></td>
        <td>'.$totalDebitFrw.'</td>
    </tr>
    ';

    $listCaisseSortie = $DB->getWhere('caisse','operation','Crediter','id');
    $listCaisseDataSortie = '';
    $totalCreditDollars = 0;
    $totalCreditFc = 0;
    $totalCreditFrw = 0;

    foreach ($listCaisseSortie as $key => $value) {
        $totalCreditDollars = $totalCreditDollars + $listCaisseSortie[$key]['montantRetireDollars'];
        $totalCreditFc = $totalCreditFc + $listCaisseSortie[$key]['montantRetireFC'];
        $totalCreditFrw = $totalCreditFrw + $listCaisseSortie[$key]['montantRetireFRW'];
        $listCaisseDataSortie = $listCaisseDataSortie.'
        <form action="" method="post" id="CaisseUpdateForm_'.$listCaisseSortie[$key]['id'].'">
        <tr>
            <td><input class="form-control" type="date" name="" id="" placeholder="" value="'.$listCaisseSortie[$key]['date'].'" placeholder="yyyy-MM-dd"></td>
            <td><input class="form-control" type="text" name="" id="" placeholder="" value="'.$listCaisseSortie[$key]['banque'].'"></td>
            <td><input class="form-control" type="number" name="" id="" placeholder="" value="'.$listCaisseSortie[$key]['nBordereau'].'"></td>
            <td><input class="form-control" type="text" name="" id="" placeholder="" value="'.$listCaisseSortie[$key]['description'].'"></td>
            <td><input class="form-control" type="text" name="" id="" placeholder="" value="'.$listCaisseSortie[$key]['montantRetireDollars'].'"></td>
            <td><input class="form-control" type="text" name="" id="" placeholder="" value="'.$listCaisseSortie[$key]['montantRetireFC'].'"></td>
            <td><input class="form-control" type="text" name="" id="" placeholder="" value="'.$listCaisseSortie[$key]['montantRetireFRW'].'"></td>
            <td><input class="form-control" type="text" name="" id="" placeholder="" value="'.$listCaisseSortie[$key]['creditePar'].'"></td>
            <td><input class="form-control" type="text" name="" id="" placeholder="" value="'.$listCaisseSortie[$key]['approuverPar'].'"></td>
            <td>
                <button class="btn btn-primary mt-1 text-white w-100" type="submit">Modifier</button>
                <button class="btn btn-danger mt-1 text-white w-100" type="submit">Supprimer</button>
            </td>
        </tr>
    </form>';
    }

    $listCaisseDataSortie = $listCaisseDataSortie.
    '
    <tr class="bg-warning text-white">
        <td>TOTAL CREDIT Dollors</td>
        <td></td>
        <td>'.$totalCreditDollars.'</td>
        <td>TOTAL CREDIT FC</td>
        <td></td>
        <td>'.$totalCreditFc.'</td>
        <td>TOTAL CREDIT FRW</td>
        <td></td>
        <td></td>
        <td>'.$totalCreditFrw.'</td>
    </tr>
    ';

    $listConducteur = $DB->getWhere('agent','grade','driver','id');
    $listConducteurData = '';
    foreach ($listConducteur as $key => $value) {
    if ($listConducteur[$key]['active'] == '1') {
        $listConducteurData = $listConducteurData.
    '<form action="" method="post" id="driver_list_data_form">
    <tr>
        <td>
            <input class="form-control" type="text" name="name" id="name" value="'.$listConducteur[$key]['nom'].'">
        </td>
        <td>
            <input class="form-control" type="text" name="postname" id="postname" value="'.$listConducteur[$key]['postnom'].'">
        </td>
        <td>
            <input class="form-control" type="text" name="presname" id="presname" value="'.$listConducteur[$key]['prenom'].'">
        </td>
        <td>
            <input class="form-control" type="text" name="numero_permis" id="numero_permis" value="'.$listConducteur[$key]['numeroPermisConduire'].'">
        </td>
        <td>
            <input class="form-control" type="text" name="numero_permis" id="numero_permis" value="'.$listConducteur[$key]['datenaiss'].'">
        </td>
        <td>
            <input class="form-control" type="text" name="numero_permis" id="numero_permis" value="'.$listConducteur[$key]['dateengagement'].'">
        </td>
        <td>
            <select class="form-control" name="genre" id="genre" >
                <option value="'.$listConducteur[$key]['sexe'].'">'.$listConducteur[$key]['sexe'].'</option>
                <option name="" value="H">H</option>
                <option name="" value="F">F</option>
            </select>
        </td>
        <td>
            <input class="form-control" type="tel" name="phone" id="phone" value="'.$listConducteur[$key]['telephone'].'">
        </td>
        <td>
            <button type="submit" class="btn btn-primary"><i class="fa fa-pencil"></i></button>
            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
        </td>
    </tr>
    </form>';
        }
    }

    $conducteurList = '';
    foreach ($listConducteur as $key3 => $value) {
        if ($listConducteur[$key3]['active'] == '1') {
            $conducteurList = $conducteurList.
            '<option value="'.$listConducteur[$key3]['id'].'">'.$listConducteur[$key3]['nom'].' '.$listConducteur[$key3]['postnom'].' '.$listConducteur[$key3]['prenom'].'</option>';
        }
    }

    $listVehicule = $DB->get('vehicule','id');
    $listVehiculeData = '';
    $conducteurNames = '';
    $conducteurID = '';
    foreach ($listVehicule as $key => $value) {
        foreach ($listConducteur as $key2 => $value) {
            if ($listConducteur[$key2]['id'] == $listVehicule[$key]['conducteurID']) {
                $conducteurID =  $listVehicule[$key]['conducteurID'];
                $conducteurNames =  $listConducteur[$key2]['nom'].' '.$listConducteur[$key2]['postnom'].' '.$listConducteur[$key2]['prenom'];
            }
        }
        $listVehiculeData = $listVehiculeData.
        '<form action="" method="post" id="vehicule_list_form_data">
        <tr>
            <td>
                <input class="form-control" type="date" name="date" id="date" value="'.$listVehicule[$key]['date'].'">
            </td>
            <td>
                <input class="form-control" type="tel" name="phone" id="phone" value="'.$listVehicule[$key]['plaqueVehicule'].'">
            </td>
            <td>
                <input class="form-control" type="tel" name="phone" id="phone" value="'.$listVehicule[$key]['typeVehicule'].'">
            </td>
            <td>
                <input class="form-control" type="tel" name="phone" id="phone" value="'.$listVehicule[$key]['marqueVehicule'].'">
            </td>
            <td>
                <input class="form-control" type="tel" name="phone" id="phone" value="'.$listVehicule[$key]['couleurVehicule'].'">
            </td>
            <td>
                <select class="form-control" name="genre" id="genre" >
                    <option value="'.$conducteurID.'">'.$conducteurNames.'</option>'.$conducteurList.'
                </select>
            </td>
            <td>
                <button type="submit" class="btn btn-primary"><i class="fa fa-pencil"></i></button>
                <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
            </td>
        </tr>
        </form>';
    }
    $typeDepense = $DB->get('typedepense','id');
    $typeDepenseData = '';
    foreach ($typeDepense as $key => $value) {
    $typeDepenseData = $typeDepenseData.'<form action="" method="post" id="">
        <tr>
            <td>
                <input class="form-control" type="date" name="type_depense_date_update" id="type_depense_date_update" value="'.$typeDepense[$key]['date'].'">
            </td>
            <td>
                <input class="form-control" type="text" name="type_depense_description_update" id="type_depense_description_update" value="'.$typeDepense[$key]['description'].'">
            </td>
            <td>
                <input class="form-control" type="text" name="type_depense_montant_update" id="type_depense_montant_update" value="'.$typeDepense[$key]['montant'].'">
            </td>
            <td>
                <button type="submit" class="btn btn-primary"><i class="fa fa-pencil"></i></button>
                <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
            </td>
        </tr>
    </form>';
    }

    $listBordereau = $DB->get('bordereau','id');
    $listBordereauData = '';
    foreach ($listBordereau as $key => $value) {
    $listBordereauData = $listBordereauData.
    '<div class="col-4 p-4 rounded-start bg-primary me-1">
    <table class="display" style="width:100%;color:white">
        <form action="" method="post"  id="list_bordereau_form">
            <tbody>
                <div class="row">
                    <div class="col-6">
                        <tr>
                            <th class="small">DATE</th>
                            <td><input class="form-control" type="date" name="" id="" placeholder="" value="'.$listBordereau[$key]['date'].'" required></td>
                        </tr>
                        <tr>
                            <th class="small">NUMERO BORDEREAU</th>
                            <td><input class="form-control" type="number" name="" id="" placeholder="" value="'.$listBordereau[$key]['nBordereau'].'" required></td>
                        </tr>
                        <tr>
                            <th class="small">EXPEDITEUR</th>
                            <td><input class="form-control" type="text" name="" id="" placeholder="" value="'.$listBordereau[$key]['expediteur'].'" required></td>
                        </tr>
                        <tr>
                            <th class="small">DESTINATAIRE</th>
                            <td><input class="form-control" type="text" name="" id="" placeholder="" value="'.$listBordereau[$key]['destinateur'].'" required></td>
                        </tr>
                        <tr>
                            <th class="small">TRANSPORTEUR</th>
                            <td><input class="form-control" type="text" name="" id="" placeholder="" value="'.$listBordereau[$key]['transporteur'].'" required></td>
                        </tr>
                        <tr>
                            <th class="small">TELEPHONE</th>
                            <td><input class="form-control" type="tel" name="" id="" placeholder="" value="'.$listBordereau[$key]['telephone'].'" required></td>
                        </tr>
                        <tr>
                            <th class="small">N° PLAQUE</th>
                            <td><input class="form-control" type="text" name="" id="" placeholder="" value="'.$listBordereau[$key]['nPlaque'].'" required></td>
                        </tr>
                        <tr>
                            <th class="small">N° COLIS</th>
                            <td><input class="form-control" type="text" name="" id="" placeholder="" value="'.$listBordereau[$key]['nColis'].'" required></td>
                        </tr>
                        <tr>
                            <th class="small">NATURE EMBALLAGE</th>
                            <td><input class="form-control" type="text" name="" id="" placeholder="" value="'.$listBordereau[$key]['natureEmballage'].'" required></td>
                        </tr>
                        <tr>
                            <th class="small">CONTENU</th>
                            <td><input class="form-control" type="text" name="" id="" placeholder="" value="'.$listBordereau[$key]['contenu'].'" required></td>
                        </tr>
                        <tr>
                            <th class="small">PDS UN KG</th>
                            <td><input class="form-control" type="text" name="" id="" placeholder="" value="'.$listBordereau[$key]['pdsUnKg'].'" required></td>
                        </tr>
                        <tr>
                            <th class="small">PDS TOT TONE</th>
                            <td><input class="form-control" type="text" name="" id="" placeholder="" value="'.$listBordereau[$key]['pdsTotalTone'].'" required></td>
                        </tr>
                        <tr>
                            <th class="small">PU TONE</th>
                            <td><input class="form-control" type="text" name="" id="" placeholder="" value="'.$listBordereau[$key]['puTone'].'" required></td>
                        </tr>
                        <tr>
                            <th class="small">PT TONE</th>
                            <td><input class="form-control" type="text" name="" id="" placeholder="" value="'.$listBordereau[$key]['ptTone'].'" required></td>
                        </tr>
                        <tr>
                            <th class="small">MANQUE</th>
                            <td><input class="form-control" type="text" name="" id="" placeholder="" value="'.$listBordereau[$key]['manque'].'" required></td>
                        </tr>
                        <tr>
                            <th class="small">QTE ARRIVEE</th>
                            <td><input class="form-control" type="text" name="" id="" placeholder="" value="'.$listBordereau[$key]['qteArriver'].'" required></td>
                        </tr>
                        <tr>
                            <th class="small">AVANCE/DEPENSE</th>
                            <td><input class="form-control" type="text" name="" id="" placeholder="" value="'.$listBordereau[$key]['charge'].'" required></td>
                        </tr>
                        <tr>
                            <th class="small">RESTE PAYER</th>
                            <td><input class="form-control" type="text" name="" id="" placeholder="" value="'.$listBordereau[$key]['restePayer'].'" required></td>
                        </tr>
                        <tr>
                            <th class="small">PAYEMENT</th>
                            <td><input class="form-control" type="text" name="" id="" placeholder="" value="'.$listBordereau[$key]['payement'].'" required></td>
                        </tr>
                        <tr>
                            <th class="small">SOLDE</th>
                            <td><input class="form-control" type="text" name="" id="" placeholder="" value="'.$listBordereau[$key]['solde'].'" required></td>
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
</div>';
    }

    echo json_encode(array('htmlDettePage'=>$listDetteData,'htmlDepensePage'=>$listDepenseData,'htmlConducteurPage'=>array('listConducteur'=>$listConducteurData,'listVehicule'=>$listVehiculeData,'listTypeDepense'=>$typeDepenseData,'listBordereau'=>$listBordereauData),'htmlCaissePage'=>array('entre'=>$listCaisseData,'sortie'=>$listCaisseDataSortie)));
}

    if (isset($_POST['save_new_depense'])) {
        $table = 'depense';
        $field = '(date,montant,categorieDepense,description,addedbyID)';
        $prepared = '?,?,?,?,?';
        $value = array(
            securise($_POST['date']),
            securise($_POST['amount']),
            securise($_POST['category']),
            securise($_POST['description']),
            $_SESSION['idutilisateur']
        );
        if (add($table,$field,$prepared,$value) == true) {
            echo json_encode(array('msg'=>'La depense a été ajouté','status'=>'success'));
        }else{
            echo json_encode(array('msg'=>'Echecs d\'opération ...','status'=>'fail'));
        }   
    }

    if (isset($_POST['bordereau_expedition_btn'])) {
        $table = 'bordereau';
        $field = '(date,nBordereau,expediteur,destinateur,transporteur,telephone,nPlaque,nColis,natureEmballage,contenu,pdsUnKg,pdsTotalTone,puTone,ptTone,manque,qteArriver,charge,restePayer,payement,solde,addedbyID)';
        $prepared = '?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?';
        $value = array(
            securise($_POST['date']),
            securise($_POST['n_bordereau']),
            securise($_POST['expediteur']),
            securise($_POST['destinateur']),
            securise($_POST['transporteur']),
            securise($_POST['telephone']),
            securise($_POST['n_plaque']),
            securise($_POST['n_colis']),
            securise($_POST['nature_emballage']),
            securise($_POST['contenu']),
            securise($_POST['pds_un_kg']),
            securise($_POST['pds_tot_tone']),
            securise($_POST['pu_tone']),
            securise($_POST['pt_tone']),
            securise($_POST['manque']),
            securise($_POST['qte_arrive']),
            securise($_POST['charge']),
            securise($_POST['reste_payer']),
            securise($_POST['payement']),
            securise($_POST['solde']),
            $_SESSION['idutilisateur']
        );
        if (add($table,$field,$prepared,$value) == true) {
            echo json_encode(array('msg'=>'L\'opération a été effectue','status'=>'success'));
        }else{
            echo json_encode(array('msg'=>'Echecs d\'opération ...','status'=>'fail'));
        }   
    }

    if (isset($_POST['type_depense_btn'])) {
        $table = 'typedepense';
        $field = '(date,description,montant,addedbyID)';
        $prepared = '?,?,?,?';
        $value = array(
            securise(date('Y-m-d')),
            securise($_POST['description_type_depense']),
            securise($_POST['montant_type_depense']),
            $_SESSION['idutilisateur']
        );
        if (add($table,$field,$prepared,$value) == true) {
            echo json_encode(array('msg'=>'L\'opération a été éfféctue','status'=>'success'));
        }else{
            echo json_encode(array('msg'=>'Echecs d\'opération ...','status'=>'fail'));
        }   
    }

    if (isset($_POST['add_vehicule_btn'])) {
        $table = 'vehicule';
        $field = '(date,typeVehicule,marqueVehicule,plaqueVehicule,couleurVehicule,conducteurID,addedbyID)';
        $prepared = '?,?,?,?,?,?,?';
        $value = array(
            securise($_POST['date_vehicule']),
            securise($_POST['type_vehicule']),
            securise($_POST['marque_vehicule']),
            securise($_POST['plaque_vehicule']),
            securise($_POST['couleur_vehicule']),
            securise($_POST['conducteur_vehicule']),
            $_SESSION['idutilisateur']
        );
        if (add($table,$field,$prepared,$value) == true) {
            echo json_encode(array('msg'=>'Le vehicule a été ajouté','status'=>'success'));
        }else{
            echo json_encode(array('msg'=>'Echecs d\'opération ...','status'=>'fail'));
        }   
    }

    if (isset($_POST['add_new_driver'])) {
        $table = 'agent';
        $field = '(nom,postnom,prenom,sexe,datenaiss,dateengagement,grade,telephone,numeroPermisConduire,addedbyID)';
        $prepared = '?,?,?,?,?,?,?,?,?,?';
        $value = array(
            securise($_POST['f_name']),
            securise($_POST['s_name']),
            securise($_POST['l_name']),
            securise($_POST['genre']),
            securise($_POST['born_date']),
            securise($_POST['eng_date']),
            securise($_POST['function']),
            securise($_POST['phone']),
            securise($_POST['n_permis']),
            $_SESSION['idutilisateur']
        );
        if (add($table,$field,$prepared,$value) == true) {
            echo json_encode(array('msg'=>'Le conducteur a été ajouté','status'=>'success'));
        }else{
            echo json_encode(array('msg'=>'Echecs d\'opération ...','status'=>'fail'));
        }   
    }

    if (isset($_POST['operation_new_dette_page'])) {
        $table = 'dette';
        $field = '(date,agentID,raison,montant,operation,addedbyID)';
        $prepared = '?,?,?,?,?,?';
        $value = array(
            securise($_POST['date']),
            securise($_POST['agent']),
            securise($_POST['raison']),
            securise($_POST['amount']),
            securise($_POST['operation']),
            $_SESSION['idutilisateur']
        );
        if (add($table,$field,$prepared,$value) == true) {
            echo json_encode(array('msg'=>'L\'opération a été ajouté','status'=>'success'));
        }else{
            echo json_encode(array('msg'=>'Echecs d\'opération ...','status'=>'fail'));
        }   
    }

    if (isset($_POST['operation_caisse_new'])) {
        $table = 'caisse';
        $field = '(date,banque,nBordereau,description,montantDeposeFC,montantDeposeDollars,montantDeposeFRW,montantRetireFC,montantRetireDollars,montantRetireFRW,debitePar,creditePar,approuverPar,operation,addedbyID)';
        $prepared = '?,?,?,?,?,?,?,?,?,?,?,?,?,?,?';
        $value = array(
            securise($_POST['date']),
            securise($_POST['banque']),
            securise($_POST['nBordereau']),
            securise($_POST['description']),
            securise($_POST['depotFC']),
            securise($_POST['depotDollars']),
            securise($_POST['depotFRW']),
            securise($_POST['retraitFC']),
            securise($_POST['retraitDollars']),
            securise($_POST['retraitFRW']),
            securise($_POST['depotPar']),
            securise($_POST['creditPar']),
            securise($_POST['approuverPar']),
            securise($_POST['operation']),
            $_SESSION['idutilisateur']
        );

        if (add($table,$field,$prepared,$value) == true) {
            echo json_encode(array('msg'=>'L\'opération a été effectuer avec success.','status'=>'success'));
        }else{
            echo json_encode(array('msg'=>'Echecs d\'opération ...','status'=>'fail'));
        }     
    }