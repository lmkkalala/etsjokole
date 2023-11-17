<?php

session_start();

include '../../models/connexion.php';

include '../../models/crud/db.php';
    
function add($table,$field,$prepared,$value){
    $DB = new db();
    return $DB->insert($table,$field,$prepared,$value);
}

function delete($table,$field,$value){
    $DB = new db();
    return $DB->delete($table,$field,$value);
}

function update($table,$field,$where,$data){
    $DB = new db();
    return $DB->update($table,$field,$where,$data);
}

function securise($donnee) {
    $donnee = trim($donnee);
    $donnee = stripslashes($donnee);
    $donnee = strip_tags($donnee);
    return $donnee;
}

$formData = "String('formData')";

if(isset($_GET['code']) and $_GET['code'] == sha1('loadDataList')){
    $format = new NumberFormatter('de_DE',NumberFormatter::CURRENCY);
    
        if (isset($_POST['FilterFormBordereau'])) {
            $conditionBordereau = '';
            $mBordereau = htmlspecialchars($_POST['mBordereau']);
            if ($mBordereau != '') {
                $conditionBordereau = $conditionBordereau.'nBordereau = "'.$mBordereau.'"';
            }
            $Expediteur = htmlspecialchars($_POST['Expediteur']); 
            if ($Expediteur != '') {
                $conditionBordereau = $mBordereau != '' ? $conditionBordereau.' and ' : '';
                $conditionBordereau = $conditionBordereau.' expediteur Like "%'.$Expediteur.'%"';
            }
            $Destinateur = htmlspecialchars($_POST['Destinateur']);
            if ($Destinateur != '') {
                $conditionBordereau = $mBordereau != '' || $Expediteur != '' ? $conditionBordereau.' and ' : '';
                $conditionBordereau = $conditionBordereau.' destinateur Like "%'.$Destinateur.'%"';
            }
            $Conductuer = htmlspecialchars($_POST['Conductuer']);
            if ($Conductuer != '') {
                $conditionBordereau = $mBordereau != '' || $Expediteur != '' || $Destinateur != '' ? $conditionBordereau.' and ' : '';
                $conditionBordereau = $conditionBordereau.' transporteur Like "%'.$Conductuer.'%"';
            }

            $filterDate_start = htmlspecialchars($_POST['filterDate_start']); 
            $filterDate_end = htmlspecialchars($_POST['filterDate_end']);

            if ($filterDate_start != '' and $filterDate_end != '') {
                $conditionBordereau = $mBordereau != '' || $Expediteur != '' || $Destinateur != '' || $Conductuer != '' ? $conditionBordereau.' and ' : '';
                $conditionBordereau = $conditionBordereau.' date >= "'.$filterDate_start.'" and  date <= "'.$filterDate_end.'"';
            }
        }else{
            $conditionBordereau = '';
        }
        
        if (isset($_POST['FilterFormDette'])) {
            $conditionDette = '';
            $Agent = htmlspecialchars($_POST['Agent']);
            if ($Agent != '') {
                $conditionDette = $conditionDette.'agentID = "'.$Agent.'"';
            }
            $Raison = htmlspecialchars($_POST['Raison']); 
            if ($Raison != '') {
                $conditionDette = $Agent != '' ? $conditionDette.' and ' : '';
                $conditionDette = $conditionDette.' raison = "'.$Raison.'"';
            }
            $Operation = htmlspecialchars($_POST['Operation']);
            if ($Operation != '') {
                $conditionDette = $Agent != '' || $Raison != '' ? $conditionDette.' and ' : '';
                $conditionDette = $conditionDette.' operation = "'.$Operation.'"';
            }

            $filterDate_start = htmlspecialchars($_POST['filterDate_start']); 
            $filterDate_end = htmlspecialchars($_POST['filterDate_end']);

            if ($filterDate_start != '' and $filterDate_end != '') {
                $conditionDette = $Agent != '' || $Raison != '' || $Operation != '' ? $conditionDette.' and ' : '';
                $conditionDette = $conditionDette.' date >= "'.$filterDate_start.'" and  date <= "'.$filterDate_end.'"';
            }
        }else{
            $conditionDette = '';
        }

        if (isset($_POST['FilterFormDepenseCourse'])) {
            $conditionDepenseCourse = '';
            $Conducteur = htmlspecialchars($_POST['ConducteurDepenseCourse']);
            if ($Conducteur != '') {
                $conditionDepenseCourse = $conditionDepenseCourse.'conducteurID = "'.$Conducteur.'"';
            }

            $filterDate_start = htmlspecialchars($_POST['filterDate_startDepenseCourse']); 
            $filterDate_end = htmlspecialchars($_POST['filterDate_endDepenseCourse']);

            if ($filterDate_start != '' and $filterDate_end != '') {
                $conditionDepenseCourse = $Conducteur != '' ? $conditionDepenseCourse.' and ' : '';
                $conditionDepenseCourse = $conditionDepenseCourse.' date >= "'.$filterDate_start.'" and  date <= "'.$filterDate_end.'"';
            }
        }else{
            $conditionDepenseCourse = '';
        }

        if (isset($_POST['FilterDepenseForm'])) {
            $conditionDepense = '';
            $filterAgent = htmlspecialchars($_POST['filterAgent']);
            if ($filterAgent != '') {
                $conditionDepense = $conditionDepense.'addedbyID = "'.$filterAgent.'"';
            }
            $filterCategorie = htmlspecialchars($_POST['filterCategorie']); 
            if ($filterCategorie != '') {
                $conditionDepense = $filterAgent != '' ? $conditionDepense.' and ' : '';
                $conditionDepense = $conditionDepense.' categorieDepense = "'.$filterCategorie.'"';
            }
            $filterDate_start = htmlspecialchars($_POST['filterDate_start']); 
            $filterDate_end = htmlspecialchars($_POST['filterDate_end']);
            if ($filterDate_start != '' and $filterDate_end != '') {
                $conditionDepense = $filterAgent != '' || $filterCategorie != '' ? $conditionDepense.' and ' : '';
                $conditionDepense = $conditionDepense.' date >= "'.$filterDate_start.'" and  date <= "'.$filterDate_end.'"';
            }
        }else{
            $conditionDepense = '';
        }
        
        if (isset($_POST['FilterFormCourse'])) {
            $conditionCourse = '';
            $Conducteur = htmlspecialchars($_POST['Conducteur']);
            if ($Conducteur != '') {
                $conditionCourse = $conditionCourse.'conducteur = "'.$Conducteur.'"';
            }
            $Destination = htmlspecialchars($_POST['Destination']); 
            if ($Destination != '') {
                $conditionCourse = $Conducteur != '' ? $conditionCourse.' and ' : '';
                $conditionCourse = $conditionCourse.'destination Like "%'.$Destination.'%"';
            }
            $filterDate_start = htmlspecialchars($_POST['filterDate_start']); 
            $filterDate_end = htmlspecialchars($_POST['filterDate_end']);
            if ($filterDate_start != '' and $filterDate_end != '') {
                $conditionCourse = $Conducteur != '' || $Destination != '' ? $conditionCourse.' and ' : '';
                $conditionCourse = $conditionCourse.' date >= "'.$filterDate_start.'" and  date <= "'.$filterDate_end.'"';
            }
        }else{
            $conditionCourse = '';
        } 

        if (isset($_POST['FilterFormFacture'])) {
            $conditionFacture = '';
            $Agent = htmlspecialchars($_POST['Agent']);
            if ($Agent != '') {
                $conditionFacture = $conditionFacture.'agentID = "'.$Agent.'"';
            }
            $filterDate_start = htmlspecialchars($_POST['filterDate_start']); 
            $filterDate_end = htmlspecialchars($_POST['filterDate_end']);
            if ($filterDate_start != '' and $filterDate_end != '') {
                $conditionFacture = $Agent != '' ? $conditionFacture.' and ' : '';
                $conditionFacture = $conditionFacture.' date >= "'.$filterDate_start.'" and  date <= "'.$filterDate_end.'"';
            }
        }else{
            $conditionFacture = '';
        } 
        
        if (isset($_POST['FilterFormCaisse'])) {
            $conditionCaisse = '';
            $filterNom = htmlspecialchars($_POST['filterNom']);
            if ($filterNom != '') {
                $conditionCaisse = $conditionCaisse.'debitePar Like "%'.$filterNom.'%"';
            }
            $filterNomApprover = htmlspecialchars($_POST['filterNomApprover']);
            if ($filterNomApprover != '') {
                $conditionCaisse = $filterNom != '' ? $conditionCaisse.' and ' : '';
                $conditionCaisse = $conditionCaisse.'approuverPar Like "%'.$filterNomApprover.'%"';
            }
            $filterNBordereau = htmlspecialchars($_POST['filterNBordereau']);
            if ($filterNBordereau != '') {
                $conditionCaisse = $filterNom != '' || $filterNomApprover != '' ? $conditionCaisse.' and ' : '';
                $conditionCaisse = $conditionCaisse.'nBordereau = "'.$filterNBordereau.'"';
            } 
            $FilterBanque = htmlspecialchars($_POST['FilterBanque']);
            if ($FilterBanque != '') {
                $conditionCaisse = $filterNom != '' || $filterNomApprover != '' || $filterNBordereau != '' ? $conditionCaisse.' and ' : '';
                $conditionCaisse = $conditionCaisse.'banque = "'.$FilterBanque.'"';
            } 
            $filterDate_start = htmlspecialchars($_POST['filterDate_start']); 
            $filterDate_end = htmlspecialchars($_POST['filterDate_end']);
            if ($filterDate_start != '' and $filterDate_end != '') {
                $conditionCaisse = $filterNom != '' || $filterNomApprover != '' || $filterNBordereau != '' || $FilterBanque != '' ? $conditionCaisse.' and ' : '';
                $conditionCaisse = $conditionCaisse.' date >= "'.$filterDate_start.'" and  date <= "'.$filterDate_end.'"';
            }
        }else{
            $conditionCaisse = '';
        }

        if (isset($_POST['FilterFormCaisseCredit'])) {
            $conditionCaisseCredit = '';
            $filterNom = htmlspecialchars($_POST['filterNomCredit']);
    
            if ($filterNom != '') {
                $conditionCaisseCredit = $conditionCaisseCredit.'creditePar Like "%'.$filterNom.'%"';
            }
            $filterNomApprover = htmlspecialchars($_POST['filterNomApproverCredit']);
            if ($filterNomApprover != '') {
                $conditionCaisseCredit = $filterNom != '' ? $conditionCaisseCredit.' and ' : '';
                $conditionCaisseCredit = $conditionCaisseCredit.'approuverPar Like "%'.$filterNomApprover.'%"';
            }
            $filterNBordereau = htmlspecialchars($_POST['filterNBordereauCredit']);
            if ($filterNBordereau != '') {
                $conditionCaisseCredit = $filterNom != '' || $filterNomApprover != '' ? $conditionCaisseCredit.' and ' : '';
                $conditionCaisseCredit = $conditionCaisseCredit.'nBordereau = "'.$filterNBordereau.'"';
            } 
            $FilterBanque = htmlspecialchars($_POST['FilterBanqueCredit']);
            if ($FilterBanque != '') {
                $conditionCaisseCredit = $filterNom != '' || $filterNomApprover != '' || $filterNBordereau != '' ? $conditionCaisseCredit.' and ' : '';
                $conditionCaisseCredit = $conditionCaisseCredit.'banque = "'.$FilterBanque.'"';
            } 
            $filterDate_start = htmlspecialchars($_POST['filterDate_startCredit']); 
            $filterDate_end = htmlspecialchars($_POST['filterDate_endCredit']);
            if ($filterDate_start != '' and $filterDate_end != '') {
                $conditionCaisseCredit = $filterNom != '' || $filterNomApprover != '' || $filterNBordereau != '' || $FilterBanque != '' ? $conditionCaisseCredit.' and ' : '';
                $conditionCaisseCredit = $conditionCaisseCredit.' date >= "'.$filterDate_start.'" and  date <= "'.$filterDate_end.'"';
            }
        }else{
            $conditionCaisseCredit = '';
        }

        if (isset($_POST['FilterFormReception'])) {
            $conditionReceptionList = '';
            $article = htmlspecialchars($_POST['article']);
    
            if ($article != '') {
                $conditionReceptionList = $conditionReceptionList.' b.designation Like "%'.$article.'%"';
            }

            $filterDate_start = htmlspecialchars($_POST['filterDate_start']); 
            $filterDate_end = htmlspecialchars($_POST['filterDate_end']);
            if ($filterDate_start != '' and $filterDate_end != '') {
                $conditionReceptionList = $article != '' ? $conditionReceptionList.' and ' : '';
                $conditionReceptionList = $conditionReceptionList.' s.date >= "'.$filterDate_start.'" and  s.date <= "'.$filterDate_end.'"';
            }
        }else{
            $conditionReceptionList = '';
        }

        if (isset($_POST['FilterFormReceptionPlace'])) {
            $conditionReceptionDataAutrePlace = '';
            $article = htmlspecialchars($_POST['articlePlace']);
    
            if ($article != '') {
                $conditionReceptionDataAutrePlace = $conditionReceptionDataAutrePlace.' b.designation Like "%'.$article.'%"';
            }

            $filterDate_start = htmlspecialchars($_POST['filterDate_startPlace']); 
            $filterDate_end = htmlspecialchars($_POST['filterDate_endPlace']);
            if ($filterDate_start != '' and $filterDate_end != '') {
                $conditionReceptionDataAutrePlace = $article != '' ? $conditionReceptionDataAutrePlace.' and ' : '';
                $conditionReceptionDataAutrePlace = $conditionReceptionDataAutrePlace.' r.date >= "'.$filterDate_start.'" and  r.date <= "'.$filterDate_end.'"';
            }
        }else{
            $conditionReceptionDataAutrePlace = '';
        }

        $conditionReception = "";



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
    
   
    if(htmlspecialchars($_GET['page']) == 'home_dette'){    
        if ($conditionDette != '') {
            if ($_SESSION['type'] == 'logistique') {
                $listDette = $DB->getWhereMultiple('dette',$conditionDette);
            }else{
                $listDette = $DB->getWhereMultiple('dette','addedbyID = "'.$_SESSION['type'].'"'.$conditionDette);
            }
        }else{
            if ($_SESSION['type'] == 'logistique') {
                $listDette = $DB->get('dette','id');
            }else{
                $listDette = $DB->getWhere('dette','addedbyID',$_SESSION['type'],'id');
            }
        }

        $listDetteData = 
        '<thead>
            <tr>
                <th>DATE</th>
                <th>AGENT</th>
                <th>RAISON</th>
                <th>MONTANT</th>
                <th>OPERATION</th>
                <th>PLUS</th>
            </tr>
        </thead>
        <tbody>';
        $detteTotal = 0;
        $table = "String('dette')";
        $rembourserTotal = 0;
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
                <button class="btn btn-danger mt-1 text-white w-100" type="button" onclick="deleteThis('.$listDette[$key]['id'].','.$table.')">Supprimer</button>
            </td>
            </tr>
        </form>';
        }
        $listDetteData = $listDetteData.
        '<tr>
        <td class="fw-bolder">MONTANT DETTE</td>
        <td class="h3 fw-bolder bg-primary text-white p-2">'.$format->formatCurrency($detteTotal,'usd').'</td>
        <td class="fw-bolder">MONTANT REMBOURSER</td>
        <td class="h3 fw-bolder bg-primary text-white p-2">'.$format->formatCurrency($rembourserTotal,'usd').'</td>
        <td class="fw-bolder">RESTE A PAYER</td>
        <td class="h3 fw-bolder bg-primary text-white p-2">'.$format->formatCurrency($detteTotal-$rembourserTotal,'usd').'</td>
        </tr>
        </tbody>';
    }else{
        $listDetteData = '';
    }

    if(htmlspecialchars($_GET['page']) == 'home_depense'){
        if($conditionDepense != ''){
            if ($_SESSION['type'] == 'logistique') {
                $listDepense = $DB->getWhereMultiple('depense',$conditionDepense);
            }else{
                $listDepense = $DB->getWhereMultiple('depense','addedbyID = "'.$_SESSION['type'].'"'.$conditionDepense);
            }
        }else{
            if ($_SESSION['type'] == 'logistique') {
                $listDepense = $DB->get('depense','id');
            }else{
                $listDepense = $DB->getWhere('depense','addedbyID',$_SESSION['type'],'id');
            }
        }
        
        $listDepenseData = 
        '<thead>
            <tr>
                <th>DATE</th>
                <th>MONTANT</th>
                <th>CATERORIE</th>
                <th>DESCRIPTION</th>
                <th>PLUS</th>
            </tr>
        </thead>
        <tbody>';
        $depenseTotal = 0;
        $table = "String('depense')";
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
                <button class="btn btn-danger mt-1 text-white w-100" type="button" onclick="deleteThis('.$listDepense[$key]['id'].','.$table.')">Supprimer</button>
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
        <td class="h4 fw-bolder bg-primary text-white p-2">'.$format->formatCurrency($depenseTotal,'usd').'</td>
        </tr>
        </tbody>';

    }else{
        $listDepenseData = '';
    }

    if(htmlspecialchars($_GET['page']) == 'home_caisse'){

        if ($conditionCaisse != '') {
            $listCaisse = $DB->getWhereMultiple('caisse','operation = "Debiter" and '.$conditionCaisse);
        }else{
            $listCaisse = $DB->getWhere('caisse','operation','Debiter','date');
        }
        
        $listCaisseData = 
        '<thead>
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
        <tbody>';
        $totalDebitDollars = 0;
        $totalDebitFc = 0;
        $totalDebitFrw = 0;
        $table = "String('caisse')";
        foreach ($listCaisse as $key => $value) {
            $totalDebitDollars = $totalDebitDollars + $listCaisse[$key]['montantDeposeDollars'];
            $totalDebitFc = $totalDebitFc + $listCaisse[$key]['montantDeposeFC'];
            $totalDebitFrw = $totalDebitFrw + $listCaisse[$key]['montantDeposeFRW'];
            $listCaisseData = $listCaisseData.'
            <form action="" method="post" id="CaisseUpdateForm_'.$listCaisse[$key]['id'].'">
            <tr>
                <td><input class="form-control" type="date" name="DcaisseDate_'.$listCaisse[$key]['id'].'" id="DcaisseDate_'.$listCaisse[$key]['id'].'" placeholder="" value="'.$listCaisse[$key]['date'].'" placeholder="yyyy-MM-dd"></td>
                <td><input class="form-control" type="text" name="DcaisseBanque_'.$listCaisse[$key]['id'].'" id="DcaisseBanque_'.$listCaisse[$key]['id'].'" placeholder="" value="'.$listCaisse[$key]['banque'].'"></td>
                <td><input class="form-control" type="number" name="DcaissenBordereau_'.$listCaisse[$key]['id'].'" id="DcaissenBordereau_'.$listCaisse[$key]['id'].'" placeholder="" value="'.$listCaisse[$key]['nBordereau'].'"></td>
                <td><input class="form-control" type="text" name="DcaisseDescription_'.$listCaisse[$key]['id'].'" id="DcaisseDescription_'.$listCaisse[$key]['id'].'" placeholder="" value="'.$listCaisse[$key]['description'].'"></td>
                <td><input class="form-control" type="number" name="caisseMontantDeposeDollars_'.$listCaisse[$key]['id'].'" id="caisseMontantDeposeDollars_'.$listCaisse[$key]['id'].'" placeholder="" value="'.$listCaisse[$key]['montantDeposeDollars'].'"></td>
                <td><input class="form-control" type="number" name="caisseMontantDeposeFC_'.$listCaisse[$key]['id'].'" id="caisseMontantDeposeFC_'.$listCaisse[$key]['id'].'" placeholder="" value="'.$listCaisse[$key]['montantDeposeFC'].'"></td>
                <td><input class="form-control" type="text" name="caisseMontantDeposeFRW_'.$listCaisse[$key]['id'].'" id="caisseMontantDeposeFRW_'.$listCaisse[$key]['id'].'" placeholder="" value="'.$listCaisse[$key]['montantDeposeFRW'].'"></td>
                <td><input class="form-control" type="text" name="caisseDebitePar_'.$listCaisse[$key]['id'].'" id="caisseDebitePar_'.$listCaisse[$key]['id'].'" placeholder="" value="'.$listCaisse[$key]['debitePar'].'"></td>
                <td><input class="form-control" type="text" name="DcaisseApprouverPar_'.$listCaisse[$key]['id'].'" id="DcaisseApprouverPar_'.$listCaisse[$key]['id'].'" placeholder="" value="'.$listCaisse[$key]['approuverPar'].'"></td>
                <td>
                    <button class="btn btn-primary mt-1 text-white w-100" onclick="updateThis('.$listCaisse[$key]['id'].','.$table.','.$formData.')" type="button">Modifier</button>
                    <button class="btn btn-danger mt-1 text-white w-100" onclick="deleteThis('.$listCaisse[$key]['id'].','.$table.')" type="button">Supprimer</button>
                </td>
            </tr>
        </form>';
        }
        $listCaisseData = $listCaisseData.
        '<tr class="bg-primary text-dark">
            <td class="fw-bolder text-dark small">TOTAL DEBIT Dollors</td>
            <td></td>
            <td class="fw-bolder text-dark">'.$format->formatCurrency($totalDebitDollars,'usd').'</td>
            <td class="fw-bolder text-dark small">TOTAL DEBIT FC</td>
            <td></td>
            <td class="fw-bolder text-dark">'.$format->formatCurrency($totalDebitFc,'fcf').'</td>
            <td class="fw-bolder text-dark small">TOTAL DEBIT FRW</td>
            <td></td>
            <td></td>
            <td class="fw-bolder text-dark text-start">'.$format->formatCurrency($totalDebitFrw,'frw').'</td>
        </tr></tbody>
        ';

        if ($conditionCaisseCredit != '') {
            $listCaisseSortie = $DB->getWhereMultiple('caisse','operation = "Crediter" and '.$conditionCaisseCredit);
        }else{
            $listCaisseSortie = $DB->getWhere('caisse','operation','Crediter','date');
        }
        
        $listCaisseDataSortie = 
        '<thead>
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
        <tbody>';
        $totalCreditDollars = 0;
        $totalCreditFc = 0;
        $totalCreditFrw = 0;
        $table = "String('caisse')";
        foreach ($listCaisseSortie as $key => $value) {
            $totalCreditDollars = $totalCreditDollars + $listCaisseSortie[$key]['montantRetireDollars'];
            $totalCreditFc = $totalCreditFc + $listCaisseSortie[$key]['montantRetireFC'];
            $totalCreditFrw = $totalCreditFrw + $listCaisseSortie[$key]['montantRetireFRW'];
            $listCaisseDataSortie = $listCaisseDataSortie.
            '<form action="" method="post" id="CaisseUpdateForm_'.$listCaisseSortie[$key]['id'].'">
            <tr>
                <td><input class="form-control" type="date" name="CcaisseDate_'.$listCaisseSortie[$key]['id'].'" id="CcaisseDate_'.$listCaisseSortie[$key]['id'].'" placeholder="" value="'.$listCaisseSortie[$key]['date'].'" placeholder="yyyy-MM-dd"></td>
                <td><input class="form-control" type="text" name="CcaisseBanque_'.$listCaisseSortie[$key]['id'].'" id="CcaisseBanque_'.$listCaisseSortie[$key]['id'].'" placeholder="" value="'.$listCaisseSortie[$key]['banque'].'"></td>
                <td><input class="form-control" type="number" name="CcaissenBordereau_'.$listCaisseSortie[$key]['id'].'" id="CcaissenBordereau_'.$listCaisseSortie[$key]['id'].'" placeholder="" value="'.$listCaisseSortie[$key]['nBordereau'].'"></td>
                <td><input class="form-control" type="text" name="CcaisseDescription_'.$listCaisseSortie[$key]['id'].'" id="CcaisseDescription_'.$listCaisseSortie[$key]['id'].'" placeholder="" value="'.$listCaisseSortie[$key]['description'].'"></td>
                <td><input class="form-control" type="text" name="caisseMontantRetireDollars_'.$listCaisseSortie[$key]['id'].'" id="caisseMontantRetireDollars_'.$listCaisseSortie[$key]['id'].'" placeholder="" value="'.$listCaisseSortie[$key]['montantRetireDollars'].'"></td>
                <td><input class="form-control" type="text" name="caisseMontantRetireFC_'.$listCaisseSortie[$key]['id'].'" id="caisseMontantRetireFC_'.$listCaisseSortie[$key]['id'].'" placeholder="" value="'.$listCaisseSortie[$key]['montantRetireFC'].'"></td>
                <td><input class="form-control" type="text" name="caisseMontantRetireFRW_'.$listCaisseSortie[$key]['id'].'" id="caisseMontantRetireFRW_'.$listCaisseSortie[$key]['id'].'" placeholder="" value="'.$listCaisseSortie[$key]['montantRetireFRW'].'"></td>
                <td><input class="form-control" type="text" name="caisseCreditePar_'.$listCaisseSortie[$key]['id'].'" id="caisseCreditePar_'.$listCaisseSortie[$key]['id'].'" placeholder="" value="'.$listCaisseSortie[$key]['creditePar'].'"></td>
                <td><input class="form-control" type="text" name="CcaisseApprouverPar_'.$listCaisseSortie[$key]['id'].'" id="CcaisseApprouverPar_'.$listCaisseSortie[$key]['id'].'" placeholder="" value="'.$listCaisseSortie[$key]['approuverPar'].'"></td>
                <td>
                    <button class="btn btn-primary mt-1 text-white w-100" onclick="updateThis('.$listCaisseSortie[$key]['id'].','.$table.','.$formData.')" type="button">Modifier</button>
                    <button class="btn btn-danger mt-1 text-white w-100" onclick="deleteThis('.$listCaisseSortie[$key]['id'].','.$table.')" type="button">Supprimer</button>
                </td>
            </tr>
        </form>';
        }

        $listCaisseDataSortie = $listCaisseDataSortie.
        '<tr class="bg-primary text-dark">
            <td class="fw-bolder text-dark">TOTAL CREDIT Dollors</td>
            <td></td>
            <td class="fw-bolder text-dark">'.$format->formatCurrency($totalCreditDollars,'usd').'</td>
            <td class="fw-bolder text-dark">TOTAL CREDIT FC</td>
            <td></td>
            <td class="fw-bolder text-dark">'.$format->formatCurrency($totalCreditFc,'fcf').'</td>
            <td class="fw-bolder text-dark">TOTAL CREDIT FRW</td>
            <td></td>
            <td></td>
            <td class="fw-bolder text-dark">'.$format->formatCurrency($totalCreditFrw,'frw').'</td>
        </tr>
        </tbody>
        ';

        $dollars = $totalDebitDollars - $totalCreditDollars;
        $fc = $totalDebitFc - $totalCreditFc;
        $frw = $totalDebitFrw - $totalCreditFrw;


        $listBanqueData = $DB->get('comptebanque','date');

        $listBanque =
        '<thead>
        <tr>
        <th class="small">DATE</th>
        <th class="small">BANQUE/N°COMPTE</th>
        <th class="small">DESCRIPTION</th>
        <th class="small">PLUS</th>
        </tr>
        </thead>
        <tbody>';
        $table = "String('comptebanque')";
        foreach ($listBanqueData as $key => $value) {
        $listBanque =  $listBanque.'<form action="" method="post" id="">
            <tr>
                <td><input class="form-control" type="date" name="" id="" placeholder="" value="'.$listBanqueData[$key]['date'].'" placeholder="yyyy-MM-dd"></td>
                <td>
                <input class="form-control" type="text" name="" id="" placeholder="" value="'.$listBanqueData[$key]['banque'].'">
                <input class="form-control mt-1" type="text" name="" id="" placeholder="" value="'.$listBanqueData[$key]['n_compte'].'">
                </td>
                <td><textarea class="form-control" name="" id="" >'.$listBanqueData[$key]['description'].'</textarea></td>
                <td>
                    <button class="btn btn-primary mt-1 text-white w-100" type="submit">Modifier</button>
                    <button class="btn btn-danger mt-1 text-white w-100" onclick="deleteThis('.$listBanqueData[$key]['id'].','.$table.')" type="button">Supprimer</button>
                </td>
            </tr>
        </form>
        </tbody>';
        }

    }else{
        $dollars = '0.0';
        $fc = '0.0';
        $frw = '0.0';
        $listCaisseData = '';
        $listCaisseDataSortie = '';
        $listBanque = '';
    }

    if(htmlspecialchars($_GET['page']) == 'home_logistique_transport'){
        $listConducteur = $DB->getWhere('agent','grade','driver','id');
        $listConducteurData = '';
        $table = "String('agent')";
        foreach ($listConducteur as $key => $value) {
        if ($listConducteur[$key]['active'] == '1') {
            $btnStyle = ($listConducteur[$key]['active'] == '0') ? 'danger' : 'secondary';
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
                <button type="submit" class="btn btn-'.$btnStyle.'" onclick="updateThis('.$listConducteur[$key]['id'].','.$table.')" disabled><i class="fa fa-eye"></i></button>
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
        $table = "String('vehicule')";
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
            
            $btnStyle = ($listVehicule[$key]['status'] == '0') ? 'danger' : 'secondary';

            $listVehiculeData = $listVehiculeData.
            '<form action="" method="post" id="vehicule_list_form_data">
            <tr>
                <td>
                    <input class="form-control" type="date" name="Vdate_'.$listVehicule[$key]['id'].'" id="Vdate_'.$listVehicule[$key]['id'].'" value="'.$listVehicule[$key]['date'].'">
                </td>
                <td>
                    <input class="form-control" type="tel" name="Vplaque_'.$listVehicule[$key]['id'].'" id="Vplaque_'.$listVehicule[$key]['id'].'" value="'.$listVehicule[$key]['plaqueVehicule'].'">
                </td>
                <td>
                    <input class="form-control" type="tel" name="typeVehicule_'.$listVehicule[$key]['id'].'" id="typeVehicule_'.$listVehicule[$key]['id'].'" value="'.$listVehicule[$key]['typeVehicule'].'">
                </td>
                <td>
                    <input class="form-control" type="tel" name="marqueVehicule_'.$listVehicule[$key]['id'].'" id="marqueVehicule_'.$listVehicule[$key]['id'].'" value="'.$listVehicule[$key]['marqueVehicule'].'">
                </td>
                <td>
                    <input class="form-control" type="tel" name="couleurVehicule_'.$listVehicule[$key]['id'].'" id="couleurVehicule_'.$listVehicule[$key]['id'].'" value="'.$listVehicule[$key]['couleurVehicule'].'">
                </td>
                <td>
                    <select class="form-control" name="genre" id="genre" readonly>
                        <option value="'.$conducteurID.'">'.$conducteurNames.'</option>'.$conducteurList.'
                    </select>
                </td>
                <td>
                    <button type="submit" class="btn btn-primary" onclick="updateThis('.$listVehicule[$key]['id'].','.$table.','.$formData.')"><i class="fa fa-pencil"></i></button>
                    <button type="submit" class="btn btn-'.$btnStyle.'" onclick="updateThis('.$listVehicule[$key]['id'].','.$table.')"><i class="fa fa-eye"></i></button>
                </td>
            </tr>
            </form>';
        }
        //$btnStyle = array();
        $table = "String('typedepense')";
        $typeDepense = $DB->get('typedepense','id');
        $typeDepenseData = 
        '<thead>
            <tr>
                <th>Date</th>
                <th>Description</th>
                <th>Montant En $</th>
                <th>Aller</th>
                <th>EXECUTER</th>
            </tr>
        </thead>
        <tbody>';
        foreach ($typeDepense as $key => $value) {

        $btnStyle = ($typeDepense[$key]['status'] == '0') ? 'danger' : 'secondary';
        
        $typeDepenseData = $typeDepenseData.
        '<form action="" method="post" id="">
            <tr>
                <td width="20">
                    <input class="form-control" type="date" name="type_depense_date_update_'.$typeDepense[$key]['id'].'" id="type_depense_date_update_'.$typeDepense[$key]['id'].'" value="'.$typeDepense[$key]['date'].'">
                </td>
                <td>
                    <input class="form-control" type="text" name="type_depense_description_update_'.$typeDepense[$key]['id'].'" id="type_depense_description_update_'.$typeDepense[$key]['id'].'" value="'.$typeDepense[$key]['description'].'">
                </td>
                <td>
                    <input class="form-control" type="text" name="type_depense_montant_update_'.$typeDepense[$key]['id'].'" id="type_depense_montant_update_'.$typeDepense[$key]['id'].'" value="'.$typeDepense[$key]['montant'].'">
                </td>
                <td>
                    <input class="form-control" type="text" name="type_depense_destination_update_'.$typeDepense[$key]['id'].'" id="type_depense_destination_update_'.$typeDepense[$key]['id'].'" value="'.$typeDepense[$key]['destination'].'">
                </td>
                <td>
                    <button type="submit" class="btn btn-primary" onclick="updateThis('.$typeDepense[$key]['id'].','.$table.','.$formData.')"><i class="fa fa-pencil"></i></button>
                    <button type="submit" class="btn btn-'.$btnStyle.'" onclick="updateThis('.$typeDepense[$key]['id'].','.$table.')"><i class="fa fa-eye"></i></button>
                </td>
            </tr>
        </form>';
            $btnStyle = '';
        }
        $typeDepenseData = $typeDepenseData.'</tbody>'; 
    }else{
        $listConducteurData = '';
        $listVehiculeData = '';
        $typeDepenseData = ''; 
    }

    if (htmlspecialchars($_GET['page']) == 'home_facture_client') {
        if ($conditionFacture != '') {
            if ($_SESSION['type'] == 'logistique') {
                $factureDataList = $DB->getWhereMultiple('facture',$conditionFacture);
            }else{
                $factureDataList = $DB->getWhereMultiple('facture',' agentID = '.$_SESSION['agentID'].' '.$conditionFacture);
            }
        }else{
            if ($_SESSION['type'] == 'logistique') {
                $factureDataList = $DB->get('facture','id');
            }else{
                $factureDataList = $DB->getWhere('facture','agentID',$_SESSION['agentID']);
            } 
        }

        $table = "String('facture')";
        $factureData = 
        '<thead>
            <tr>
                <th>DATE</th>
                <th>AGENT</th>
                <th>MONTANT</th>
                <th>DESCRIPTION</th>
                <th>SITUATION</th>
                <th>PLUS</th>
            </tr>
        </thead>
        <tbody>';
        $fullNameAgent = '';
        foreach ($factureDataList as $key => $value) {
            $select = '';
            foreach($allAgent as $key2 => $agent){
                if ($allAgent[$key2]["id"] == $factureDataList[$key]["agentID"]) {
                    $fullNameAgent = $allAgent[$key2]["nom"].' '.$allAgent[$key2]["postnom"].' '.$allAgent[$key2]["prenom"];
                }
            }
            if($factureDataList[$key]['status'] == 0){
                $status = "Pas Payer";
                $style = 'text-white bg-danger';
            }else{
                $status = "Payer";
                $style = 'text-white bg-primary';
            }

            if ($_SESSION['type'] == 'logistique') {
                $action = '
                <button type="submit" class="btn '.$style.'" onclick="updateThis('.$factureDataList[$key]['id'].','.$table.')"><i class="fa fa-check"></i></button>
                <button type="submit" class="btn btn-danger" onclick="deleteThis('.$factureDataList[$key]['id'].','.$table.')"><i class="fa fa-trash"></i></button>';
            }else{
                $action = '<button type="submit" class="btn btn-primary"><i class="fa fa-dollar"></i></button>';
            }
        $factureData = $factureData.
        '<form action="" method="post" id="">
            <tr>
                <td width="20">
                    <input class="form-control" type="date" name="" id="" value="'.$factureDataList[$key]['date'].'">
                </td>
                <td>
                    <input class="form-control" type="text" name="" id="" value="'.$fullNameAgent.'">
                </td>
                <td>
                    <input class="form-control" type="text" name="" id="" value="'.$factureDataList[$key]['montant'].'">
                </td>
                <td>
                    <textarea class="form-control" name="" id="" value="">'.$factureDataList[$key]['description'].'</textarea>
                </td>
                <td>
                    <input class="form-control '.$style.'" type="text" name="" id="" value="'.$status.'" readonly>
                </td>
                <td>
                    '.$action.'
                </td>
            </tr>
        </form>';
        }
        $factureData = $factureData.'</tbody>';
    }else{
        $factureData = ''; 
    }

    if(htmlspecialchars($_GET['page']) == 'home_logistique_transport'){

        if ($conditionDepenseCourse != '') {
            $depensetransport = $DB->getWhereMultiple('depensetransport',$conditionDepenseCourse);
        }else{
            $depensetransport = $DB->getWhereMultiple('depensetransport','date Like"%'.date('Y-m',time()).'%" ORDER BY date DESC');
        }
        $table = "String('depensetransport')";
        $typeAgent = $DB->getWhere('agent','active','1');
        $typedepense = $DB->get('typedepense','id'); 
        $lisDepenseCourse = 
        '<thead>
        <tr>
            <th>Date</th>
            <th>Conducteur</th>
            <th>Description</th>
            <th>Les Depenses</th>
            <th>EXECUTER</th>
        </tr>
        </thead>
        <tbody>';
        $description = '';
        $DepenseTotalCourse = 0;
        foreach ($depensetransport as $key => $value) {
            foreach ($typeAgent as $key2 => $value) {
                if ($depensetransport[$key]['conducteurID'] == $typeAgent[$key2]['id']) {
                    $conducteurNames = $typeAgent[$key2]['nom'].' '.$typeAgent[$key2]['postnom'].' '.$typeAgent[$key2]['prenom'];
                }
            }

            foreach ($typedepense as $key4 => $value) {
                if ($depensetransport[$key]['typeDepenseID'] == $typedepense[$key4]['id']) {
                    $description = $typedepense[$key4]['description'].' Destination '.$typedepense[$key4]['destination'];
                    $DepenseTotalCourse = $DepenseTotalCourse + $depensetransport[$key]['montant'];
                }
            }

            $lisDepenseCourse = $lisDepenseCourse.'<form action="" method="post" id="'.$depensetransport[$key]['id'].'">
                <tr>
                    <td>
                        <input class="form-control" type="date" name="depense_transport_date'.$depensetransport[$key]['id'].'" id="depense_transport_date'.$depensetransport[$key]['id'].'" value="'.$depensetransport[$key]['date'].'" readonly>
                    </td>
                    <td>
                        <input class="form-control" type="text" name="depense_transport_name'.$depensetransport[$key]['id'].'" id="depense_transport_name'.$depensetransport[$key]['id'].'" value="'.$conducteurNames.'" readonly>
                    </td>
                    <td>
                        <input class="form-control" type="text" name="depense_transport_description'.$depensetransport[$key]['id'].'" id="depense_transport_description'.$depensetransport[$key]['id'].'" value="'.$description.'" readonly>
                    </td>
                    <td>
                    <input class="form-control" type="text" name="depense_transport_montant'.$depensetransport[$key]['id'].'" id="depense_transport_montant'.$depensetransport[$key]['id'].'" value="'.$depensetransport[$key]['montant'].'">
                    </td>
                    <td>
                        <button type="submit" class="btn btn-primary" onclick="deleteThis('.$depensetransport[$key]['id'].','.$table.','.'formData'.')"><i class="fa fa-pencil"></i></button>
                        <button type="submit" class="btn btn-danger"  onclick="deleteThis('.$depensetransport[$key]['id'].','.$table.')"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            </form>';
        }
        $lisDepenseCourse = $lisDepenseCourse.
        '<tr class="text-dark"">
        <td><input class="form-control" type="text" name="" id="" value="DEPENSE TOTAL" desabled></td>
        <td>
        </td>
        <td>
        </td>
        <td>
        <input class="form-control" type="text" name="" id="" value="'.$DepenseTotalCourse.' $" readonly>  
        </td>
        <td></td>
        </tr><tbody>';

        if ($conditionCourse != '') {
            $typeCourse = $DB->getWhereMultiple('coursetransport',$conditionCourse);
        }else{
            $typeCourse = $DB->getWhereMultiple('coursetransport','date Like"%'.date('Y-m',time()).'%" ORDER BY date DESC');
        }

        $listDepenseTransport = $DB->get('depensetransport','id'); 

        $typeCourseData = '<thead>
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
                <tbody>';
        $conducteurID = '';
        $conducteurNames = '';
        $plaque = '';
        $depenseTotalCourse = 0;
        $calcul = 0;
        $table = "String('coursetransport')";

        $depenseTotal = 0;
        $prixTotal = 0;
        $tonnageTotal = 0;
        $margeTotal = 0;
        $rows = 0;
        foreach ($typeCourse as $key => $value) {
            if (count($typeCourse) > 0) {
            foreach ($typeAgent as $key2 => $value) {
                if ($typeCourse[$key]['conducteur'] == $typeAgent[$key2]['id']) {
                    $conducteurNames = $typeAgent[$key2]['nom'].' '.$typeAgent[$key2]['postnom'].' '.$typeAgent[$key2]['prenom'];
                }
                
            }
            foreach ($listVehicule as $key3 => $value) {
                if ($typeCourse[$key]['conducteur'] == $listVehicule[$key3]['conducteurID']) {
                    $plaque = $listVehicule[$key3]['plaqueVehicule'];
                }
            }

            foreach ($listDepenseTransport as $key4 => $value) {
                if ($typeCourse[$key]['id'] == $listDepenseTransport[$key4]['courseTransportID'] and $typeCourse[$key]['date'] == $listDepenseTransport[$key4]['date']) {
                    $calcul = $calcul + $listDepenseTransport[$key4]['montant'];
                    $depenseTotalCourse = $calcul;
                }
            }

            $depenseTotal = $depenseTotal + $depenseTotalCourse;
            $prixTotal = $prixTotal + $typeCourse[$key]['prixCourse'];
            $tonnageTotal = $tonnageTotal + $typeCourse[$key]['tonne'];
            $margeTotal = $margeTotal + ($typeCourse[$key]['prixCourse'] - $calcul);
            $rows++;
            if (!is_int($calcul)) {
                $calcul = intval($calcul);
            }
            $typeCourseData = $typeCourseData.'<form action="" method="post" id="">
                <tr>
                    <td>'.$rows.'</td>
                    <td><input class="form-control" type="date" name="courseTransportDate_'.$typeCourse[$key]['id'].'" id="courseTransportDate_'.$typeCourse[$key]['id'].'"  value="'.$typeCourse[$key]['date'].'"></td>
                    <td>
                        <input class="form-control" type="text" name="" id=""  value="'.$conducteurNames.'" readonly>
                        <input class="form-control mt-1" type="text" name="" id=""  value="'.$plaque.'" readonly>
                    </td>
                    
                    <td>
                        <input class="form-control" type="text" name="courseTransportContenu_'.$typeCourse[$key]['id'].'" id="courseTransportContenu_'.$typeCourse[$key]['id'].'"  value="'.$typeCourse[$key]['contenu'].'">
                        <input class="form-control mt-1" type="text" name="courseTransportDestination_'.$typeCourse[$key]['id'].'" id="courseTransportDestination_'.$typeCourse[$key]['id'].'"  value="'.$typeCourse[$key]['destination'].'">
                    </td>
                    <td>
                        <textarea class="form-control" name="courseTransportDescription_'.$typeCourse[$key]['id'].'" id="courseTransportDescription_'.$typeCourse[$key]['id'].'"  value="'.$typeCourse[$key]['description'].'">'.$typeCourse[$key]['description'].'</textarea>
                    </td>
                    <td>
                        <input class="form-control" type="text" name="courseTransportTonne_'.$typeCourse[$key]['id'].'" id="courseTransportTonne_'.$typeCourse[$key]['id'].'"  value="'.$typeCourse[$key]['tonne'].'">
                        <input class="form-control mt-1" type="text" name="prixCourse_'.$typeCourse[$key]['id'].'" id="prixCourse_'.$typeCourse[$key]['id'].'"  value="'.$typeCourse[$key]['prixCourse'].'">
                    </td>
                    <td>
                        <input class="form-control" type="text" name="" id=""  value="'.$depenseTotalCourse.'" readonly>
                    </td>
                    <td>
                        <input class="form-control" type="text" name="" id=""  value="'.($typeCourse[$key]['prixCourse'] - $calcul).'" readonly>
                    </td>
                    <td>
                        <button class="btn btn-primary mt-1 text-white w-100" type="button" data-bs-toggle="modal" data-bs-target="#add_depense" data-id="'.$typeCourse[$key]['id'].'">
                            <i class="fa fa-money"></i>
                        </button>
                        <button class="btn btn-primary mt-1 text-white w-100" type="submit" onclick="updateThis('.$typeCourse[$key]['id'].','.$table.','.$formData.')"><i class="fa fa-pencil"></i> </button>
                        <button class="btn btn-danger mt-1 text-white w-100" type="button" onclick="deleteThis('.$typeCourse[$key]['id'].','.$table.')"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            </form>';
            $calcul = 0;
            $depenseTotalCourse = '0';
            }
        }

        $typeCourseData = $typeCourseData.
        '<tr class="bg-primary text-dark">
            <td></td>
            <td>TONNAGE : </td>
            <td>'.$tonnageTotal.'</td>
            <td>PRIX : </td>
            <td>'.$prixTotal.' USD</td>
            <td>DEPENSE : </td>
            <td>'.$depenseTotal.' USD</td>
            <td>MARGE : </td>
            <td>'.$margeTotal.'</td>
            <td> USD</td>
        </tr></tbody>';
    }else{
        $lisDepenseCourse = '';
        $typeCourseData = '';
    }

    if (htmlspecialchars($_GET['page']) == 'home_bordereau_expedition') {


        if ($conditionBordereau != '') {
            $listBordereau = $DB->getWhereMultiple('bordereau',$conditionBordereau);
        }else{
            $listBordereau = $DB->get('bordereau','id');
        }
    
        $listBordereauData = '';
        $table = "String('bordereau')";
        foreach ($listBordereau as $key => $value) {
        $listBordereauData = $listBordereauData.
                '<form action="" id="" method="post">
                    <tr>
                        <td>
                            <input class="form-control" type="date" name="bordereau_update_date'.$listBordereau[$key]['id'].'" id="bordereau_update_date'.$listBordereau[$key]['id'].'" value="'.$listBordereau[$key]['date'].'">
                            <input class="form-control mt-1" type="number" name="bordereau_update_nBordereau'.$listBordereau[$key]['id'].'" id="bordereau_update_nBordereau'.$listBordereau[$key]['id'].'" value="'.$listBordereau[$key]['nBordereau'].'">
                        </td>
                    
                        <td>
                            <input class="form-control" type="text" name="bordereau_update_expediteur'.$listBordereau[$key]['id'].'" id="bordereau_update_expediteur'.$listBordereau[$key]['id'].'" value="'.$listBordereau[$key]['expediteur'].'"> 
                            <input class="form-control mt-1" type="text" name="bordereau_update_destinateur'.$listBordereau[$key]['id'].'" id="bordereau_update_destinateur'.$listBordereau[$key]['id'].'" value="'.$listBordereau[$key]['destinateur'].'">
                        </td>
                    
                        <td>
                            <input class="form-control" type="text" name="bordereau_update_transporteur'.$listBordereau[$key]['id'].'" id="bordereau_update_transporteur'.$listBordereau[$key]['id'].'" value="'.$listBordereau[$key]['transporteur'].'"> 
                            <input class="form-control mt-1" type="text" name="bordereau_update_nPlaque'.$listBordereau[$key]['id'].'" id="bordereau_update_nPlaque'.$listBordereau[$key]['id'].'" value="'.$listBordereau[$key]['nPlaque'].'">
                            <input class="form-control mt-1" type="tel" name="bordereau_update_telephone'.$listBordereau[$key]['id'].'" id="bordereau_update_telephone'.$listBordereau[$key]['id'].'" value="'.$listBordereau[$key]['telephone'].'">
                        </td>

                        <td>
                            <input class="form-control" type="text" name="bordereau_update_nColis'.$listBordereau[$key]['id'].'" id="bordereau_update_nColis'.$listBordereau[$key]['id'].'" value="'.$listBordereau[$key]['nColis'].'">
                            <input class="form-control mt-1" type="text" name="bordereau_update_natureEmballage'.$listBordereau[$key]['id'].'" id="bordereau_update_natureEmballage'.$listBordereau[$key]['id'].'" value="'.$listBordereau[$key]['natureEmballage'].'">
                            <input class="form-control mt-1" type="text" name="bordereau_update_contenu'.$listBordereau[$key]['id'].'" id="bordereau_update_contenu'.$listBordereau[$key]['id'].'" value="'.$listBordereau[$key]['contenu'].'">
                        </td>
                    
                        <td>
                            <input class="form-control" type="text" name="bordereau_update_pdsUnKg'.$listBordereau[$key]['id'].'" id="bordereau_update_pdsUnKg'.$listBordereau[$key]['id'].'" value="'.$listBordereau[$key]['pdsUnKg'].'"> 
                            <input class="form-control mt-1" type="text" name="bordereau_update_pdsTotalTone'.$listBordereau[$key]['id'].'" id="bordereau_update_pdsTotalTone'.$listBordereau[$key]['id'].'" value="'.$listBordereau[$key]['pdsTotalTone'].'">
                        </td>
                    
                        <td>
                            <input class="form-control" type="text" name="bordereau_update_puTone'.$listBordereau[$key]['id'].'" id="bordereau_update_puTone'.$listBordereau[$key]['id'].'" value="'.$listBordereau[$key]['puTone'].'">  
                            <input class="form-control mt-1" type="text" name="bordereau_update_ptTone'.$listBordereau[$key]['id'].'" id="bordereau_update_ptTone'.$listBordereau[$key]['id'].'" value="'.$listBordereau[$key]['ptTone'].'">
                        </td>
                    
                        <td>   
                            <input class="form-control" type="text" name="bordereau_update_manque'.$listBordereau[$key]['id'].'" id="bordereau_update_manque'.$listBordereau[$key]['id'].'" value="'.$listBordereau[$key]['manque'].'">
                            <input class="form-control mt-1" type="text" name="bordereau_update_qteArriver'.$listBordereau[$key]['id'].'" id="bordereau_update_qteArriver'.$listBordereau[$key]['id'].'" value="'.$listBordereau[$key]['qteArriver'].'"></td>
                    
                        <td>
                            <input class="form-control" type="text" name="bordereau_update_charge'.$listBordereau[$key]['id'].'" id="bordereau_update_charge'.$listBordereau[$key]['id'].'" value="'.$listBordereau[$key]['charge'].'">
                            <input class="form-control mt-1" type="text" name="bordereau_update_restePayer'.$listBordereau[$key]['id'].'" id="bordereau_update_restePayer'.$listBordereau[$key]['id'].'" value="'.$listBordereau[$key]['restePayer'].'">
                        </td>
                    
                        <td>
                            <input class="form-control" type="text" name="bordereau_update_payement'.$listBordereau[$key]['id'].'" id="bordereau_update_payement'.$listBordereau[$key]['id'].'" value="'.$listBordereau[$key]['payement'].'">
                            <input class="form-control mt-1" type="text" name="bordereau_update_solde'.$listBordereau[$key]['id'].'" id="bordereau_update_solde'.$listBordereau[$key]['id'].'" value="'.$listBordereau[$key]['solde'].'">
                            <input class="form-control" type="hidden" name="bordereau_form_backURL'.$listBordereau[$key]['id'].'" id="bordereau_form_backURL'.$listBordereau[$key]['id'].'" value="/views/home.php?link_up=b5c41067d2aa2806fba285ee55b8a371b35a7a06">
                            <input class="form-control mt-1" type="hidden" name="id" id="'.$listBordereau[$key]['id'].'" value="'.$listBordereau[$key]['id'].'">
                        </td>
                    
                        
                        <td>
                        <button class="btn btn-primary mt-1 text-white w-100" type="button" name="bordereau_form_update" onclick="updateThis('.$listBordereau[$key]['id'].')" ><i class="fa fa-pencil"></i></button>
                            <button class="btn btn-danger mt-1 text-white w-100" type="button" onclick="deleteThis('.$listBordereau[$key]['id'].','.$table.')" ><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                </form>';
        }

    }else{
        $listBordereauData = '';
    }

    if (htmlspecialchars($_GET['page']) == 'home_purchase') {
        $selectField = '';
        if ($conditionReception != '') {
            $listReception = $DB->getWhereMultiple('lieureception',$conditionReception);
        }else{
            $listReception = $DB->get('lieureception','id');
        }

        if(count($listReception) == 0){
            $listReceptionData = '<thead>
            <tr>
                <th>Date</th>
                <th>Lieu</th>
                <th>Address</th>
                <th>Ville</th>
                <th>Pays</th>
                <th>Autre</th>
            </tr>
        </thead>
        <tbody></tbody>';
        }else{
            $listReceptionData = 
            '<thead>
                <tr>
                    <th>Date</th>
                    <th>Lieu</th>
                    <th>Address</th>
                    <th>Ville</th>
                    <th>Pays</th>
                    <th>Autre</th>
                </tr>
            </thead>
            <tbody>';
            $table = "String('lieureception')";
            
            foreach ($listReception as $key => $value) {
                $btnStyle = ($listReception[$key]['status'] == '0') ? 'danger' : 'secondary';
                $listReceptionData = $listReceptionData.
                '<form action="" method="post" id="">
                    <tr>
                        <td><input class="form-control" type="date" name="" id="" placeholder="" value="'.$listReception[$key]['date'].'" placeholder="yyyy-MM-dd"></td>
                        <td>
                        <input class="form-control" type="text" name="" id="" placeholder="" value="'.$listReception[$key]['lieu'].'">
                        </td>
                        <td>
                        <input class="form-control" type="text" name="" id="" placeholder="" value="'.$listReception[$key]['address'].'">
                        </td>
                        <td>
                        <input class="form-control" type="text" name="" id="" placeholder="" value="'.$listReception[$key]['ville'].'">
                        </td>
                        <td>
                        <input class="form-control" type="text" name="" id="" placeholder="" value="'.$listReception[$key]['pays'].'">
                        </td>
                        <td>
                            <button class="btn btn-primary mt-1 text-white" type="submit"><i class="fa fa-pencil"></i></button>
                            <button type="button" class="btn btn-'.$btnStyle.' mt-1" onclick="updateThis('.$listReception[$key]['id'].','.$table.')"><i class="fa fa-eye"></i></button>
                        </td>
                    </tr>
                </form>
                </tbody>';
                $btnStyle = '';
                if ($listReception[$key]['status'] == 1) {
                    $selectField = $selectField.'<option value="'.$value['id'].'">'.$value['lieu'].'</option>';
                }
            }
        }

        if ($conditionReceptionList != '') {
            $stockageData = $DB->getWhereMultipleMore(' *, s.id as sID, s.quantite as sQte FROM stockage s INNER JOIN attribution a ON a.id = s.attribution_id INNER JOIN biens b ON a.biens_id = b.id ',$conditionReceptionList,' ORDER BY s.date DESC ');
        }else{
            $condition = ' s.date Like "%'.date('Y-m').'%" ';
            $stockageData = $DB->getWhereMultipleMore(' *, s.id as sID, s.quantite as sQte FROM stockage s INNER JOIN attribution a ON s.attribution_id = a.id ',$condition,' ORDER BY s.date DESC ');
        }

        if (count( $stockageData) == 0) {
            $receptionPrincipalList = '<thead>
            <th>
                Date
            </th>
            <th width="100">
                Article
            </th>
            <th>
                Receptionner
            </th>
            <th>
                Prix Reception
            </th>
            <th>
                PU Place
            </th>
            </thead>
            <tbody></tbody>';
        }else{
            $receptionPrincipalList = 
            '<thead>
                <th>
                    Date
                </th>
                <th width="100">
                    Article
                </th>
                <th>
                    Receptionner
                </th>
                <th>
                    Prix Reception
                </th>
                <th>
                    PU Place
                </th>
                </thead>
            <tbody>';
            foreach ($stockageData as $key => $stockageDataList) {
                $Bien = $DB->getWhereMultiple('biens',' id = '.$stockageDataList['biens_id'].'');
                $receptionPrincipalList = $receptionPrincipalList.
                    '<tr>
                        <td>'.$stockageDataList["date"].'</td>
                        <td>'.$Bien[0]["designation"].'</td>
                        <td>'.$stockageDataList["sQte"].'</td>
                        <td>'.$stockageDataList["prix"].'</td>
                        <td>
                        <form action="/contollers/MoreControllers/control.php" method="POST">
                            <div class="row">
                                <input type="hidden" name="bien_id" value="'.$Bien[0]["id"].'" class="form-control" id="">
                                <div class="col-md-4 col-12">
                                    <select name="lieu_id" class="form-control" id="">
                                        <option value="">Selectionner Lieu</option>'.$selectField.' 
                                    </select>
                                </div>
                                <div class="col-md-4 col-12">
                                    <input type="text" name="prix_reception" class="form-control" id="">
                                </div>
                                <div class="col-md-4 col-12">
                                    <input type="hidden" name="stockage_id" class="form-control" value="'.$stockageDataList['sID'].'" id="">
                                    <button type="submit" name="add_prix_reception_btn" class="form-control bg-secondary text-white" id="">Enregistrer</button>
                                </div>
                            </div>
                        </form>
                        </td>
                    </tr>
                </tbody>';
            }
        }

        if ($conditionReceptionDataAutrePlace != '') {
            $ReceptionDataAutrePlace = $DB->getWhereMultipleMore(' *, r.id as rID, r.date as rDate FROM receptionautreprix r INNER JOIN biens b ON b.id = r.bien_id INNER JOIN lieureception l ON l.id = r.lieu_id ',$conditionReceptionDataAutrePlace,' ORDER BY r.date DESC ');
        }else{
            $conditionReceptionDataAutrePlace = ' r.date Like "%'.date('Y-m').'%" ';
            $ReceptionDataAutrePlace = $DB->getWhereMultipleMore(' *, r.id as rID, r.date as rDate FROM receptionautreprix r INNER JOIN biens b ON b.id = r.bien_id INNER JOIN lieureception l ON l.id = r.lieu_id ',$conditionReceptionDataAutrePlace,' ORDER BY r.date DESC ');
        }

        if(count($ReceptionDataAutrePlace) == 0){
            $ListReceptionDataAutrePlace = '<thead>
                <th>
                    Date
                </th>
                <th width="300">
                    Article
                </th>
                <th>
                    Receptionner
                </th>
                <th>
                    Prix Reception
                </th>
                <th>
                    PU Place
                </th>
                <th>
                    Place
                </th>
            </thead>
            <tbody></tbody>';
        }else{
            $ListReceptionDataAutrePlace = '<thead>
            <th>
                Date
            </th>
            <th width="300">
                Article
            </th>
            <th>
                Receptionner
            </th>
            <th>
                Prix Reception
            </th>
            <th>
                PU Place
            </th>
            <th>
                Place
            </th>
            </thead>
            <tbody>';
            $table = "String('receptionautreprix')";
            foreach ($ReceptionDataAutrePlace as $key => $ReceptionDataAutrePlaceList) {
                $Bien = $DB->getWhereMultiple('biens',' id = '.$ReceptionDataAutrePlaceList['bien_id'].'');
                $stockage = $DB->getWhereMultiple('stockage',' id = '.$ReceptionDataAutrePlaceList['stockage_id'].'');
                $ListReceptionDataAutrePlace = $ListReceptionDataAutrePlace.
                '<tr>
                    <td>'.$ReceptionDataAutrePlaceList["rDate"].'</td>
                    <td>'.$Bien[0]["designation"].'</td>
                    <td>'.$stockage[0]["quantite"].'</td>
                    <td>'.$ReceptionDataAutrePlaceList["prix_reception"].'</td>
                    <td>'.$ReceptionDataAutrePlaceList["lieu"].' - '.$ReceptionDataAutrePlaceList["address"].' - '.$ReceptionDataAutrePlaceList["ville"].' - '.$ReceptionDataAutrePlaceList["pays"].'</td>
                    <td><button type="submit" class="btn btn-danger"  onclick="deleteThis('.$ReceptionDataAutrePlaceList['rID'].','.$table.')"><i class="fa fa-trash"></i></button></td>
                </tr>
                </tbody>';
            }
        }


    }else{
        $receptionPrincipalList = '';
        $listReceptionData = '';
        $ListReceptionDataAutrePlace = '';
    }

    if (htmlspecialchars($_GET['page']) == 'depense_modal') {
        $selectedDataCourse = '';
        $selectedDataDetails = '';
        if(isset($_GET['modal']) and !empty($_GET['modal'])){
            $listAgent = $DB->getWhere('agent','active','1');
            if($_GET['modal'] == 'undefined'){
                $listCourse = $DB->get('coursetransport','date');
                $selectedDataCourse = $selectedDataCourse.'';
                $conducteurFullName = '';
                $selectedDataCourse = '<option value="">Selectionner Course</option>';
                $selectedDataDetails = '<option value="">Selectionner Course</option>';
                    foreach ($listCourse as $key => $value) {
                        foreach ($listAgent as $key2 => $value) {
                        if ($listCourse[$key]['conducteur'] == $listAgent[$key2]['id']) {
                            if ($listAgent[$key2]['active'] == '1') {
                                $conducteurFullName = $listAgent[$key2]['nom'].' '.$listAgent[$key2]['postnom'].' '.$listAgent[$key2]['prenom'];
                                $selectedDataCourse = $selectedDataCourse.'<option value="'.$listCourse[$key]['conducteur'].'">'.$conducteurFullName.' Le '.$listCourse[$key]['date'].'</option>';
                                $selectedDataDetails = $selectedDataDetails.'<option value="'.$listCourse[$key]['id'].'">'.' Le '.$listCourse[$key]['date'].' '.$conducteurFullName.' Destination '.$listCourse[$key]['destination'].'</option>';
                            }
                        }
                        }
                    }
            }else{
                $data = $DB->getWhere('coursetransport','id',htmlspecialchars($_GET['modal']));
                $conducteurFullName = '';
                    foreach ($data as $key => $value) {
                        foreach ($listAgent as $key2 => $value) {
                            if ($data[$key]['conducteur'] == $listAgent[$key2]['id']) {
                                if ($listAgent[$key2]['active'] == '1') {
                                    $conducteurFullName = $listAgent[$key2]['nom'].' '.$listAgent[$key2]['postnom'].' '.$listAgent[$key2]['prenom'];
                                    $selectedDataCourse = $selectedDataCourse.'<option value="'.$data[$key]['conducteur'].'" selected>'.$conducteurFullName.' Le '.$data[$key]['date'].'</option>';
                                    $selectedDataDetails = $selectedDataDetails.'<option value="'.$data[$key]['id'].'">'.' Le '.$data[$key]['date'].' '.$conducteurFullName.' Destination '.$data[$key]['destination'].'</option>';
                                }
                            }
                        }
                    }
            } 
        }
    }else{
        $selectedDataCourse = '';
        $selectedDataDetails = '';
    }  

    echo json_encode(
        array(
            'factureData'=>$factureData,
            'selectedData'=>array(
                'selectedDataCourse'=>$selectedDataCourse,
                'selectedDataDetails'=>$selectedDataDetails
            ),
            'htmlDettePage'=>$listDetteData,
            'htmlDepensePage'=>$listDepenseData,
            'listBordereau'=>$listBordereauData,
            'htmlConducteurPage'=>array(
                'listCourse'=>$typeCourseData,
                'lisDepenseCourse'=>$lisDepenseCourse,
                'listConducteur'=>$listConducteurData,
                'listVehicule'=>$listVehiculeData,
                'listTypeDepense'=>$typeDepenseData
            ),
            'htmlCaissePage'=>array(
                'entre'=>$listCaisseData,
                'sortie'=>$listCaisseDataSortie,
                'dollars'=>$format->formatCurrency($dollars,'usd'),
                'fc'=>$format->formatCurrency($fc,'fcf'),
                'frw'=>$format->formatCurrency($frw,'frw'),
                'listBanque'=>$listBanque
            ),
            'homePurchase'=>array(
                'listReceptionPlace'=>$listReceptionData,
                'receptionPrincipalList'=>$receptionPrincipalList,
                'ListReceptionDataAutrePlace'=>$ListReceptionDataAutrePlace
            )
        )
    );
}

