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
include '../../../models/demande/demande.php';
include '../../../models/distribution/distribution.php';
include '../../../models/livraison/livraison.php';
include '../../../models/affectation-service/affectationService.php';
include '../../../models/service/service.php';
include '../../../models/unite/unite.php';
?>

<?php

// Instanciation de la classe dérivée
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('P');
$pdf->SetTitle("list_sales_service");
$pdf->SetFont('Arial', 'B', 14);
$titre_document = "Sales Report";
$pdf->Cell(190, 10, utf8_decode($titre_document), 0, 0, 'C');
$pdf->Ln(10);

if (isset($_GET['use_service'])) {
    $bdservice = new BdService();
    $services = $bdservice->getServiceById($_GET['use_service']);
    foreach ($services as $service) {
        $designation_service = $service['designation'];
    }
}

$pdf->Cell(190, 10, utf8_decode($designation_service), 0, 0, 'C');
$pdf->Ln(10);

if (((isset($_GET['use_date1'])) && (isset($_GET['use_date2']))) && (($_GET['use_date1'] != "") && ($_GET['use_date2'] != ""))) {
    $info_date = "Starting date : " . dateFrench($_GET['use_date1']) . " / Ending date : " . dateFrench($_GET['use_date2']);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(190, 10, utf8_decode($info_date), 0, 0, 'C');
    $pdf->Ln(10);
}

if (($_GET['use_typerepas'] != "0")) {
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetTextColor(255, 0, 0);
    if ($_GET['use_typerepas']=="Transfer") {
        $desiPrep="Vente sur stock";
    } else {
        $desiPrep=$_GET['use_typerepas'];
    }
    $pdf->Cell(190, 10, utf8_decode("Type : " . $desiPrep), 0, 0, 'C');
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Ln(10);
}

$pdf->SetFont('Times', 'B', 8);
$pdf->SetWidths(array(40, 20,30, 40, 12, 12, 12, 12, 12, 12));
//foreach ($theads as $thead) {
$pdf->Row(array(decode('NO'), decode('Date'), decode('Client'), decode('Item'), decode('Qty'), decode('Price (USD)'), decode('Value HT (USD)'), decode('Value TVA (USD)'), decode('Value TTC (USD)')));
//    $pdf->Cell(18, 7, decode($thead), 1);
//}

$n = 0;
if (isset($_GET['use_service'])) {
    $use = $_GET['use_service'];
} else {
    $use = 0;
}
$bddistribution = new BdDistribution();
if (((isset($_GET['use_date1'])) && (isset($_GET['use_date2']))) && (($_GET['use_date1'] != "") && ($_GET['use_date2'] != ""))) {
    if ($_GET['use_typerepas'] != "0") {
        if ($_GET['use_identiteClient'] != "none") {
            $distributions = $bddistribution->getDistributionBeetwen2DatesByTypeRepasByIdentiteClient($_GET['use_date1'], $_GET['use_date2'], $_GET['use_typerepas'], $_GET['use_identiteClient']);
        } else {
            $distributions = $bddistribution->getDistributionBeetwen2DatesByTypeRepas($_GET['use_date1'], $_GET['use_date2'], $_GET['use_typerepas']);
        }
    } else {
        if ($_GET['use_identiteClient'] != "none") {
            $distributions = $bddistribution->getDistributionBeetwen2DatesByIdentiteClient($_GET['use_date1'], $_GET['use_date2'], $_GET['use_identiteClient']);
        } else {
            $distributions = $bddistribution->getDistributionBeetwen2Dates($_GET['use_date1'], $_GET['use_date2']);
        }
    }
} else {
    $distributions = $bddistribution->getDistributionAllDesc();
}

if (((isset($_GET['use_date1'])) && (isset($_GET['use_date2']))) && (($_GET['use_date1'] == "") && ($_GET['use_date2'] == "") && ($_GET['use_typerepas'] != "0"))) {
    $distributions = $bddistribution->getDistributionByTypeRepas($_GET['use_typerepas']);
}

if ((isset($_GET['use_typerepas'])) && ($_GET['use_typerepas'] != "0")) {
    $list_type_repas = [$_GET['use_typerepas']];
} else {
    $list_type_repas = ['Input','Diesel','Lubricant','Fleet','Plant', 'cleaning', 'non-consomable', 'Office and kitchen equipment', 'Bar', 'Spoilage', 'Transfer', 'Staff meal', 'Back to supplier', 'Back charge to client', 'Fonction','PRO'];
}

