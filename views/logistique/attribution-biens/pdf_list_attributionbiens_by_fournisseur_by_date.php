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

include("../../../models/connexion.php");
include("../../../models/biens/biens.php");
include("../../../models/fournisseur/fournisseur.php");
include("../../../models/attribution-biens/attributionBiens.php");
?>

<?php

// Instanciation de la classe dérivée
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('P');
$bdfournisseur = new BdFournisseur();
$fournisseurs = $bdfournisseur->getFournisseurById($_GET['use']);
foreach ($fournisseurs as $fournisseur) {
    $designation_fournisseur = $fournisseur['designation'];
}
$pdf->SetTitle("order_supplier_");
$pdf->SetFont('Arial', 'B', 14);
$titre_document = "Order_report_" . $designation_fournisseur . "_" . $_GET['use_date1'] . "_" . $_GET['use_date2'];
$pdf->Cell(190, 10, utf8_decode("Order report"), 0, 0, 'C');
$pdf->Ln(15);

if ((isset($_GET['use_numeroOrder'])) && ($_GET['use_numeroOrder'] != "none")) {
    $pdf->Cell(190, 10, utf8_decode("Order number : ".$_GET['use_numeroOrder']), 0, 0, 'C');
    $pdf->Ln(10);
}
$pdf->SetFont('Times', 'B', 11);
$pdf->SetWidths(array(40, 145));
$pdf->Row(array(decode('Supplier : '), decode($designation_fournisseur)));
$pdf->SetWidths(array(40, 145));
$pdf->Row(array(decode('Interval : '), decode($_GET['use_date1'] . " to " . $_GET['use_date2'])));
$pdf->Ln(5);

$pdf->SetFont('Times', 'B', 11);
$pdf->SetWidths(array(15, 40, 18, 60, 20, 18, 18));
//foreach ($theads as $thead) {
$pdf->Row(array(decode('NO'), decode('Date'), decode('Status'), decode('Item'), decode('Quantity'), decode('Unit price (USD)'), decode('Value (USD)')));
//    $pdf->Cell(18, 7, decode($thead), 1);
//}
$n = 0;
$bdattributionbiens = new BdAttributionBiens();
if (((isset($_GET['use_date1'])) && (isset($_GET['use_date2']))) && ((($_GET['use_date1']) != "") && (($_GET['use_date2']) != ""))) {
    $attributions = $bdattributionbiens->getAttributionBiensByIdFournisseurByDate($_GET['use'], $_GET['use_date1'], $_GET['use_date2']);
} else {
    $attributions = $bdattributionbiens->getAttributionBiensByIdFournisseur($_GET['use']);
}

if ((isset($_GET['use_numeroOrder'])) && ($_GET['use_numeroOrder'] != "none")) {
    $attributions = $bdattributionbiens->getAttributionBiensByNumeroOrder($_GET['use_numeroOrder']);
}

$cumul_value = 0;
foreach ($attributions as $attribution) {
    $n++;
    $v1 = $attribution['aId'];
    $v2 = $attribution['date'];

    if ($attribution['etat']) {
        $v3 = 'Finalisée';
    } else {
        $v3 = 'En cours';
    }
    $v4 = $attribution['bDesignation'] . " / " . $attribution['gDesignation'];
    $v5 = $attribution['quantite_minimale'];
    $v6 = $attribution['aPrixUnitaire'];
    $v7 = ($attribution['quantite_minimale'] * $attribution['aPrixUnitaire']);
    $cumul_value = $cumul_value + ($attribution['quantite_minimale'] * $attribution['aPrixUnitaire']);
    $pdf->Row(array(decode($v1), decode($v2), decode($v3), decode($v4), decode($v5), decode($v6), decode($v7)));
}

$pdf->Row(array(decode("Nber : " . $n), decode("Total value : " . $cumul_value . " USD "), decode(""), decode(""), decode(""), decode(""), decode("")));

$pdf->Output("");
?>