$DB = new DB();

if(isset($_GET['Local'])){
    if(isset($_POST['validate_n_facture_btn'])){
        $validate_n_facture_btn = htmlspecialchars($_POST['selected_date']);
        $loop = 0;
        $table = 'numfacturelocal';
        while ($loop == 0){
            $nFacture = 'JKL'.rand();
            $get = $DB->getwhere($table,'id',$nFacture);
            if(count($get) == 0) {
                
                $field = '(numerofacture,date)';
                $prepared = '?,?';
                
                $value = array(
                    $nFacture,
                    securise($validate_n_facture_btn),
                );
                $loop = add($table,$field,$prepared,$value) ? 1 : 0;
                if($loop == 1){
                    echo json_encode(
                        array(
                            'htmlFactureNumber'=>
                                array(
                                    'nFacture'=> $nFacture,
                                    'dateVente'=>$validate_n_facture_btn
                            )
                        )
                    );
                }
            }
        }
    }

    if (isset($_POST['produitEnregistrer'])) {
        $table = 'articlesystemlocal';
        $field = '(article,quantite,emballage,prix)';
        $prepared = '?,?,?,?';
        
        $value = array(
            securise($_POST['article']),
            securise($_POST['quantite']),
            securise($_POST['emballage']),
            securise($_POST['prix']),
        );
        if (add($table,$field,$prepared,$value) == true) {
            echo json_encode(
                array('htmlArticleAdd'=>array('status'=>'success','sms'=>'Produit ajouter avec success!','article'=>ListArticle()))
            );
        }else{
            echo json_encode(
                array('htmlArticleAdd'=>array('status'=>'echec','sms'=>'Echec d\'enregistrement ...','article'=>''))
            );
        } 
    }

    if (isset($_POST['depotEnregistrer'])) {
        $table = 'depot';
        $field = '(description,gerant,date)';
        $prepared = '?,?,?';
        
        $value = array(
            securise($_POST['depot']),
            securise($_POST['gerant']),
            date('Y-m-d',time())
        );

        if (add($table,$field,$prepared,$value) == true) {
            echo json_encode(
                array('html'=>array('status'=>'success','sms'=>'Ajouter avec success!','ListDepot'=>ListDepot()))
            );
        }else{
            echo json_encode(
                array('html'=>array('status'=>'echec','sms'=>'Echec d\'enregistrement ...','ListDepot'=>''))
            );
        } 
    }

    if (isset($_POST['approvisionEnregistrer'])) {
        $table = 'approvisiondepot';
        $field = '(depotID,articleID,quantite,date)';
        $prepared = '?,?,?,?';
        
        $value = array(
            securise($_POST['OptionDepot']),
            securise($_POST['article']),
            securise($_POST['quantiteStocker']),
            securise($_POST['dateAppro']),
        );

        $getArticle = $DB->getWhere('articlesystemlocal','id',securise($_POST['article']));
        if (count($getArticle) > 0) {
            $summeQtite = $getArticle[0]['quantite'] + securise($_POST['quantiteStocker']);
            $updateArticle = $DB->update('articlesystemlocal',' quantite = ? ',' id = ? ',array($summeQtite,securise($_POST['article'])));
            if($updateArticle == false){
                echo json_encode(
                    array('html'=>array('status'=>'echec','sms'=>'Echec d\'enregistrement ...','ListApprovision'=>''))
                );
                return;
            }
        }else{
            $updateArticle = false; 
        } 

        if ($updateArticle == true) {
            if (add($table,$field,$prepared,$value) == true) {
                echo json_encode(
                    array('html'=>array('status'=>'success','sms'=>'Ajouter avec success!','ListApprovision'=>ListApprovision()))
                );
            }else{
                echo json_encode(
                    array('html'=>array('status'=>'echec','sms'=>'Echec d\'enregistrement ...','ListApprovision'=>''))
                );
            } 
        }else{
            echo json_encode(
                array('html'=>array('status'=>'echec','sms'=>'Echec d\'enregistrement ...','ListApprovision'=>''))
            );
        }
    }


    if (isset($_POST['nFacture'])) {
        $table = 'stockvente';
        $field = '(date,nFacture,numero_surFacture,articleFacturer,quantiteFacturer,prixFacturer,depotID,factureDe)';
        $prepared = '?,?,?,?,?,?,?,?';

        if(securise($_POST['nFacture']) == ''){
            echo json_encode(
                array('htmlVente'=>array('status'=>'echec','sms'=>'Echec d\' enregistrement ... Vous avez pas selectionner de numero systeme.','article'=>''))
            );
            return;
        }

        if(securise($_POST['dateVente']) == '0000-00-00' || securise($_POST['dateVente']) == ''){
            echo json_encode(
                array('htmlVente'=>array('status'=>'echec','sms'=>'Echec d\' enregistrement ... veuiller entre une date.','article'=>''))
            );
            return;
        }

        $quantite = 0;

        $approvision = $DB->getWhereMultiple('approvisiondepot','articleID = "'.securise($_POST['articleFacturer']).'" and depotID = "'.securise($_POST['OptionDepotVente']).'"');
        $sommeAppro = 0;
        foreach ($approvision as $key => $value1) {
            $sommeAppro = $sommeAppro + $value1['quantite'];
        }

        $vente = $DB->getWhereMultiple('stockvente','articleFacturer = "'.securise($_POST['articleFacturer']).'" and depotID = "'.securise($_POST['OptionDepotVente']).'"');
        $sommeVendu = 0;
        foreach ($vente as $key => $value2) {
            $sommeVendu = $sommeVendu + $value2['quantiteFacturer'];
        }

        $quantite = $sommeAppro - $sommeVendu;
        
        $articleRow = $DB->getWhereMultipleMore(' * FROM articlesystemlocal ','id = '.securise($_POST['articleFacturer']).' AND quantite > 0 ');
        
        $facture = $DB->getWhere('numfacturelocal','numerofacture',securise($_POST['nFacture']));
        if (count($facture) == 0) {
            $added = add('numfacturelocal','(numerofacture,date)','?,?',array(securise($_POST['nFacture']),securise($_POST['dateVente'])));
            if ($added == false) {
                echo json_encode(
                    array('htmlVente'=>array('status'=>'echec','sms'=>'Echec d\' enregistrement ...','article'=>''))
                );
                return;
            }
        }


        if (count($articleRow) > 0) {
            if ($articleRow[0]['quantite'] >= securise($_POST['quantiteFacturer']) and $quantite >= securise($_POST['quantiteFacturer']) ) {
                $stock = $articleRow[0]['quantite'] - securise($_POST['quantiteFacturer']);
                $update = $DB->update('articlesystemlocal' ,'quantite = ?', 'id = ?', [''.$stock.'',''.securise($_POST['articleFacturer']).'']);
                if ($update) {
                    $value = array(
                        securise($_POST['dateVente']),
                        securise($_POST['nFacture']),
                        securise($_POST['numero_surFacture']),
                        securise($_POST['articleFacturer']),
                        securise($_POST['quantiteFacturer']),
                        securise($_POST['prixFacturer']),
                        securise($_POST['OptionDepotVente']),
                        securise($_POST['FactureDe'])
                    );
                    if (add($table,$field,$prepared,$value) == true) {
                        echo json_encode(
                            array('htmlVente'=>array('status'=>'success','sms'=>'La vente a été enregistrer.','article'=>ListVente($_POST['nFacture'])))
                        );
                    }else{
                        echo json_encode(
                            array('htmlVente'=>array('status'=>'echec','sms'=>'Echec, d\'enregistrement.','article'=>''))
                        );
                    } 
                }else{
                    echo json_encode(
                        array('htmlVente'=>array('status'=>'echec','sms'=>'Echec, la modification du stock non effectuer.','article'=>''))
                    );
                }
            }else{
                echo json_encode(
                    array('htmlVente'=>array('status'=>'echec','sms'=>'Stock Insuffisant','article'=>''))
                );
            }
        } else {
            echo json_encode(
                array('htmlVente'=>array('status'=>'echec','sms'=>'Echec, quantite stock insuffisant d\'article ou article inconnu.','article'=>''))
            );
        }  
    }

    if ($_GET['Local'] == 'start') {
        $id = '';
        if (isset($_GET['id'])) {
            if(isset($_POST['dateStart']) and isset($_POST['dateEnd'])){
                $venteFuntion = ListVente($_GET['id'],$_POST['dateStart'],$_POST['dateEnd'],$_POST['FactureDefiltre'],$_POST['OptionDepotDe']);
            }else{
                $venteFuntion = ListVente($_GET['id']);
            }
            $id = $_GET['id'];
        }else{
            if(isset($_POST['dateStart']) and isset($_POST['dateEnd'])){
                $venteFuntion = ListVente('',$_POST['dateStart'],$_POST['dateEnd'],$_POST['FactureDefiltre'],$_POST['OptionDepotDe']);
            }else{
                $venteFuntion = ListVente();
            } 
        }

        if(isset($_POST['optionID'])){
            $optionID = htmlspecialchars($_POST['optionID']);
        }else{
            $optionID = '';
        }

        if(isset($_POST['articleFilter'])){
            $articleFilter = htmlspecialchars($_POST['articleFilter']);
        }else{
            $articleFilter = '';
        }

       echo json_encode(array('htmlArticle'=>array('ListApprovision'=>ListApprovision(),'OptionDepot'=>OptionDepot(),'ListDepot'=>ListDepot(),'article'=>ListArticle($articleFilter,$optionID),'OptionArticle'=> OptionArticle (),'vente'=>$venteFuntion,'id'=>$id)));
    }

    if ($_GET['Local'] == sha1('delete')) {

        if ($_POST['to'] == 'articlesystemlocal') {
            $vente = $DB->getWhere('stockvente','articleFacturer',htmlspecialchars($_POST['id']));
            if (count($vente) > 0) {
                echo json_encode(array('msg'=>'vous ne pouvez pas supprimer un article déjà creer, car des ventes y sont associer.','status'=>'fail'));
                return;
            }

            $delete = delete('articlesystemlocal' ,'id', htmlspecialchars($_POST['id']));
            if ($delete == true ) {
                echo json_encode(array('msg'=>'L\'opération a été effectuer avec success','status'=>'success'));
            }else{
                echo json_encode(array('msg'=>'Echecs d\'opération ...','status'=>'fail'));
            }
        }else if ($_POST['to'] == 'approvisiondepot') {

            $appro = $DB->getWhere('approvisiondepot','id',htmlspecialchars($_POST['id'])); 
            if (count($appro) > 0) {
                $article = $DB->getWhere('articlesystemlocal','id',$appro[0]['articleID']); 
                if (count($article) == 0) {
                    echo json_encode(array('msg'=>'Echecs d\'opération ... article non retrouver.','status'=>'fail'));
                    return;
                }

                if(date('Y-m-d', time() + 86400) > $appro[0]['date']){
                    echo json_encode(array('msg'=>'Echecs d\'opération ... lare pour une modification est passer, veuiller contacter les administrateurs.','status'=>'fail'));
                    return;
                }

                $qteStock = $article[0]['quantite'] - $appro[0]['quantite'];
                $update = $DB->update('articlesystemlocal','quantite = ?','id = ?',[''.$qteStock.'',''.$appro[0]['articleID'].'']);
                if ($update == false) {
                    echo json_encode(array('msg'=>'Echecs d\'opération ... Probleme modification stock.','status'=>'fail'));
                    return;
                }
            }else{
                echo json_encode(array('msg'=>'Echecs d\'opération ...approvisionnement inconnu.','status'=>'fail'));
                return;
            }

            $delete = delete('approvisiondepot' ,'id', htmlspecialchars($_POST['id']));
            if ($delete == true ) {
                echo json_encode(array('msg'=>'L\'opération a été effectuer avec success','status'=>'success'));
            }else{
                echo json_encode(array('msg'=>'Echecs d\'opération ...','status'=>'fail'));
            }
        }else{

            $idVente = htmlspecialchars($_POST['id']);

            if ($_POST['venteID'] == '') {
                $sells = $DB->getWhere('stockvente','nFacture',htmlspecialchars($_POST['id']));
            }else{
                $sells = $DB->getWhere('stockvente','id',htmlspecialchars($_POST['venteID']));
            }
            if (count($sells) > 0) {
                $sell_somme = 0;
                foreach ($sells as $key => $value) {
                    $article = $DB->getWhere('articlesystemlocal','id',$value['articleFacturer']);
                    if (count($article) > 0) {
                        $sell_somme = $article[0]['quantite'];
                        $qteStock = $value['quantiteFacturer'] + $sell_somme;
                        $update = $DB->update('articlesystemlocal','quantite = ?','id = ?',[''.$qteStock.'',''.$article[0]['id'].'']);
                    }
                }

                if ($update) {
                    if ($_POST['venteID'] == '') {
                        $delete1 = delete('stockvente' ,'nFacture', htmlspecialchars($_POST['id']));
                        $delete2 = delete('numfacturelocal' ,'numerofacture', htmlspecialchars($_POST['id']));
                    }else{
                        $delete1 = delete('stockvente' ,'id', htmlspecialchars($_POST['venteID']));
                        $delete2 = true;
                    }
                    
                    if ($delete1 and $delete2) {
                        echo json_encode(array('msg'=>'L\'opération a été effectuer avec success','status'=>'success', 'idVente'=> $idVente));
                    }else if ($delete1 == false and $delete2 == true) {
                        echo json_encode(array('msg'=>'L\'opération a été effectuer mais la vente existe toujour.','status'=>'success', 'idVente'=> $idVente));
                    }else if ($delete1 == true and $delete2 ==  false) {
                        echo json_encode(array('msg'=>'L\'opération a été effectuer mais le numero existe toujour.','status'=>'success', 'idVente'=> $idVente));
                    }else{
                        echo json_encode(array('msg'=>'Echecs de suppression ...','status'=>'fail', 'idVente'=> $idVente));
                    }
                    return;
                }else{
                    $sms = '';
                    $delete = false;
                }
            }else{
                $sms =  '';
                $delete = false;
            }

            if ($delete == true ) {
                echo json_encode(array('msg'=>'L\'opération a été effectuer avec success','status'=>'success', 'idVente'=> $idVente));
            }else{
                echo json_encode(array('msg'=>'Echecs d\'opération ... '.$sms.'','status'=>'fail', 'idVente'=> $idVente));
            }
        }
        
     }

     if ($_GET['Local'] == sha1('update')) {

        $value = array(
            htmlspecialchars($_POST['articleUpdate_']),
            htmlspecialchars($_POST['quantiteUpdate_']),
            htmlspecialchars($_POST['emballageUpdate_']),
            htmlspecialchars($_POST['prixUpdate_']),
            htmlspecialchars($_POST['id'])
        );  

        $update = update(htmlspecialchars($_POST['table']) ,' article = ?,quantite = ?, emballage = ?,prix = ? ', ' id = ? ', $value);

        if ($update == true ) {
            echo json_encode(array('msg'=>'L\'opération a été effectuer avec success','status'=>'success'));
        }else{
            echo json_encode(array('msg'=>'Echecs d\'opération ...','status'=>'fail'));
        } 
     }
}