$cumul_value_total = 0;
$cumul_tva_total = 0;
$cumul_value_ttc_total = 0;

foreach ($list_type_repas as $typerepas) {

    if (($_GET['use_typerepas'] != "0") || (($_GET['use_date1'] != "") && ($_GET['use_date2'] != ""))) {
        if (($typerepas == $_GET['use_typerepas']) || (($_GET['use_date1'] != "") && ($_GET['use_date2'] != ""))) {

            $pdf->SetTextColor(255, 0, 0);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Row(array(decode($desiPrep), decode(""), decode(""), decode(""), decode(""), decode(""), decode(""), decode(""), decode("")));
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 8);

            $cumul_value_typerepas = 0;
            $cumul_tva=0;
            $cumul_value_ttc=0;
            
            foreach ($distributions as $distribution) {

                if ($distribution['typerepas'] == $typerepas) {

                    $affiche_bon = false;

                    $bdlivraison = new BdLivraison();
                    $livraisons = $bdlivraison->getLivraisonById($distribution['distribution_id']);
                    foreach ($livraisons as $livraison) {
                        $bddemande = new BdDemande();
                        $demandes = $bddemande->getDemandeById($livraison['demande_id']);
                        foreach ($demandes as $demande) {
                            $bdaffectation = new BdAffectationService();
                            $affectations = $bdaffectation->getAffectationServiceById($demande['mutation_id']);
                            foreach ($affectations as $affectation) {
                                if ($affectation['service_id'] == $use) {
                                    $affiche_bon = true;
                                }
                            }
                        }
                        $idaffectation_online = $livraison['dIdmutation'];
                        $infolivraison = $livraison['bDesignation'] . " / " . $livraison['gDesignation'];
                    }
                    if (isset($infolivraison) && ($affiche_bon) && ($distribution['nombre_restant'] > 0)) {
                        $n++;
                        $v1 = $distribution['id'];
                        $v2 = dateFrench($distribution['date']) ;
                        $v3 = $infolivraison;
                        $v4 = $distribution['nombre_restant'];
                        $v5 = $distribution['price'];
                        $v6 = ($distribution['nombre_restant'] * $distribution['price']);
                        $v7 = $distribution['identiteClient'];
                        
                        $v8= (($distribution['nombre_restant'] * $distribution['price'])*($distribution['tva']/100));
                        $cumul_tva=$cumul_tva+ (($distribution['nombre_restant'] * $distribution['price'])*($distribution['tva']/100));
                        $v9= (($distribution['nombre_restant'] * $distribution['price'])*(1+($distribution['tva']/100)));
                        $vttc=(($distribution['nombre_restant'] * $distribution['price'])*(1+($distribution['tva']/100)));
                        $cumul_value_ttc_total = $cumul_value_ttc_total + $vttc;
                        $cumul_value_ttc=$cumul_value_ttc+($vttc);
                                                        
                        $cumul_value_typerepas = $cumul_value_typerepas + ($distribution['nombre_restant'] * $distribution['price']);
                        $cumul_tva_total = $cumul_tva_total + $cumul_tva;
                        

                        $pdf->Row(array(decode($n), decode($v2), decode($v7), decode($v3), decode($v4), decode($v5), decode($v6),decode($v8),decode($v9)));
                    }
                }
            }
            $pdf->SetTextColor(0, 0, 255);
            $pdf->SetFont('Arial', 'B', 8);
            $cumul_value_total = $cumul_value_total + $cumul_value_typerepas;
            $pdf->Row(array(decode("Total type : " . $cumul_value_typerepas . " USD"), decode(""), decode(""), decode(""), decode(""), decode(""), decode(""), decode(""), decode("")));
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 8);
        }
    }
}

$pdf->Row(array(decode("Nber : " . $n), decode("Grand Total HT : " . $cumul_value_total . " USD"), decode("Grand Total TVA : " . $cumul_tva_total . " USD"), decode("Grand Total TTC : " . $cumul_value_ttc_total . " USD"), decode(""), decode(""), decode(""), decode(""), decode("")));
$pdf->Output("");
?>
