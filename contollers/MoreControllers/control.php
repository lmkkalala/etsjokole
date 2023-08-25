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

    $listDetteData = '';
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
    </tr>';
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
    
    $listDepenseData = '';
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
    </tr>';

}else{
    $listDepenseData = '';
}

if(htmlspecialchars($_GET['page']) == 'home_caisse'){

    if ($conditionCaisse != '') {
        $listCaisse = $DB->getWhereMultiple('caisse','operation = "Debiter" and '.$conditionCaisse);
    }else{
        $listCaisse = $DB->getWhere('caisse','operation','Debiter','id');
    }
    
    $listCaisseData = '';
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
                <button class="btn btn-danger mt-1 text-white w-100" onclick="deleteThis('.$listCaisse[$key]['id'].','.$table.')" type="button">Supprimer</button>
            </td>
        </tr>
    </form>';
    }
    $listCaisseData = $listCaisseData.
    '<tr class="bg-primary text-white">
        <td class="fw-bolder text-white small">TOTAL DEBIT Dollors</td>
        <td></td>
        <td class="fw-bolder text-white">'.$format->formatCurrency($totalDebitDollars,'usd').'</td>
        <td class="fw-bolder text-white small">TOTAL DEBIT FC</td>
        <td></td>
        <td class="fw-bolder text-white">'.$format->formatCurrency($totalDebitFc,'fcf').'</td>
        <td class="fw-bolder text-white small">TOTAL DEBIT FRW</td>
        <td></td>
        <td></td>
        <td class="fw-bolder text-white text-start">'.$format->formatCurrency($totalDebitFrw,'frw').'</td>
    </tr>
    ';

    if ($conditionCaisseCredit != '') {
        $listCaisseSortie = $DB->getWhereMultiple('caisse','operation = "Crediter" and '.$conditionCaisseCredit);
    }else{
        $listCaisseSortie = $DB->getWhere('caisse','operation','Crediter','id');
    }
    
    $listCaisseDataSortie = '';
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
                <button class="btn btn-danger mt-1 text-white w-100" onclick="deleteThis('.$listCaisseSortie[$key]['id'].','.$table.')" type="button">Supprimer</button>
            </td>
        </tr>
    </form>';
    }

    $listCaisseDataSortie = $listCaisseDataSortie.
    '<tr class="bg-primary text-white">
        <td class="fw-bolder text-white">TOTAL CREDIT Dollors</td>
        <td></td>
        <td class="fw-bolder text-white">'.$format->formatCurrency($totalCreditDollars,'usd').'</td>
        <td class="fw-bolder text-white">TOTAL CREDIT FC</td>
        <td></td>
        <td class="fw-bolder text-white">'.$format->formatCurrency($totalCreditFc,'fcf').'</td>
        <td class="fw-bolder text-white">TOTAL CREDIT FRW</td>
        <td></td>
        <td></td>
        <td class="fw-bolder text-white">'.$format->formatCurrency($totalCreditFrw,'frw').'</td>
    </tr>
    ';

    $dollars = $totalDebitDollars - $totalCreditDollars;
    $fc = $totalDebitFc - $totalCreditFc;
    $frw = $totalDebitFrw - $totalCreditFrw;
}else{
    $dollars = '0.0';
    $fc = '0.0';
    $frw = '0.0';
    $listCaisseData = '';
    $listCaisseDataSortie = '';
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
                <button type="submit" class="btn btn-'.$btnStyle.'" onclick="updateThis('.$listVehicule[$key]['id'].','.$table.')"><i class="fa fa-eye"></i></button>
            </td>
        </tr>
        </form>';
    }
    //$btnStyle = array();
    $table = "String('typedepense')";
    $typeDepense = $DB->get('typedepense','id');
    $typeDepenseData = '';
    foreach ($typeDepense as $key => $value) {

    $btnStyle = ($typeDepense[$key]['status'] == '0') ? 'danger' : 'secondary';
    
    $typeDepenseData = $typeDepenseData.
    '<form action="" method="post" id="">
        <tr>
            <td width="20">
                <input class="form-control" type="date" name="type_depense_date_update" id="type_depense_date_update" value="'.$typeDepense[$key]['date'].'">
            </td>
            <td>
                <input class="form-control" type="text" name="type_depense_description_update" id="type_depense_description_update" value="'.$typeDepense[$key]['description'].'">
            </td>
            <td>
                <input class="form-control" type="text" name="type_depense_montant_update" id="type_depense_montant_update" value="'.$typeDepense[$key]['montant'].'">
            </td>
            <td>
                <input class="form-control" type="text" name="type_depense_destination_update" id="type_depense_destination_update" value="'.$typeDepense[$key]['destination'].'">
            </td>
            <td>
                <button type="submit" class="btn btn-primary"><i class="fa fa-pencil"></i></button>
                <button type="submit" class="btn btn-'.$btnStyle.'" onclick="updateThis('.$typeDepense[$key]['id'].','.$table.')"><i class="fa fa-eye"></i></button>
            </td>
        </tr>
    </form>';
    $btnStyle = '';
    }
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
    $factureData = '';
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
}else{
    $factureData = ''; 
}