function ListApprovision(){
    $DB = new DB();
    $num = 1;
    $appro = 
    '<thead>
        <tr>
            <th>N°</th>
            <th>Date</th>
            <th>Produit</th>
            <th>Quantite</th>
            <th>Depot</th>
            <th>Operation</th>
        </tr>
    </thead>
    <tbody>';
    $table = "String('approvisiondepot')";
    $list = $DB->getWhereMultipleMore(' *, app.id as appID, app.date as appDate, app.quantite as appQuantite FROM approvisiondepot app INNER JOIN articlesystemlocal art ON app.articleID = art.id INNER JOIN depot d ON app.depotID = d.id ', ' app.id != ""', ' ORDER BY app.id DESC ');
    foreach ($list as $key => $value) {
        $appro = $appro.'
        <form action="" method="post">
            <tr>
                <td>'.$num.'</td>
                <td>
                    <input type="date" class="form-control" name="dateUpdate_'.$list[$key]['appID'].'" id="dateUpdate_'.$list[$key]['appID'].'"  value="'.$value['appDate'].'">
                </td>
                <td>
                    <input type="text" class="form-control" name="appArticleUpdate_'.$list[$key]['appID'].'" id="appArticleUpdate_'.$list[$key]['appID'].'"  value="'.$value['article'].'">
                </td>
                <td>
                    <input type="text" class="form-control" name="appQuantiteUpdate_'.$list[$key]['appID'].'" id="appQuantiteUpdate_'.$list[$key]['appID'].'"  value="'.$value['appQuantite'].'">
                </td>
                <td>
                    <input type="text" class="form-control" name="appDepotUpdate_'.$list[$key]['appID'].'" id="appDepotUpdate_'.$list[$key]['appID'].'"  value="'.$value['description'].'" readonly>
                </td>
                <td>
                    <button type="button" class="btn btn-secondary mt-1" onclick="updateThis('.$list[$key]['appID'].','.$table.')"><i class="fa fa-pencil-square-o"></i></button>
                    <button type="button" class="btn btn-danger mt-1" onclick="deleteThis('.$list[$key]['appID'].','.$table.')"><i class="fa fa-trash-o"></i></button>
                </td>
            </tr>
        </form>';
        $num ++;
    }
    $appro = $appro.
    '</tbody>';
    return $appro;
}

