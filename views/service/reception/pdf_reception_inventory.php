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

include("../../../models/pdf-generator/pdfclass.php");

include("../../../models/connexion.php");
include '../../../models/demande/demande.php';
include '../../../models/distribution/distribution.php';
include '../../../models/livraison/livraison.php';
include '../../../models/affectation-service/affectationService.php';
include '../../../models/service/service.php';
include '../../../models/unite/unite.php';
include '../../../models/biens/biens.php';
include '../../../models/ravitaillement/ravitaillement.php';
?>

<?php

// Instanciation de la classe dérivée
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('P');
$pdf->SetTitle("service_store_inventory_" . date('Y-m-d'));
$pdf->SetFont('Arial', 'B', 14);
$titre_document = "Store inventory";
$pdf->Cell(190, 10, utf8_decode($titre_document), 0, 0, 'C');
$pdf->Ln(10);

if (isset($_SESSION['idservice'])) {
    $bdservice = new BdService();
    $services = $bdservice->getServiceById($_SESSION['idservice']);
    foreach ($services as $service) {
        $designation_service = $service['designation'];
    }
}

$pdf->Cell(190, 10, utf8_decode($designation_service), 0, 0, 'C');
$pdf->Ln(10);

if (1) {
    $info_date = date('Y-m-d');
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(190, 10, utf8_decode("Date : ".$info_date), 0, 0, 'C');
    $pdf->Ln(15);
}

$pdf->SetFont('Times', 'B', 8);
$pdf->SetWidths(array(15, 15, 45, 28, 25, 28, 38));
//foreach ($theads as $thead) {
$pdf->Row(array(decode('No'), decode('Id'), decode('Item'), decode('Category'), decode('Actual quantity'), decode('Unit price (USD)'), decode('Actual value (USD)')));
//    $pdf->Cell(18, 7, decode($thead), 1);
//}

$n = 0;
$cumul_value = 0;
$bdlivraison = new BdLivraison();
$bdbiens = new BdBiens();
$biens = $bdbiens->getBiensAll();
$cumul_quantite_actuelle = 0;
foreach ($biens as $bien) {

    $cumul_quantite_actuelle = 0;

    $trouve = FALSE;
    $livraisons = $bdlivraison->getLivraisonWithQuantitePositiveByIdBiens($bien['bId']);
    foreach ($livraisons as $livraison) {
        $livraison_etat = $livraison['lEtat'];
        if ((isset($_GET['date'])) && (($livraison_etat == 0) && ($_GET['date']>=$livraison['lDate']))) {
            if ($livraison['sId']==$_SESSION['idservice']) {
                $trouve = TRUE;
            }
        }
    }
    
    
    
    
    
    if ($trouve) {
        $n++;
        
        
        $n++;
        $v1 = $n;
        $v2 = $bien['bId'];
        $v3 = $bien['bDesignation'];
        $v4 = $bien['gDesignation'];
        
            $livraisons = $bdlivraison->getLivraisonWithQuantitePositiveByIdBiens($bien['bId']);
            foreach ($livraisons as $livraison) {
                $livraison_etat = $livraison['lEtat'];
                if ($livraison_etat == 0) {
                    if ($livraison['sId']==$_SESSION['idservice']) {
                        $cumul_quantite_actuelle = $cumul_quantite_actuelle + $livraison['quantite_actuelle'];
                    }
                }
            }

            $somme_prix_biens = 0;
            $s = 0;
            $bdravitaillement = new BdRavitaillement();
            $ravitaillements = $bdravitaillement->getRavitaillementByIdBiens($bien['bId']);
            foreach ($ravitaillements as $ravitaillement) {
                $s++;
                $somme_prix_biens = $somme_prix_biens + $ravitaillement['prix'];
            }
            
            $average_price = 0;
            
            if ($s>0) {
                $average_price = ($somme_prix_biens / $s);
            }
            
            
            $v5 = $cumul_quantite_actuelle;
            $v6 = round($average_price,3);
    
            $v7 = round(($cumul_quantite_actuelle * $average_price),3);
            $cumul_value = round(($cumul_value + ($cumul_quantite_actuelle * $average_price)),3);
            
        
        $pdf->Row(array(decode($v1), decode($v2), decode($v3), decode($v4), decode($v5), decode($v6), decode($v7)));
    }
    
    

}

$pdf->Row(array(decode("Nber : " . $n), decode(""), decode(""), decode(""), decode(""), decode(""), decode("Total value : " . $cumul_value . " USD")));

$pdf->Output("");
?>
