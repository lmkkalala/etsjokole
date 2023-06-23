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
include '../../../models/biens/biens.php';
include '../../../models/inventaire/inventaire.php';
include '../../../models/ravitaillement/ravitaillement.php';
?>

<?php

// Instanciation de la classe dérivée
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('P');
$pdf->SetTitle("phyisic_inventory_");
$info_date="";
if (isset($_GET['use_date1'])) {
    $info_date = "Starting date : " . $_GET['use_date1'] . " / Ending date : " . $_GET['use_date2'];
}
$pdf->SetFont('Arial', 'B', 14);
$titre_document = "Physic inventory";
$pdf->Cell(190, 10, utf8_decode($titre_document), 0, 0, 'C');
$pdf->Ln(15);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(190, 10, utf8_decode($info_date), 0, 0, 'C');
$pdf->Ln(15);
$pdf->SetFont('Times', 'B', 8);
$pdf->SetWidths(array(15, 25, 50, 18, 15, 15, 18, 18, 18));
//foreach ($theads as $thead) {
$pdf->Row(array(decode('NO'), decode('Date'), decode('Item'), decode('Virtual Qty'), decode('real Qty'), decode('Variance'), decode('Variance Value (USD)'), decode('Comment'), decode('State')));
//    $pdf->Cell(18, 7, decode($thead), 1);
//}
$n = 0;
$bdinventaire = new BdInventaire();
if (((isset($_GET['use_date1'])) && (isset($_GET['use_date2']))) && (($_GET['use_date1'] != "") && ($_GET['use_date2'] != ""))) {
    $inventaires = $bdinventaire->getInventaireBeetwen2Dates($_GET['use_date1'], $_GET['use_date2']);
} else {
    $inventaires = $bdinventaire->getInventaireAllDesc();
}

$cumul_value_ecart = 0;
foreach ($inventaires as $inventaire) {
    if (1) {
        $n++;
        $v1 = $n;
        $v2 = $inventaire['iDate'];
        $v3 = $inventaire['bDesignation'] . " / " . $inventaire['gDesignation'];
        $v4 = $inventaire['quantite'];
        $v5 = $inventaire['iQuantite'];

        $somme_prix_biens = 0;
        $s = 0;
        $bdravitaillement = new BdRavitaillement();
        $ravitaillements = $bdravitaillement->getRavitaillementByIdBiens($inventaire['bId']);
        foreach ($ravitaillements as $ravitaillement) {
            $s++;
            $somme_prix_biens = $somme_prix_biens + $ravitaillement['prix'];
        }

        $average_price = ($somme_prix_biens / $s);

        if ($inventaire['validation'] == 0) {
            $v6 = $inventaire['iEcart'];
        } else {
            $v6 = 0;
        }

        if ($inventaire['validation'] == 0) {
            $v7 = ($inventaire['iEcart'] * $average_price);
        } else {
            $v7 = 0;
        }


        if ($inventaire['validation'] == 0) {
            $cumul_value_ecart = $cumul_value_ecart + $v6;
        }
        $v8 = $inventaire['nom'] . " " . $inventaire['postnom'] . " " . $inventaire['prenom'];
        $v9 = $inventaire['commentaire'];

        if ($inventaire['validation'] == 0) {
            $v10 = "";
        } else {
            $v10 = "Equalized";
        }
    }

    $pdf->Row(array(decode($v1), decode($v2), decode($v3), decode($v4), decode($v5), decode($v6), decode($v7), decode($v9), decode($v10)));
}

$pdf->Row(array(decode("Nber : " . $n), decode("Total value : " . $cumul_value_ecart . " USD "), decode(""), decode(""), decode(""), decode(""), decode(""), decode(""), decode("")));

$pdf->Output("");
?>
