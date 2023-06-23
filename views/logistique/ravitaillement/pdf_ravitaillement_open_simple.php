<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php

require '../../../web/fpdf181/fpdf.php';

include("../../../models/pdf-generator/pdfclass.php");

include '../../../models/connexion.php';

include '../../../models/ravitaillement/ravitaillement.php';
include '../../../models/attribution-biens/attributionBiens.php';
include '../../../models/unite/unite.php';
include '../../../models/biens/biens.php';
include '../../../models/fournisseur/fournisseur.php';
?>

<?php

// Instanciation de la classe dérivée
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('P');


$titre = "";

if ((isset($_GET['use_date1'])) && (isset($_GET['use_date2']))) {
    $titre = $titre . "Starting date : " . $_GET['use_date1'] . " " . " / Ending date : " . $_GET['use_date2'];
} else {
    $titre = $titre . " Choose interval";
}


if (isset($_GET['use_biens'])) {
    $bdbiens = new BdBiens();
    $biens = $bdbiens->getBiensById($_GET['use_biens']);
    foreach ($biens as $bien) {
        $designation_biens_choosen = $bien['bDesignation'] . " / " . $bien['gDesignation'];
    }
    if (isset($designation_biens_choosen)) {
        $titre = $titre . " Item :" . $designation_biens_choosen;
    } else {
        $titre = $titre . " | Item : - ";
    }
}

$designation_fournisseur = "";
$bdfournisseur = new BdFournisseur();
$fournisseurs = $bdfournisseur->getFournisseurById($_GET['use_fournisseur']);
foreach ($fournisseurs as $fournisseur) {
    $designation_fournisseur = $fournisseur['designation'];
}

if ($designation_fournisseur == "") {
    $designation_fournisseur = "All";
}

$titre_document = $titre;
$pdf->SetTitle("Receipt_Report : " . $titre_document);
$titre_document = $titre;
$pdf->SetFont('Arial', 'B', 12);

if ((isset($_GET['use_numeroOrder'])) && ($_GET['use_numeroOrder']!="none")) {
    $pdf->Cell(190, 10, utf8_decode("Order number : " . $_GET['use_numeroOrder']), 0, 0, 'C');
    $pdf->Ln(10);
}

if ((isset($_GET['use_numeroOrder'])) && ($_GET['use_numeroOrder']!="none")) {
    $bdattributionbiens = new BdAttributionBiens();
    $attributions = $bdattributionbiens->getAttributionBiensByNumeroOrder($_GET['use_numeroOrder']);
    foreach ($attributions as $attribution) {
        $id_fournisseur = $attribution['fId'];
    }
    $bdfournisseur = new BdFournisseur();
    $fournisseurs = $bdfournisseur->getFournisseurById($id_fournisseur);
    foreach ($fournisseurs as $fournisseur) {
        $designation_fournisseur = $fournisseur['designation'];
    }
}


$pdf->Cell(190, 10, utf8_decode("Receipt report"), 0, 0, 'C');
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(190, 10, utf8_decode($titre_document), 0, 0, 'C');
$pdf->Ln(10);

$pdf->SetFont('Times', 'B', 11);
$pdf->SetWidths(array(40, 145));
$pdf->Row(array(decode('Supplier : '), decode($designation_fournisseur)));
$pdf->SetWidths(array(40, 145));
$pdf->Row(array(decode('Interval : '), decode($_GET['use_date1'] . " to " . $_GET['use_date2'])));
$pdf->Ln(5);

$n = 0;
$pdf->SetFont('Times', 'B', 11);
$pdf->SetWidths(array(8, 30, 60, 15, 15, 15, 15, 15, 15));
//foreach ($theads as $thead) {
$pdf->Row(array(decode('N°'), decode('Date'), decode('Order'), decode('Qty'), decode('Unit price'), decode('Value'), decode('Exp. Date'), decode('% TVA'), decode('Value TVA')));
$pdf->SetFont('Times', '', 11);

