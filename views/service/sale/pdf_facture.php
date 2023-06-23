<?php

session_start();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php

require '../../../web/fpdf181/fpdf.php';
include("../../../models/pdf-generator/pdfclass_mini.php");
include("../../../models/connexion.php");
include '../../../models/demande/demande.php';
include '../../../models/distribution/distribution.php';
include '../../../models/livraison/livraison.php';
include '../../../models/affectation-service/affectationService.php';
include '../../../models/service/service.php';
include '../../../models/unite/unite.php';
include '../../../models/taux/taux.php';
include '../../../models/sale/Sale.php';
include '../../../models/lineSale/LineSale.php';
include '../../../models/production/production.php';

?>

<?php

// Instanciation de la classe dérivée
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('P', 'A5');
$pdf->SetTitle("facture_" . "");
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 16);
$titre_document = "FACTURE N° : " . $_GET['use_sale'];
$pdf->Cell(120, 10, utf8_decode($titre_document), 0, 0, 'C');
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 14);

$dateSale="";
$bdSale=new BdSale();
$sales=$bdSale->getSaleById($_GET['use_sale']);
$dateSale=explode(' ',$sales[0]['dateEnreg'])[0];
$dateSale=explode('-',$dateSale);
$dateSale=$dateSale[2]."/".$dateSale[1]."/".$dateSale[0];

$pdf->Cell(120, 10, utf8_decode("Date : " . $dateSale), 0, 0);
$pdf->Ln(5);

$customerIdentite=$sales[0]['identite'];

$pdf->Cell(120, 10, utf8_decode("Mr/Mme : " . $customerIdentite), 0, 0);
$pdf->Ln(10);
$pdf->SetFont('Times', 'B', 11);
$pdf->SetWidths(array(8, 62, 20, 18, 14,14));
$theads = ['Article', 'PU', 'Quantité', 'Total', 'Gros'];
//foreach ($theads as $thead) {
//$pdf->Row(array(decode('N°'), decode('Article'), decode('Quantité'), decode('PU(FF)'), decode('Total(FF)'), decode('Gros')));
$pdf->Row(array(decode('N°'), decode('Article'), decode('Quantité'), decode('PU(USD)'), decode('Value (USD)'), decode('TVA (USD)')));
//    $pdf->Cell(18, 7, decode($thead), 1);
//}

$cumul_HT = 0;
$cumul_TTC = 0;

$bdLineSale = new BdLineSale();
if (isset($_GET['use_sale'])) {
    $lineSales = $bdLineSale->getlineSaleBySale($_GET['use_sale']);
} else {
    $lineSales = [];
}

$n=0;
foreach ($lineSales as $lineSale) {
    $n++;

    $v1=$n;
    
    $bdSale = new BdSale();
    $dateSale = '';
    $info_customer_2 = '';
    $sales = $bdSale->getSaleById($lineSale['saleId']);
    foreach ($sales as $sale) {
        $dateSale = $sale['dateEnreg'];
        $info_customer_2 = $sale['identite'].' / Phone : '.$sale['telephone'].' / Email : '.$sale['email'].' / Website URL : '.$sale['siteweb'];
    } 
    $bdProduction = new BdProduction();
    $productions = $bdProduction->getProductionById($lineSale['productionId']);
    foreach ($productions as $production) {
        
         $v2=''.$production['designation']; 
                                                          
    } 
                                                                                                                          
    $v3= $lineSale['quantite'];
    $v4= $lineSale['prix'];
    $v5= ($lineSale['quantite'] * $lineSale['prix']);
    // $lineSale['tauxTVA']; 
    $v6= (($lineSale['tauxTVA'] / 100)) * ($lineSale['quantite'] * $lineSale['prix']);
    
    $pdf->Row(array(decode($v1), decode($v2), decode($v3), decode($v4), decode($v5), decode($v6)));
    
    $cumul_HT = $cumul_HT + (($lineSale['quantite'] * $lineSale['prix']));
    $cumul_TTC = $cumul_TTC + ((1 + ($lineSale['tauxTVA'] / 100)) * ($lineSale['quantite'] * $lineSale['prix']));
}
                    




$pdf->SetDrawColor(34, 139, 34);
//Troisieme ligne
//$pdf->Line(10, 70, 148 - 10, 70);

$BdTaux=new BdTaux();
$tauxs=$BdTaux->getTauxActive();
foreach($tauxs as $taux) {
    $value_taux=$taux['value'];
}

$pdf->SetFont('Times', 'B', 16);
$pdf->Cell(190, 10, utf8_decode("Total (FC): " . ($cumul_TTC*$value_taux)));
$pdf->SetFont('Times', 'B', 16);
$pdf->Ln(5);
$pdf->Cell(190, 10, utf8_decode("Total (USD): " . ($cumul_TTC)));
$pdf->SetFont('Times', 'B', 12);
$pdf->Ln(8);
$pdf->Cell(190, 10, utf8_decode("Saller : " . ($_SESSION['identite'])));
$pdf->Ln(15);
$pdf->Cell(190, 10, utf8_decode("NB : Les marchandises vendues ne sont ni échangées ni reprises."));
$pdf->SetDrawColor(34, 139, 34);
//Troisieme ligne
//$pdf->Line(10, 110, 148 - 10, 110);
$pdf->Ln(10);
$pdf->Cell(190, 10, utf8_decode('-----------------------------------------------------------------------------------------------------------'));


$pdf->Output("");
?>