function ListDepot(){
    $DB = new DB();
    $num = 1;
    $depot = 
    '<thead>
        <tr>
            <th>N°</th>
            <th>Depot</th>
            <th>Gerant</th>
            <th>Operation</th>
        </tr>
    </thead>
    <tbody>';
    $table = "String('depot')";
    $list = $DB->get('depot');
    foreach ($list as $key => $value) {
        $depot = $depot.'
        <form action="" method="post">
            <tr>
                <td>'.$num.'</td>
                <td>
                    <input type="text" class="form-control" name="depotUpdate_'.$list[$key]['id'].'" id="depotUpdate_'.$list[$key]['id'].'"  value="'.$value['description'].'">
                </td>
                <td>
                    <input type="text" class="form-control" name="gerantUpdate_'.$list[$key]['id'].'" id="gerantUpdate_'.$list[$key]['id'].'"  value="'.$value['gerant'].'">
                </td>
                <td>
                    <button type="button" class="btn btn-secondary mt-1" onclick="updateThis('.$list[$key]['id'].','.$table.')"><i class="fa fa-pencil-square-o"></i></button>
                    <button type="button" class="btn btn-danger mt-1" onclick="deleteThis('.$list[$key]['id'].','.$table.')"><i class="fa fa-trash-o"></i></button>
                </td>
            </tr>
        </form>';
        $num ++;
    }
    $depot = $depot.
    '</tbody>';
    return $depot;
}