$n = 0;
$cumul_total_sortie = 0;
$cumul_total_reste = 0;
$cumul_total = 0;
$bdravitaillement = new BdRavitaillement();
if ((isset($_GET['use_biens'])) && ($_GET['use_biens'] != 0)) {
    if ((isset($_GET['use_date1'])) && ($_GET['use_date1'] != "")) {
        $ravitaillements = $bdravitaillement->getRavitaillementBetween2DatesByIdBiens($_GET['use_date1'], $_GET['use_date2'], $_GET['use_biens']);
    } else {
        $ravitaillements = $bdravitaillement->getRavitaillementByIdBiens($_GET['use_biens']);
    }
} else {
    if ((isset($_GET['use_date1'])) && ($_GET['use_date1'] != "")) {
        $ravitaillements = $bdravitaillement->getRavitaillementBetween2Dates($_GET['use_date1'], $_GET['use_date2']);
    } else {
        $ravitaillements = $bdravitaillement->getRavitaillementAllDesc();
    }
}

if ((isset($_GET['use_numeroOrder'])) && ($_GET['use_numeroOrder'] != "none")) {
    $ravitaillements = $bdravitaillement->getRavitaillementByNumeroOrder($_GET['use_numeroOrder']);
}

$bdfournisseur = new BdFournisseur();
if ((isset($_GET['use_fournisseur'])) && ($_GET['use_fournisseur'] != 0)) {
    $fournisseurs = $bdfournisseur->getFournisseurById($_GET['use_fournisseur']);
} else {
    $fournisseurs = $bdfournisseur->getFournisseurAllDesc();
}

if ((isset($_GET['use_numeroOrder'])) && ($_GET['use_numeroOrder']!="none")) {
    $bdattributionbiens = new BdAttributionBiens();
    $attributions = $bdattributionbiens->getAttributionBiensByNumeroOrder($_GET['use_numeroOrder']);
    foreach ($attributions as $attribution) {
        $id_fournisseur = $attribution['fId'];
    }
    $bdfournisseur = new BdFournisseur();
    $fournisseurs = $bdfournisseur->getFournisseurById($id_fournisseur);
    
}

