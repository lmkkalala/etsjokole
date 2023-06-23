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
?>

<?php

// Instanciation de la classe dérivée
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('P');
$pdf->SetTitle("liste_biens_all");
$pdf->SetFont('Arial', 'B', 14);
$titre_document = "Item list";
$pdf->Cell(190, 10, utf8_decode($titre_document), 0, 0, 'C');
$pdf->Ln(15);
$pdf->SetFont('Times', 'B', 8);
$pdf->SetWidths(array(15, 45, 18, 18, 40, 18, 18, 18));
//foreach ($theads as $thead) {
$pdf->Row(array(decode('NO'), decode('Name'), decode('Group'), decode('Perissable'), decode('Qty'), decode('UP (USD)'),decode('Value (USD)'), decode('Active')));
//    $pdf->Cell(18, 7, decode($thead), 1);
//}
$n = 0;
$bdbiens = new BdBiens();
$biens = $bdbiens->getBiensAllDesc();
foreach ($biens as $bien) {
    $n++;
    $v1 = $bien['bId'];
    $v2 = $bien['bDesignation'];
    $v3 = $bien['gDesignation'];
    if ($bien['type_perissable']) {
        $v4 = 'Yes';
    } else {
        $v4 = 'No';
    }
    $v7 = $bien['prixunitaire'];
    $v9=$bien['quantite'];
    if ($bien['active'] == 1) {

        $v10='Enabled';
    } else {
        $v10='Disabled';
    }
    $v11=($bien['prixunitaire']*$bien['quantite']);

    $pdf->Row(array(decode($v1), decode($v2), decode($v3), decode($v4), decode($v9), decode($v7), decode($v11), decode($v10)));
}
$pdf->Row(array(decode("Nber : ".$n), decode(""), decode(""), decode(""), decode(""), decode(""), decode(""), decode("")));
$pdf->Output("");
?>