function ListArticle ($articleFilter = '' ,$optionID = ''){
    $DB = new DB();
    $num = 1;
    $article = 
    '<thead>
        <tr>
            <th>N°</th>
            <th>Produit/Emballage</th>
            <th>Qte Stock/Prix Vente $</th>
            <th>Operation</th>
        </tr>
    </thead>
    <tbody>';
    if (!empty($articleFilter)) {
        $articleFilter = ' and article Like "%'.$articleFilter.'%" ';
    }else{
        $articleFilter = '';
    }
    $table = "String('articlesystemlocal')";
    $list = $DB->getWhereMultiple('articlesystemlocal','status = 1 '.$articleFilter.'');
    foreach ($list as $key => $value) {
        if($value['quantite'] != 0){
            if(!empty($optionID)){
                
                $approvision = $DB->getWhereMultiple('approvisiondepot','articleID = "'.$value['id'].'" and depotID = "'.$optionID.'"');
                $sommeAppro = 0;
                foreach ($approvision as $key => $value1) {
                    $sommeAppro = $sommeAppro + $value1['quantite'];
                }

                $vente = $DB->getWhereMultiple('stockvente','articleFacturer = "'.$value['id'].'" and depotID = "'.$optionID.'"');
                $sommeQuantite = 0;
                foreach ($vente as $key => $value2) {
                    $sommeQuantite = $sommeQuantite + $value2['quantiteFacturer'];
                }

                $quantite = $sommeAppro - $sommeQuantite;
                $sommeAppro = 0;
                $sommeQuantite = 0;
            }else{
                $quantite = $value['quantite'];
            }

            if($quantite < 500){
                $background_color = 'bg-danger text-white';
            }else{
                $background_color = 'bg-dark text-white';
            }
            
            $article = $article.'
            <form action="" method="post">
                <tr>
                    <td>'.$num.'</td>
                    <td>
                        <input type="text" class="form-control" name="articleUpdate_'.$value['id'].'" id="articleUpdate_'.$value['id'].'"  value="'.$value['article'].'">
                        <input type="text" class="form-control mt-2" name="emballageUpdate_'.$value['id'].'" id="emballageUpdate_'.$value['id'].'"  value="'.$value['emballage'].'">
                    </td>
                    <td>
                        <input type="text" class="form-control '.$background_color.'" name="quantiteUpdate_'.$value['id'].'" id="quantiteUpdate_'.$value['id'].'"  value="'.$quantite.'">
                        <input type="text" class="form-control mt-2" name="prixUpdate_'.$value['id'].'" id="prixUpdate_'.$value['id'].'" value="'.$value['prix'].'">
                    </td>
                    <td>
                        <button type="button" class="btn btn-secondary mt-1" onclick="updateThis('.$value['id'].','.$table.')"><i class="fa fa-pencil-square-o"></i></button>
                        <button type="button" class="btn btn-danger mt-1" onclick="deleteThis('.$value['id'].','.$table.')"><i class="fa fa-trash-o"></i></button>
                    </td>
                </tr>
            </form>';
            $num ++;
        }
    }
    $article = $article.
    '</tbody>';
    return $article;
}