$cumul_total_all = 0;
$cumul_TVA_all = 0;
foreach ($fournisseurs as $fournisseur) {
    $cumul_total_fournisseur = 0;
    $cumul_TVA_fournisseur = 0;
    $pdf->SetTextColor(0, 0, 255);
    $pdf->Row(array(decode(""), decode($fournisseur['designation']), decode(""), decode(""), decode(""), decode(""), decode(""), decode(""), decode("")));
    $pdf->SetTextColor(0, 0, 0);
    foreach ($ravitaillements as $ravitaillement) {
        if ($ravitaillement['fournisseur_id'] == $fournisseur['id']) {
            $n++;
            $chaine_part_ravitaillement_sortie = "";
            $chaine_part_ravitaillement_reste = "";
            $v1 = $ravitaillement['id'];
            $v2 = $ravitaillement['date'];

            $bdattributionbiens = new BdAttributionBiens();
            $attributions = $bdattributionbiens->getAttributionBiensById($ravitaillement['attribution_id']);
            foreach ($attributions as $attribution) {
                $v3 = "O.id:" . $attribution['aId'] . " / " . $attribution['date'] . " / " . $attribution['bDesignation'] . " / Order qty : " . $attribution['quantite_minimale'];
            }

            $v4 = $ravitaillement['quantite'];

            $bdunite = new BdUnite();
            $unites = $bdunite->getUniteByName("-" . $ravitaillement['id'] . "-");
            foreach ($unites as $unite) {
                if (($unite['active'] == 0) && ($unite['active_principal'] == 1)) {
                    $part_code = explode('-', $unite['code']);
                    if ((strlen($part_code[1])) == 1) {
                        $chaine_part_ravitaillement_sortie = $chaine_part_ravitaillement_sortie . $part_code[1] . "-";
                    }
                }
            }
            foreach ($unites as $unite) {
                if (($unite['active'] == 1) && ($unite['active_principal'] == 1)) {
                    $part_code = explode('-', $unite['code']);
                    if ((strlen($part_code[1])) == 1) {
                        $chaine_part_ravitaillement_reste = $chaine_part_ravitaillement_reste . $part_code[1] . "-";
                    }
                }
            }

            $items_ravitaillement = explode('-', $chaine_part_ravitaillement_sortie);
            $n_same_ravitaillement = 0;
            $cumule_prix = 0;
            foreach ($items_ravitaillement as $item) {
                if ((strlen($item)) == 1) {
                    $bdravitaillement_second = new BdRavitaillement();
                    $ravitaillements_second = $bdravitaillement_second->getRavitaillementById($item);
                    $last = 0;
                    $i = 0;
                    $j = 0;
                    $prix_item = 0;
                    foreach ($ravitaillements_second as $ravitaillement_second) {
                        $i++;
                    }
                    foreach ($ravitaillements_second as $ravitaillement_second) {
                        $cumule_prix = $cumule_prix + $ravitaillement_second['prix'];
                        $j++;
                    }
                }
            }
            $v5 = $cumule_prix . " USD";
            $cumul_total_sortie = $cumul_total_sortie + $cumule_prix;

            $items_ravitaillement = explode('-', $chaine_part_ravitaillement_reste);
            $n_same_ravitaillement = 0;
            $cumule_prix = 0;
            foreach ($items_ravitaillement as $item) {
                if ((strlen($item)) == 1) {
                    $bdravitaillement_second = new BdRavitaillement();
                    $ravitaillements_second = $bdravitaillement_second->getRavitaillementById($item);
                    $last = 0;
                    $i = 0;
                    $j = 0;
                    $prix_item = 0;
                    foreach ($ravitaillements_second as $ravitaillement_second) {
                        $i++;
                    }
                    foreach ($ravitaillements_second as $ravitaillement_second) {
                        $cumule_prix = $cumule_prix + $ravitaillement_second['prix'];
                        $j++;
                    }
                }
            }
            $v6 = $cumule_prix . " USD";
            $cumul_total_reste = $cumul_total_reste + $cumule_prix;

            $v7 = $ravitaillement['prix'] . " USD";
            $v8 = ($ravitaillement['quantite'] * $ravitaillement['prix']) . " USD";
            $v9 = $ravitaillement['delai_realise'];
            $v10 = $ravitaillement['dateExpiration'];
            $v11 = $ravitaillement['type'];
            $v12 = $ravitaillement['pourcentageTVA'];
            $v13 = (($ravitaillement['pourcentageTVA'] / 100) * ($ravitaillement['quantite'] * $ravitaillement['prix'])) . " USD";

            $cumul_total = $cumul_total + ($ravitaillement['quantite'] * $ravitaillement['prix']);

            $pdf->Row(array(decode($v1), decode($v2), decode($v3), decode($v4), decode($v7), decode($v8), decode($v10), decode($v12), decode($v13)));

            $cumul_total_fournisseur = $cumul_total_fournisseur + ($ravitaillement['quantite'] * $ravitaillement['prix']);
            $cumul_TVA_fournisseur = $cumul_TVA_fournisseur + (($ravitaillement['pourcentageTVA'] / 100) * ($ravitaillement['quantite'] * $ravitaillement['prix']));
        }
    }
    $cumul_total_all = $cumul_total_all + $cumul_total_fournisseur;
    $cumul_TVA_all = $cumul_TVA_all + $cumul_TVA_fournisseur;
    $pdf->SetTextColor(255, 0, 0);
    $pdf->Row(array(decode(""), decode("Total : " . $cumul_total_fournisseur . " USD"), decode("Value TVA : " . $cumul_TVA_fournisseur . " USD"), decode(""), decode(""), decode(""), decode(""), decode(""), decode("")));
    $pdf->SetTextColor(0, 0, 0);
}

$pdf->Ln(8);

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(190, 10, utf8_decode('Grand total Input value : ' . ($cumul_total_all . " USD")), 0, 0, '');
$pdf->Ln(5);
$pdf->Cell(190, 10, utf8_decode('TVA : ' . ($cumul_TVA_all . " USD")), 0, 0, '');
$pdf->Ln(5);
$pdf->Cell(190, 10, utf8_decode('Total + TVA : ' . (($cumul_total_all + $cumul_TVA_all) . " USD")), 0, 0, '');
$pdf->Ln(5);
$pdf->Output($titre_document, 'I');
?>