if(htmlspecialchars($_GET['page']) == 'home_logistique_transport'){

    if ($conditionDepenseCourse != '') {
        $depensetransport = $DB->getWhereMultiple('depensetransport',$conditionDepenseCourse);
    }else{
        $depensetransport = $DB->getWhereMultiple('depensetransport','id');
    }
    $table = "String('depensetransport')";
    $typeAgent = $DB->getWhere('agent','active','1');
    $typedepense = $DB->get('typedepense','id'); 
    $lisDepenseCourse = '';
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
                    <button type="submit" class="btn btn-primary"><i class="fa fa-pencil"></i></button>
                    <button type="submit" class="btn btn-danger"  onclick="deleteThis('.$depensetransport[$key]['id'].','.$table.')"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        </form>';
    }
    $lisDepenseCourse = $lisDepenseCourse.
    '<tr class="bg-primary text-white"">
    <td><input class="form-control" type="text" name="" id="" value="DEPENSE TOTAL" desabled></td>
    <td>
    </td>
    <td>
    </td>
    <td>
    <input class="form-control" type="text" name="" id="" value="'.$DepenseTotalCourse.' $" readonly>  
    </td>
    <td></td>
    </tr>';




    if ($conditionCourse != '') {
        $typeCourse = $DB->getWhereMultiple('coursetransport',$conditionCourse);
    }else{
        $typeCourse = $DB->getWhereMultiple('coursetransport','date Like"%'.date('Y-m',time()).'%" ORDER BY date DESC');
    }
    $listDepenseTransport = $DB->get('depensetransport','id'); 
    $typeCourseData = '';
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
        $typeCourseData = $typeCourseData.'<form action="" method="post" id="">
            <tr>
                <td>'.$rows.'</td>
                <td><input class="form-control" type="date" name="" id=""  value="'.$typeCourse[$key]['date'].'"></td>
                <td><input class="form-control" type="text" name="" id=""  value="'.$conducteurNames.'"></td>
                <td><input class="form-control" type="text" name="" id=""  value="'.$plaque.'"></td>
                <td>
                    <input class="form-control" type="text" name="" id=""  value="'.$typeCourse[$key]['contenu'].'">
                    <input class="form-control mt-1" type="text" name="" id=""  value="'.$typeCourse[$key]['destination'].'">
                </td>
                <td>
                    <textarea class="form-control" name="" id=""  value="'.$typeCourse[$key]['description'].'">'.$typeCourse[$key]['description'].'</textarea>
                </td>
                <td>
                    <input class="form-control" type="text" name="" id=""  value="'.$typeCourse[$key]['tonne'].'">
                    <input class="form-control mt-1" type="text" name="" id=""  value="'.$typeCourse[$key]['prixCourse'].'">
                </td>
                <td><input class="form-control" type="text" name="" id=""  value="'.$depenseTotalCourse.'" readonly></td>
                <td><input class="form-control" type="text" name="" id=""  value="'.$typeCourse[$key]['prixCourse'] - $calcul.'"></td>
                <td>
                    <button class="btn btn-primary mt-1 text-white w-100" type="button" data-bs-toggle="modal" data-bs-target="#add_depense" data-id="'.$typeCourse[$key]['id'].'">
                        <i class="fa fa-money"></i>
                    </button>
                    <button class="btn btn-primary mt-1 text-white w-100" type="submit"><i class="fa fa-pencil"></i> </button>
                    <button class="btn btn-danger mt-1 text-white w-100" type="button" onclick="deleteThis('.$typeCourse[$key]['id'].','.$table.')"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        </form>';
        $calcul = 0;
        $depenseTotalCourse = '0';
        }
    }

    $typeCourseData = $typeCourseData.
    '<tr class="bg-primary text-white">
        <td></td>
        <td>TONNAGE : </td>
        <td>'.$tonnageTotal.'</td>
        <td>PRIX : </td>
        <td>'.$prixTotal.' USD</td>
        <td>DEPENSE : </td>
        <td>'.$depenseTotal.' USD</td>
        <td>MARGE : </td>
        <td>'.$margeTotal.'</td>
        <td>USD</td>
        
    </tr>';
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
                'frw'=>$format->formatCurrency($frw,'frw')
            )
        )
    );
}

/* --------------------------------------------------- CHECKING CONDITION FROM FORM TO INSERT, DELETE AND UPDATE DATA IN THE DATABASE -----------------------------------------------------*/

$DB = new DB();
    if (isset($_GET['request']) and $_GET['request'] == sha1('update')) {
        // if (htmlspecialchars($_POST['to']) =='facture') {
        //     $factureData = $DB->getwhere('facture','id',htmlspecialchars($_POST['id']));
        //     if (count($factureData) > 0) {
        //         $status = $factureData[0]['status'];
        //         if ($status == 0) {
        //             $val = '1';
        //         }else{
        //             $val = '0';
        //         }
        //     }else{
        //         $val = '1';
        //     }

        //     $update = update(htmlspecialchars($_POST['to']) ,'status = ?', 'id = ?', [''.$val.'',''.htmlspecialchars($_POST['id']).'']);
        // }else if(htmlspecialchars($_POST['to']) =='typedepense'){
        //     $typedepense = $DB->getwhere('typedepense','id',htmlspecialchars($_POST['id']));
        //     if (count($typedepense) > 0) {
        //         $status = $typedepense[0]['status'];
        //         if ($status == 0) {
        //             $val = '1';
        //         }else{
        //             $val = '0';
        //         }
        //     }else{
        //         $val = '1';
        //     }
        //     $update = update(htmlspecialchars($_POST['to']) ,'status = ?', 'id = ?', [''.$val.'',''.htmlspecialchars($_POST['id']).'']);
        // }else{
        //     $update == false;
        // }

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
    