function ListVente($nFacture = '', $dateStart = '', $dateEnd = '', $FactureDefiltre = '', $OptionDepotDe = ''){
    $vente = 
    '<thead>
        <tr>
        <th class="small">Date</th>
        <th class="small">Facture</th>
        <th class="small">Contenu</th>
        <th class="small">Operation</th>
        </tr>
    </thead>
    <tbody>';
    $DB = new DB();
    if ($FactureDefiltre == '') {
        $FactureDefiltre = '';
    }else{
        $FactureDefiltre = ' and sv.factureDe = "'.$FactureDefiltre.'" ';
    }

    if ($OptionDepotDe == '') {
        $OptionDepotDe = '';
    }else{
        $OptionDepotDe = ' and sv.depotID = "'.$OptionDepotDe.'" ';
    }

    if ($nFacture == '') {
        if(!empty($dateStart) and !empty($dateEnd)){
            $list = $DB->getWhereMultiple('numfacturelocal',' date >= "'.$dateStart.'" and date <= "'.$dateEnd.'" ');
        }else{
            $list = $DB->getWhereMultiple('numfacturelocal','date Like "%'.date('Y-m-d').'%"');
        }
    }else{
        if(!empty($dateStart) and !empty($dateEnd) and !empty($nFacture)){
            $list = $DB->getWhereMultiple('numfacturelocal',' numerofacture = "'.$nFacture.'" and date >= "'.$dateStart.'" and date <= "'.$dateEnd.'"');
        }else if (!empty($dateStart) and !empty($dateEnd)) {
            $list = $DB->getWhereMultiple('numfacturelocal',' date >= "'.$dateStart.'" and date <= "'.$dateEnd.'"');
        }else{
            $list = $DB->getWhereMultiple('numfacturelocal',' numerofacture = "'.$nFacture.'" and date Like "%'.date('Y-m-d').'%"'); 
        }
    }
    $prixT = 0;
    foreach ($list as $key => $value) {
        $table = "String('stockvente')";
        $stockvente = $DB->getWhereMultipleMore(' *, sv.id as sID From stockvente sv INNER JOIN articlesystemlocal a ON sv.articleFacturer = a.id ',' sv.nFacture = "'.$value['numerofacture'].'" '.$FactureDefiltre.' '.$OptionDepotDe.' ' ,' ORDER BY sv.id DESC ');
        $s = 0;
        $stockVenteList = '';
        if (count($stockvente) > 0) {
            foreach ($stockvente as $key => $valueVente) {
                $nFactureLocal = "String('".$valueVente['nFacture']."')";
                $stockVenteList =  $stockVenteList.
                    '<tr>
                        <td>'.$valueVente['article'].'</td>
                        <td>'.$valueVente['quantiteFacturer'].'</td>
                        <td>'.$valueVente['emballage'].'</td>
                        <td>'.$valueVente['prixFacturer'].' $</td>
                        <td><button type="button" class="btn"  onclick="deleteThis('.$nFactureLocal.','.$table.','.$valueVente["sID"].')"><i class="fa fa-times"></i></button></td>
                    </tr>';
                    $s = $s + $valueVente['prixFacturer'];
            }
            $nFacture = "String('".$valueVente['nFacture']."')";
            $vente = $vente.'
            <tr>
                <td>'.$value['date'].'</td>
                <td><strong class="border-bottom border-2 border-dark"> N° Facture </strong> <br> '.$valueVente['numero_surFacture'].' <br> <strong class="border-bottom border-2 border-dark"> ID SYSTEM </strong><br> '.$value['numerofacture'].'</td>
                <td >
                    <div style="max-height:150px; overflow:auto;">
                        <table class="table">
                            <tbody>
                                '.$stockVenteList.'
                                <tr>
                                    <td>Total </td>
                                    <td></td>
                                    <td></td>
                                    <td>'.$s.' $</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
                <td>
                    <button type="button" class="btn btn-danger"  onclick="deleteThis('.$nFacture.','.$table.')"><i class="fa fa-trash-o"></i></button>
                </td>
            </tr>';
        }
        $prixT = $prixT + $s;
    }
    $vente = $vente.'
    <tr>
        <td>Prix Total Vendu</td>
        <td class="bg-info">'.$prixT.' $</td>
    </tr>
    </tbody>';
    return $vente;
}

