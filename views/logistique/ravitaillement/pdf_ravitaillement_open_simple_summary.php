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

if ((isset($_GET['use_numeroOrder'])) && ($_GET['use_numeroOrder'] != "none")) {
    $pdf->Cell(190, 10, utf8_decode("Order number : " . $_GET['use_numeroOrder']), 0, 0, 'C');
    $pdf->Ln(10);
}

if ((isset($_GET['use_numeroOrder'])) && ($_GET['use_numeroOrder'] != "none")) {
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


$pdf->Cell(190, 10, utf8_decode("Purchase summary report"), 0, 0, 'C');
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
$pdf->SetWidths(array(8, 70, 50, 30, 25));
//foreach ($theads as $thead) {
$pdf->Row(array(decode('N°'), decode('Supplier'), decode('Date'), decode('Value (USD)'), decode('TVA (USD)')));
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

if ((isset($_GET['use_numeroOrder'])) && ($_GET['use_numeroOrder'] != "none")) {
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
    $pdf->Row(array(decode(""), decode($fournisseur['designation']), decode(""), decode(""), decode("")));
    $pdf->SetTextColor(0, 0, 0);

    $date_array = [];
    foreach ($ravitaillements as $ravitaillement) {
        if (!in_array($ravitaillement['date'], $date_array)) {
            array_push($date_array, $ravitaillement['date']);
        }
    }

    foreach ($date_array as $date_item) {
        $cumul_value_date = 0;
        $cumul_TVA_date = 0;
        $n++;
        foreach ($ravitaillements as $ravitaillement) {

            if (($ravitaillement['date'] == $date_item)) {
                if ($ravitaillement['fournisseur_id'] == $fournisseur['id']) {

                    $cumul_value_date = $cumul_value_date + ($ravitaillement['quantite'] * $ravitaillement['prix']);

                    $cumul_TVA_date = $cumul_TVA_date + (($ravitaillement['pourcentageTVA'] / 100) * ($ravitaillement['quantite'] * $ravitaillement['prix']));
                }
            }
        }
        $cumul_total_fournisseur = $cumul_total_fournisseur + ($cumul_value_date);
        $cumul_TVA_fournisseur = $cumul_TVA_fournisseur + ($cumul_TVA_date);
        if ($cumul_value_date != 0) {
            $pdf->Row(array(decode($n), decode(""), decode($date_item), decode($cumul_value_date), decode($cumul_TVA_date)));
        }
    }

    $cumul_total_all = $cumul_total_all + $cumul_total_fournisseur;
    $cumul_TVA_all = $cumul_TVA_all + $cumul_TVA_fournisseur;
    $pdf->SetTextColor(255, 0, 0);
    $pdf->Row(array(decode(""), decode("Total : " . $cumul_total_fournisseur . " USD"), decode("Value TVA : " . $cumul_TVA_fournisseur . " USD"), decode(""), decode("")));
    $pdf->SetTextColor(0, 0, 0);
    $n = 0;
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