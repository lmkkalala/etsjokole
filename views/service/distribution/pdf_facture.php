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

?>

<?php

// Instanciation de la classe dérivée
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('P', 'A5');
$pdf->SetTitle("facture_" . "");
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 16);
$titre_document = "FACTURE N° : " . $_GET['use_ventePOS'];
$pdf->Cell(120, 10, utf8_decode($titre_document), 0, 0, 'C');
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(120, 10, utf8_decode("Date : " . date('d/m/Y')), 0, 0);
$pdf->Ln(5);
$pdf->Cell(120, 10, utf8_decode("Mr/Mme : " . $_GET['use_identiteClient']), 0, 0);
$pdf->Ln(10);
$pdf->SetFont('Times', 'B', 11);
$pdf->SetWidths(array(8, 62, 20, 18, 14,14));
$theads = ['Article', 'PU', 'Quantité', 'Total', 'Gros'];
//foreach ($theads as $thead) {
//$pdf->Row(array(decode('N°'), decode('Article'), decode('Quantité'), decode('PU(FF)'), decode('Total(FF)'), decode('Gros')));
$pdf->Row(array(decode('N°'), decode('Article'), decode('Quantité'), decode('PU(USD)'), decode('Value (USD)'), decode('TVA (USD)')));
//    $pdf->Cell(18, 7, decode($thead), 1);
//}


$bddistribution = new BdDistribution();

$distributions = $bddistribution->getDistributionByVentePOSId($_GET['use_ventePOS']);


$cumul_value_total = 0;
$n=0;
$cumul_value_typerepas=0;

foreach ($distributions as $distribution) {

                if (1) {

                    $affiche_bon = false;
                    //                            $bdmutation=new BdAffectationService();
                    //                            $affectations=$bdaffectation->getAffectationServiceByService($idservice);
                    $bdlivraison = new BdLivraison();
                    $livraisons = $bdlivraison->getLivraisonById($distribution['distribution_id']);
                    foreach ($livraisons as $livraison) {
                        $bddemande = new BdDemande();
                        $demandes = $bddemande->getDemandeById($livraison['demande_id']);
                        foreach ($demandes as $demande) {
                            $bdaffectation = new BdAffectationService();
                            $affectations = $bdaffectation->getAffectationServiceById($demande['mutation_id']);
                            foreach ($affectations as $affectation) {
                                if ($affectation['service_id'] == $_SESSION['idservice']) {
                                    $affiche_bon = true;
                                }
                            }
                        }
                        $idaffectation_online = $livraison['dIdmutation'];
                        $infolivraison = $livraison['bDesignation'];
                    }
                    if (isset($infolivraison) && ($affiche_bon) && ($distribution['nombre_restant'] > 0)) {
                        $v1 =  ++$n;
                        // $v2 = $distribution['date'];
                        $v3 = $infolivraison;
                        $v4 = $distribution['nombre_restant'];
                        $v5 = $distribution['price'];
                        $v6 = ($distribution['nombre_restant'] * $distribution['price']);
                        $v8=(($distribution['nombre_restant'] * $distribution['price'])*(($distribution['tva']/100)));
                        $cumul_value_typerepas = $cumul_value_typerepas +(($distribution['nombre_restant'] * $distribution['price']) +$v8);
                        
                        $pdf->Row(array(decode($v1), decode($v3), decode($v4), decode($v5), decode($v6), decode($v8)));
                    }
                
            }
            $cumul_value_total = $cumul_value_typerepas;
            $v7 = "Sum : " . $cumul_value_typerepas . " USD";
     
}



$pdf->SetDrawColor(34, 139, 34);
//Troisieme ligne
//$pdf->Line(10, 70, 148 - 10, 70);
$value_taux = 0;
$BdTaux=new BdTaux();
$tauxs=$BdTaux->getTauxActive();
foreach($tauxs as $taux) {
    $value_taux=$taux['value'];
}

$pdf->SetFont('Times', 'B', 16);
if($value_taux != 0){
$pdf->Cell(190, 10, utf8_decode("Total (FC): " . ($cumul_value_total*$value_taux)));
}
$pdf->SetFont('Times', 'B', 16);
$pdf->Ln(5);
$pdf->Cell(190, 10, utf8_decode("Total (USD): " . ($cumul_value_total)));
$pdf->SetFont('Times', 'B', 12);
$pdf->Ln(8);
$pdf->Cell(190, 10, utf8_decode("Saller : " . ($_SESSION['identite'])));
$pdf->Ln(15);
$pdf->Cell(190, 10, utf8_decode("NB : Les marchandises vendues ne sont ni échangées ni reprises. "));
$pdf->SetDrawColor(34, 139, 34);
//Troisieme ligne
//$pdf->Line(10, 110, 148 - 10, 110);
$pdf->Ln(10);
$pdf->Cell(190, 10, utf8_decode('-----------------------------------------------------------------------------------------------------------'));


$pdf->Output("");
?>