function OptionDepot (){
    $DB = new DB();
    $option = '<option value="">SELECTIONNER DEPOT</option>';
    $list = $DB->get('depot');
    foreach ($list as $key => $value) {
        $option = $option.'<option value="'.$value['id'].'">'.$value['description'].'</option>';
    }
    return $option;
}
function OptionArticle (){
    $DB = new DB();
    $option = '<option value="">SELECTIONNER PRODUIT</option>';
    $list = $DB->getWhereMultiple('articlesystemlocal','status = 1');
    foreach ($list as $key => $value) {
        $option = $option.'<option value="'.$value['id'].'">'.$value['article'].'</option>';
    }
    return $option;
}

/* --------------------------------------------------- CHECKING CONDITION FROM FORM TO INSERT, DELETE AND UPDATE DATA IN THE DATABASE -----------------------------------------------------*/


    if (isset($_GET['request']) and $_GET['request'] == sha1('update')) {
        if (isset($_POST['to'])) {
            $getData = $DB->getwhere(htmlspecialchars($_POST['to']),'id',htmlspecialchars($_POST['id']));
            if (count($getData) > 0) {
                $status = $getData[0]['status'];
                if ($status == 0) {
                    $val = '1';
                }else{
                    $val = '0';
                }
            }else{
                $val = '1';
            }

            $update = update(htmlspecialchars($_POST['to']) ,'status = ?', 'id = ?', [''.$val.'',''.htmlspecialchars($_POST['id']).'']);
        }else if(isset($_POST['table'])){
            if($_POST['table'] == 'coursetransport'){
                $data = array(
                   htmlspecialchars($_POST['courseTransportDate_']),
                   htmlspecialchars($_POST['courseTransportDestination_']),
                   htmlspecialchars($_POST['courseTransportContenu_']),
                   htmlspecialchars($_POST['courseTransportTonne_']),
                   htmlspecialchars($_POST['prixCourse_']),
                   htmlspecialchars($_POST['courseTransportDescription_']),
                   htmlspecialchars($_POST['id'])
                );

                $prepared = ' date = ?, destination = ?, contenu = ?, tonne = ?, prixCourse = ?, description = ?';

                $condition = ' id = ?';

                $update = update(htmlspecialchars($_POST['table']) ,$prepared, $condition, $data);
            }else{
                $update = true; 
            }
            
        }
        

        if ($update == true ) {
            echo json_encode(array('msg'=>'L\'opération a été effectuer avec success','status'=>'success'));
        }else{
            echo json_encode(array('msg'=>'Echecs d\'opération ...','status'=>'fail'));
        }
    }

    if (isset($_GET['request']) and $_GET['request'] == sha1('delete')) {
        if (htmlspecialchars($_POST['to']) =='coursetransport') {
            $delete = delete(htmlspecialchars($_POST['to']) ,'id', htmlspecialchars($_POST['id']));
            $delete = delete('depensetransport' ,'courseTransportID', htmlspecialchars($_POST['id']));
        }else{
            $delete = delete(htmlspecialchars($_POST['to']) ,'id', htmlspecialchars($_POST['id']));
        }
        
        if ($delete == true ) {
            echo json_encode(array('msg'=>'L\'opération a été effectuer avec success','status'=>'success'));
        }else{
            echo json_encode(array('msg'=>'Echecs d\'opération ...','status'=>'fail'));
        }  
    }

    if (isset($_POST['add_prix_reception_btn'])) {
        $table = 'receptionautreprix';
        $field = '(date,bien_id,lieu_id,prix_reception,stockage_id,addedbyID)';
        $prepared = '?,?,?,?,?,?';
        
        $value = array(
            date('Y-m-d',time()),
            securise($_POST['bien_id']),
            securise($_POST['lieu_id']),
            securise($_POST['prix_reception']),
            securise($_POST['stockage_id']),
            $_SESSION['idutilisateur']
        );
        if (add($table,$field,$prepared,$value) == true) {
            header('Location: ../../views/home.php?link_up=f2f9fc024f04be0e4612bb0f35a3a1514a7a1bdb&msg=Prix ajouter avec success.');
        }else{
            header('Location: ../../views/home.php?link_up=f2f9fc024f04be0e4612bb0f35a3a1514a7a1bdb&msg=Echecs veuiller reesseyer.');
        } 
    }

    if (isset($_POST['save_new_depense'])) {
        $table = 'depense';
        $field = '(date,montant,categorieDepense,description,addedbyID)';
        $prepared = '?,?,?,?,?';
        if(securise($_POST['currency']) == 'FC'){
           $amount = securise($_POST['amount']) / securise($_POST['taux']);
        }else{
            $amount = securise($_POST['amount']); 
        }
        
        $value = array(
            securise($_POST['date']),
            $amount,
            securise($_POST['category']),
            securise($_POST['description']),
            $_SESSION['idutilisateur']
        );
        if (add($table,$field,$prepared,$value) == true) {
            echo json_encode(array('msg'=>'La depense a été ajouté','status'=>'success','page'=>'save_new_depense'));
        }else{
            echo json_encode(array('msg'=>'Echecs d\'opération ...','status'=>'fail','page'=>'save_new_depense'));
        }   
    }

    if (isset($_POST['add_banque'])) {
        $table = 'comptebanque';
        $field = '(date,banque,n_compte,description,addedbyID)';
        $prepared = '?,?,?,?,?';
        
        $value = array(
            securise($_POST['dateCompte']),
            securise($_POST['Banque']),
            securise($_POST['nCompte']),
            securise($_POST['descriptionBanque']),
            $_SESSION['idutilisateur']
        );
        if (add($table,$field,$prepared,$value) == true) {
            echo json_encode(array('msg'=>'Le compte a été ajouté','status'=>'success','page'=>'add_banque'));
        }else{
            echo json_encode(array('msg'=>'Echecs d\'opération ...','status'=>'fail','page'=>'add_banque'));
        }   
    }

    if (isset($_POST['add_lieu_reception'])) {
        $table = 'lieureception';
        $field = '(lieu,address,ville,pays,date,addedbyID)';
        $prepared = '?,?,?,?,?';
        
        $value = array(
            securise($_POST['lieu']),
            securise($_POST['address']),
            securise($_POST['ville']),
            securise($_POST['pays']),
            date('Y-m-d',time()),
            $_SESSION['idutilisateur']
        );
        if (add($table,$field,$prepared,$value) == true) {
            echo json_encode(array('msg'=>'Le compte a été ajouté','status'=>'success','page'=>'add_lieu_reception'));
        }else{
            echo json_encode(array('msg'=>'Echecs d\'opération ...','status'=>'fail','page'=>'add_lieu_reception'));
        }   
    }

    if (isset($_POST['depense_course_btn'])) {
        $table = 'depensetransport';
        $field = '(date,conducteurID,typeDepenseID,courseTransportID,montant,addedbyID)';
        $prepared = '?,?,?,?,?,?';
        $value = array(
            securise($_POST['course_date']),
            securise($_POST['depense_course_conducteur_id']),
            securise($_POST['description_depense_course_id']),
            securise($_POST['course_transport_id']),
            securise($_POST['montant_depense_course']),
            $_SESSION['idutilisateur']
        );
        if (add($table,$field,$prepared,$value) == true) {
            echo json_encode(array('msg'=>'La depense a été ajouté','status'=>'success','page'=>'depense_course_btn'));
        }else{
            echo json_encode(array('msg'=>'Echecs d\'opération ...','status'=>'fail','page'=>'depense_course_btn'));
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
            echo json_encode(array('msg'=>'L\'opération a été effectue','status'=>'success','page'=>'bordereau_expedition_btn'));
        }else{
            echo json_encode(array('msg'=>'Echecs d\'opération ...','status'=>'fail','page'=>'bordereau_expedition_btn'));
        }   
    }

    if (isset($_POST['type_depense_btn'])) {
        $table = 'typedepense';
        $field = '(date,description,montant,destination,addedbyID)';
        $prepared = '?,?,?,?,?';
        $value = array(
            securise(date('Y-m-d')),
            securise($_POST['description_type_depense']),
            securise($_POST['montant_type_depense']),
            securise($_POST['dest_type_depense']),
            $_SESSION['idutilisateur']
        );
        if (add($table,$field,$prepared,$value) == true) {
            echo json_encode(array('msg'=>'L\'opération a été éfféctue','status'=>'success','page'=>'type_depense_btn'));
        }else{
            echo json_encode(array('msg'=>'Echecs d\'opération ...','status'=>'fail','page'=>'type_depense_btn'));
        }   
    }

    if (isset($_POST['add_course_btn'])) {
        $table = 'coursetransport';
        $field = '(date,conducteur,destination,contenu,tonne,prixCourse,description,addedbyID)';
        $prepared = '?,?,?,?,?,?,?,?';
        $value = array(
            securise($_POST['course_date']),
            securise($_POST['course_conducteur']),
            securise($_POST['course_destination']),
            securise($_POST['course_contenu']),
            securise($_POST['course_contenu_tone']),
            securise($_POST['course_prix']),
            securise($_POST['description_course']),
            $_SESSION['idutilisateur']
        );
        if (add($table,$field,$prepared,$value) == true) {
            echo json_encode(array('msg'=>'L\'opération a été éfféctue','status'=>'success','page'=>'add_course_btn'));
        }else{
            echo json_encode(array('msg'=>'Echecs d\'opération ...','status'=>'fail','page'=>'add_course_btn'));
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
            echo json_encode(array('msg'=>'Le vehicule a été ajouté','status'=>'success','page'=>'add_vehicule_btn'));
        }else{
            echo json_encode(array('msg'=>'Echecs d\'opération ...','status'=>'fail','page'=>'add_vehicule_btn'));
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
            echo json_encode(array('msg'=>'Le conducteur a été ajouté','status'=>'success','page'=>'add_new_driver'));
        }else{
            echo json_encode(array('msg'=>'Echecs d\'opération ...','status'=>'fail','page'=>'add_new_driver'));
        }   
    }

    if (isset($_POST['operation_new_dette_page'])) {
        $table = 'dette';
        $field = '(date,agentID,raison,montant,operation,addedbyID)';
        $prepared = '?,?,?,?,?,?';
        if(securise($_POST['currency']) == 'FC'){
            $amount = securise($_POST['amount']) / securise($_POST['taux']);
         }else{
             $amount = securise($_POST['amount']); 
         }
        $value = array(
            securise($_POST['date']),
            securise($_POST['agent']),
            securise($_POST['raison']),
            $amount,
            securise($_POST['operation']),
            $_SESSION['idutilisateur']
        );
        if (add($table,$field,$prepared,$value) == true) {
            echo json_encode(array('msg'=>'L\'opération a été ajouté','status'=>'success','page'=>'operation_new_dette_page'));
        }else{
            echo json_encode(array('msg'=>'Echecs d\'opération ...','status'=>'fail','page'=>'operation_new_dette_page'));
        }   
    }

    if (isset($_POST['operation_new_facture'])) {
        $table = 'facture';
        $field = '(date,montant,description,agentID,status,addedbyID)';
        $prepared = '?,?,?,?,?,?';
        if(securise($_POST['currency']) == 'FC'){
            $amount = securise($_POST['amount']) / securise($_POST['taux']);
         }else{
            $amount = securise($_POST['amount']); 
         }
        $value = array(
            securise($_POST['date']),
            $amount,
            securise($_POST['description']),
            securise($_POST['agent']),
            0,
            $_SESSION['idutilisateur']
        );
        if (add($table,$field,$prepared,$value) == true) {
            echo json_encode(array('msg'=>'L\'opération a été ajouté','status'=>'success','page'=>'operation_new_facture'));
        }else{
            echo json_encode(array('msg'=>'Echecs d\'opération ...','status'=>'fail','page'=>'operation_new_facture'));
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
            echo json_encode(array('msg'=>'L\'opération a été effectuer avec success.','status'=>'success','page'=>'operation_caisse_new'));
        }else{
            echo json_encode(array('msg'=>'Echecs d\'opération ...','status'=>'fail','page'=>'operation_caisse_new'));
        }     
    }
    